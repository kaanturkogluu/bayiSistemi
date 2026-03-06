<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvoiceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the invoice settings form.
     */
    public function invoice()
    {
        // Get the first record, if none exists it simply won't have values on the view initially.
        $setting = InvoiceSetting::first();

        return view('admin.settings.invoice', compact('setting'));
    }

    /**
     * Update the invoice settings.
     */
    public function updateInvoice(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $setting = InvoiceSetting::first();

        if (!$setting) {
            $setting = new InvoiceSetting();
        }

        // Handle File Upload
        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($setting->logo_path && Storage::disk('public')->exists($setting->logo_path)) {
                Storage::disk('public')->delete($setting->logo_path);
            }

            $path = $request->file('logo')->store('logos', 'public');
            $setting->logo_path = $path;
        }

        $setting->company_name = $validated['company_name'];
        $setting->address = $validated['address'];
        $setting->city = $validated['city'];
        $setting->phone = $validated['phone'];
        $setting->email = $validated['email'];

        $setting->save();

        return redirect()->route('admin.settings.invoice')->with('success', 'Fatura ayarları başarıyla güncellendi.');
    }
}
