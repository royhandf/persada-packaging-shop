<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BiteshipService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.biteship.key');
        $this->baseUrl = config('services.biteship.url');
    }

    private function client()
    {
        return Http::withToken($this->apiKey);
    }

    public function getRates($originAreaId, $destinationAreaId, $items, $couriers)
    {
        $payload = [
            "origin_area_id"        => $originAreaId,
            "destination_area_id"   => $destinationAreaId,
            "items"                 => $items,
        ];

        if (!empty($couriers)) {
            $payload['couriers'] = $couriers;
        }

        $response = $this->client()->post("{$this->baseUrl}/rates/couriers", $payload);

        return $response->json();
    }

    public function searchAreas($query)
    {
        $response = $this->client()->get("{$this->baseUrl}/maps/areas", [
            "countries" => "ID",
            "input"     => $query
        ]);

        return $response->json();
    }

    public function track($waybillId, $courierCode)
    {
        $response = $this->client()->get("{$this->baseUrl}/trackings/{$waybillId}?courier_code={$courierCode}");
        return $response->json();
    }
}
