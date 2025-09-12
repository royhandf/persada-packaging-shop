<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key');
        $this->baseUrl = config('services.rajaongkir.url');
    }

    private function client()
    {
        return Http::withHeaders([
            'key' => $this->apiKey,
        ]);
    }

    public function getProvinces()
    {
        $response = $this->client()->get("{$this->baseUrl}/destination/province");

        return $response->json();
    }

    public function getCities($provinceId)
    {
        $response = $this->client()->get("{$this->baseUrl}/destination/city/{$provinceId}");

        return $response->json() ?? [];
    }

    public function getDistricts($cityId)
    {
        $response = $this->client()->get("{$this->baseUrl}/destination/district/{$cityId}");
        return $response->json() ?? [];
    }

    public function getDomesticCouriers()
    {
        return [
            ['code' => 'jne', 'name' => 'JNE'],
            ['code' => 'sicepat', 'name' => 'SiCepat Express'],
            ['code' => 'jnt', 'name' => 'J&T Express'],
            ['code' => 'anteraja', 'name' => 'Anteraja']
        ];
    }

    public function calculateCost($origin, $destination, $weight, $courier)
    {
        $response = $this->client()->post("{$this->baseUrl}/destination/cost", [
            'origin'        => $origin,
            'destination'   => $destination,
            'weight'        => $weight,
            'courier'       => $courier,
        ]);
        return $response->json()['rajaongkir']['results'] ?? [];
    }
}