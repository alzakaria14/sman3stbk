<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;

abstract class NewsPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    /**
     * @return array<string, mixed>
     */
    protected function newsPostRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash:ascii'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', File::image()->max('4mb')],
            'is_published' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    /**
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $content = (string) $this->input('content', '');
                $plainText = Str::of(html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5, 'UTF-8'))
                    ->replace("\u{00A0}", ' ')
                    ->squish();

                if ($plainText->isEmpty() && ! Str::contains(Str::lower($content), '<img')) {
                    $validator->errors()->add('content', 'Isi berita wajib diisi.');
                }
            },
        ];
    }
}
