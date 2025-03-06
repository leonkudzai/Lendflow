<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\NYTBooksAPIRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\NYTimesService;
use Illuminate\Support\Facades\Cache;

class NYTBooksController extends Controller
{
    protected NYTimesService $nytService;

    public function __construct(NYTimesService $nytService)
    {
        $this->nytService = $nytService;
    }

    public function index(NYTBooksAPIRequest $request): JsonResponse
    {
        //validating data before processing
        $validated = $request->validated();

        //Caching data
        $cacheKey = 'nyt_bestsellers_' . md5(json_encode($validated));
        // Check if the data exists in the cache
        //Only caching data for 10 minutes
        $data = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($validated) {
            // If not in cache, call the NYTimes API
            $nytData = $this->nytService->getBestSellers($validated);
            if(!isset($nytData['error'])){
                return $nytData;
            }

            //Avoiding caching errors
            return null;
        });

        //Showing error instead of null data
        if ($data === null) {
            return response()->json([
                'error' => 'Invalid response from NYTimes API',
                'status' => 'error'
            ], 500);
        }

        return response()->json($data) ;
    }
}
