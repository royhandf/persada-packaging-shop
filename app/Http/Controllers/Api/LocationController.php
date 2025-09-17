<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }

    public function provinces()
    {
        return response()->json($this->rajaOngkirService->getProvinces());
    }

    public function cities($provinceId)
    {
        return response()->json($this->rajaOngkirService->getCities($provinceId));
    }

    public function districts($cityId)
    {
        return response()->json($this->rajaOngkirService->getDistricts($cityId));
    }
}
