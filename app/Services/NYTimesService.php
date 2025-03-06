<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NYTimesService
{
    protected string $baseUrl = "https://api.nytimes.com/";

    public function getBestSellers($data)
    {
        //Sending data NYT API
        $dataToSend['api-key'] = env('NYTIMES_KEY');
        foreach ($data as $key => $value) {
            $dataToSend[$key] = $value;
        }

        try {
            $response = Http::get("{$this->baseUrl}svc/books/v3/lists/best-sellers/history.json",
                $dataToSend
            );
            if ($response->successful()) {
                return $response->json();
            } else {
                return ['error' => true, 'message' => "Failed to retrieve data from {$this->baseUrl}", 'status' => $response->status()];
            }
        }catch (\Exception $e){
            //Error which might be caused by failing to connect to nytimes
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
