<?php

namespace App\Http\Controllers;

use App\Services\ShortUrlService;
use Illuminate\Http\Request;

class ShortenerUrlController extends Controller
{
    protected $urlService;

    public function __construct(ShortUrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:2048',
        ]);

        try {

            $shortUrl = $this->urlService->createShortUrl($request->url);

            return response()->json(['short_url' => $shortUrl], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create short URL.'], 500);
        }
    }

    public function redirect($short_code)
    {
        $url = $this->urlService->getOriginalUrl($short_code);

        if (!$url) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return redirect($url);
    }

    public function lookup($short_code)
    {
        $url = $this->urlService->getOriginalUrl($short_code);

        if (!$url) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json(['original_url' => $url], 200);
    }
}
