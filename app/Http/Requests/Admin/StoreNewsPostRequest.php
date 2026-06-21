<?php

namespace App\Http\Requests\Admin;

class StoreNewsPostRequest extends NewsPostRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->newsPostRules();
    }
}
