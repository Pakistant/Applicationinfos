<?php

namespace App\Http\Controllers;
use App\Models\Settings;
use App\Http\Requests\SettingsRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('Admin.settings.index', [
            'settings' => Settings::first(),
        ]);
    }

    public function update(SettingsRequest $request)
    {
        $data = $request->validated();

        $settings = Settings::first();
        $logoPath = $settings?->logo;

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo')->store('asset', 'public');
        }

        if (! $settings) {
            Settings::create([
                'web_site_name' => $data['web_site_name'],
                'logo' => $logoPath,
                'address' => $data['address'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'about' => $data['about'],
            ]);
        } else {
            $settings->update([
                'web_site_name' => $data['web_site_name'],
                'logo' => $logoPath,
                'address' => $data['address'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'about' => $data['about'],
            ]);
        }

        return back()->with('success', 'Paramètre modifié avec succès');
    }
}
