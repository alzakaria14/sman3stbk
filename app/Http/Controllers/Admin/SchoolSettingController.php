<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSchoolSettingRequest;
use App\Models\SchoolSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class SchoolSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'setting' => SchoolSetting::current(),
        ]);
    }

    public function update(UpdateSchoolSettingRequest $request): RedirectResponse
    {
        $setting = SchoolSetting::current();
        $data = $request->safe()->except(['logo', 'hero_image', 'remove_logo', 'remove_hero_image']);

        if ($request->boolean('remove_logo')) {
            $this->deletePublicFile($setting->logo_path);
            $data['logo_path'] = null;
        }

        if ($request->boolean('remove_hero_image')) {
            $this->deletePublicFile($setting->hero_image_path);
            $data['hero_image_path'] = null;
        }

        if ($request->hasFile('logo')) {
            $this->deletePublicFile($setting->logo_path);
            $data['logo_path'] = $request->file('logo')->store('school', 'public');
        }

        if ($request->hasFile('hero_image')) {
            $this->deletePublicFile($setting->hero_image_path);
            $data['hero_image_path'] = $request->file('hero_image')->store('school', 'public');
        }

        $setting->update($data);

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Identitas sekolah berhasil diperbarui.');
    }

    private function deletePublicFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
