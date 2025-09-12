<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();

        $rajaOngkirCouriers = $this->rajaOngkir->getDomesticCouriers();

        return view('pages.dashboard.setting', compact('settings', 'rajaOngkirCouriers'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        $rajaOngkirCouriers = $this->rajaOngkir->getDomesticCouriers();

        $checkboxKeys = [];
        foreach ($rajaOngkirCouriers as $courier) {
            $checkboxKeys[] = 'shipping_' . $courier['code'] . '_active';
        }

        $checkboxKeys = array_merge($checkboxKeys, [
            'payment_bca_active',
            'payment_qris_active'
        ]);

        foreach ($checkboxKeys as $key) {
            if (!isset($data[$key])) {
                $data[$key] = '0';
            }
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function provinces()
    {
        return $this->rajaOngkir->getProvinces();
    }

    public function cities($provinceId)
    {
        return $this->rajaOngkir->getCities($provinceId);
    }

    public function districts($cityId)
    {
        return $this->rajaOngkir->getDistricts($cityId);
    }
}