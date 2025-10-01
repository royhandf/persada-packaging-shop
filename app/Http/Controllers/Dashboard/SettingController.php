<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use App\Services\BiteshipService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    protected $biteship;

    public function __construct(BiteshipService $biteship)
    {
        $this->biteship = $biteship;
    }

    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();


        return view('pages.dashboard.setting', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'shipping_origin_latitude' => 'nullable|numeric|between:-90,90',
            'shipping_origin_longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $data = $request->except('_token');

        $checkboxKeys = [
            'payment_bca_va_active',
            'payment_bri_va_active',
            'payment_bni_va_active',
            'payment_mandiri_va_active',
            'payment_qris_active',
            'payment_gopay_active',
            'payment_shopeepay_active',
            'payment_dana_active'
        ];

        foreach ($checkboxKeys as $key) {
            if (!isset($data[$key])) {
                $data[$key] = '0';
            }
        }

        if (isset($data['shipping_active_couriers'])) {
            $data['shipping_active_couriers'] = json_encode($data['shipping_active_couriers']);
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        if ($request->has('shipping_origin_area_id') && $request->has('shipping_origin_area_name')) {
            Setting::updateOrCreate(
                ['key' => 'shipping_origin_area_name'],
                ['value' => $request->shipping_origin_area_name]
            );
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function searchSenderLocation(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $results = $this->biteship->searchAreas($request->q);

        return response()->json($results);
    }
}
