<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    /**
     * Create a new class instance.
     */

    private $baseUrl;
    private $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.api.url');
        $this->apiKey = config('services.api.key');
    }

    public function fetch($controller, $dateFrom, $dateTo, $page = 1, $limit = 100)
    {
        try {
            $response = Http::get($this->baseUrl . '/api/' . $controller, ['dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'page' => $page, 'key' => $this->apiKey, 'limit' => $limit]);

            //Log::info("API Request: {$this->baseUrl}/api/{$controller}");
            //Log::info("API Status: " . $response->status());
            //Log::info("API Headers: " . json_encode($response->headers()));
            //Log::info("API Data: " . json_encode($response->json()));

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('API ошибка: ' . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            Log::error('API исключение: ' . $e->getMessage());
            return null;
        }
    }
}
