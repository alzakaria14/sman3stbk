<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateSchoolSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'school_name' => ['required', 'string', 'max:255'],
            'site_name' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', File::image()->max(2048)],
            'remove_logo' => ['sometimes', 'boolean'],
            'hero_image' => ['nullable', File::image()->max(4096)],
            'remove_hero_image' => ['sometimes', 'boolean'],
            'npsn' => ['nullable', 'string', 'max:50'],
            'accreditation' => ['nullable', 'string', 'max:50'],
            'principal_name' => ['nullable', 'string', 'max:255'],
            'established_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'establishment_decree' => ['nullable', 'string', 'max:255'],
            'operational_permit' => ['nullable', 'string', 'max:255'],
            'school_schedule' => ['nullable', 'string', 'max:255'],
            'coordinates' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'about' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'employee_data' => ['nullable', 'string'],
        ];
    }
}
