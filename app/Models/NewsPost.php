<?php

namespace App\Models;

use Database\Factories\NewsPostFactory;
use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsPost extends Model
{
    /** @use HasFactory<NewsPostFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    private const ALLOWED_CONTENT_TAGS = [
        'a',
        'b',
        'blockquote',
        'br',
        'em',
        'h2',
        'h3',
        'i',
        'img',
        'li',
        'ol',
        'p',
        'pre',
        's',
        'strong',
        'u',
        'ul',
    ];

    /**
     * @var list<string>
     */
    private const REMOVED_CONTENT_TAGS = [
        'iframe',
        'math',
        'object',
        'script',
        'style',
        'svg',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_path',
        'is_published',
        'published_at',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param  Builder<NewsPost>  $query
     * @return Builder<NewsPost>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * @return BelongsTo<User, NewsPost>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isPublished(): bool
    {
        return $this->is_published && $this->published_at !== null && $this->published_at->lte(now());
    }

    public function hasRichContent(): bool
    {
        return preg_match('/<(a|blockquote|h2|h3|img|li|ol|p|pre|ul)\b/i', $this->content) === 1;
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * @return Attribute<string, string>
     */
    protected function content(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value): string => $this->sanitizeContent((string) $value),
            set: fn (?string $value): string => $this->sanitizeContent((string) $value),
        );
    }

    /**
     * @return Attribute<string, never>
     */
    protected function featuredImageUrl(): Attribute
    {
        return Attribute::get(function (): string {
            if ($this->featured_image_path) {
                return Storage::disk('public')->url($this->featured_image_path);
            }

            $fallbacks = [
                'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=1600&q=80',
            ];

            return $fallbacks[abs(crc32($this->slug ?: $this->title)) % count($fallbacks)];
        });
    }

    private function sanitizeContent(string $content): string
    {
        if (trim($content) === '') {
            return '';
        }

        if (preg_match('/<\s*\/?\s*[a-z][^>]*>/i', $content) !== 1) {
            return $content;
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $previousErrorHandling = libxml_use_internal_errors(true);

        $document->loadHTML(
            '<?xml encoding="utf-8" ?><div id="news-content-root">'.$content.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD,
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previousErrorHandling);

        $root = $document->getElementById('news-content-root');

        if (! $root instanceof DOMElement) {
            return '';
        }

        $this->sanitizeChildNodes($root);

        $sanitizedContent = '';

        foreach ($root->childNodes as $childNode) {
            $sanitizedContent .= $document->saveHTML($childNode);
        }

        return trim($sanitizedContent);
    }

    private function sanitizeChildNodes(DOMNode $parent): void
    {
        $childNodes = [];

        foreach ($parent->childNodes as $childNode) {
            $childNodes[] = $childNode;
        }

        foreach ($childNodes as $childNode) {
            if ($childNode->nodeType === XML_COMMENT_NODE) {
                $parent->removeChild($childNode);

                continue;
            }

            if (! $childNode instanceof DOMElement) {
                continue;
            }

            $tagName = Str::lower($childNode->tagName);

            if (in_array($tagName, self::REMOVED_CONTENT_TAGS, true)) {
                $parent->removeChild($childNode);

                continue;
            }

            if (! in_array($tagName, self::ALLOWED_CONTENT_TAGS, true)) {
                $this->sanitizeChildNodes($childNode);
                $this->unwrapElement($childNode);

                continue;
            }

            if (! $this->sanitizeElementAttributes($childNode)) {
                $parent->removeChild($childNode);

                continue;
            }

            $this->sanitizeChildNodes($childNode);
        }
    }

    private function sanitizeElementAttributes(DOMElement $element): bool
    {
        $attributes = [];

        foreach ($element->attributes as $attribute) {
            $attributes[Str::lower($attribute->name)] = $attribute->value;
        }

        foreach (array_keys($attributes) as $attributeName) {
            $element->removeAttribute($attributeName);
        }

        $classes = collect(preg_split('/\s+/', $attributes['class'] ?? '', -1, PREG_SPLIT_NO_EMPTY))
            ->filter(fn (string $class): bool => preg_match('/^ql-(align-(center|right|justify)|direction-rtl|indent-[1-8])$/', $class) === 1)
            ->implode(' ');

        if ($classes !== '') {
            $element->setAttribute('class', $classes);
        }

        if ($element->tagName === 'a') {
            $href = trim($attributes['href'] ?? '');

            if ($this->isSafeUrl($href, ['http', 'https', 'mailto', 'tel'])) {
                $element->setAttribute('href', $href);

                if (Str::startsWith($href, ['http://', 'https://'])) {
                    $element->setAttribute('target', '_blank');
                    $element->setAttribute('rel', 'noopener noreferrer');
                }
            }
        }

        if ($element->tagName === 'img') {
            $source = trim($attributes['src'] ?? '');

            if (! $this->isSafeUrl($source, ['http', 'https'])) {
                return false;
            }

            $element->setAttribute('src', $source);
            $element->setAttribute('alt', trim($attributes['alt'] ?? ''));
            $element->setAttribute('loading', 'lazy');
        }

        return true;
    }

    /**
     * @param  list<string>  $allowedSchemes
     */
    private function isSafeUrl(string $url, array $allowedSchemes): bool
    {
        if ($url === '') {
            return false;
        }

        if (Str::startsWith($url, '#')) {
            return true;
        }

        if (Str::startsWith($url, '/') && ! Str::startsWith($url, '//')) {
            return true;
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);

        return is_string($scheme) && in_array(Str::lower($scheme), $allowedSchemes, true);
    }

    private function unwrapElement(DOMElement $element): void
    {
        $parent = $element->parentNode;

        if (! $parent) {
            return;
        }

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }
}
