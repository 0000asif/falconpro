<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('setting.index', compact('settings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'logo' => 'nullable|file|mimes:png,jpg,gif,|max:2048',
            'fav_icon' => 'nullable|file|mimes:png,jpg,gif,|max:2048',
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $update = $request->all();
            $update['user_id'] = Auth::user()->id;

            $setting = Setting::findOrFail($id);

            // Save the current file paths for possible deletion later
            $currentLogo = $setting->logo;
            $currentFavicon = $setting->fav_icon;

            // Update the text fields and columns
            $setting->update($update);

            // Handle file uploads
            if ($request->hasFile('logo')) {
                $logoName = time() . '_logo.' . $request->logo->extension();
                $request->logo->move(public_path('image/setting'), $logoName);
                $setting->update(['logo' => $logoName]);
                if ($currentLogo) {
                    File::delete(public_path('image/setting') . '/' . $currentLogo);
                }
            }

            if ($request->hasFile('fav_icon')) {
                $faviconName = time() . '_favicon.' . $request->fav_icon->extension();
                $request->fav_icon->move(public_path('image/setting'), $faviconName);
                $setting->update(['fav_icon' => $faviconName]);
                if ($currentFavicon) {
                    File::delete(public_path('image/setting') . '/' . $currentFavicon);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Setting updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'Something went wrong: ' . $e->getMessage());
        }
    }
}