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
        // 自定義驗證和錯誤處理
        try {
            $request->validate([
                'url' => 'required|url|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => '無效的輸入',
                'messages' => $e->errors(),
            ], 400);  // 返回400狀態碼
        }

        // 嘗試生成短網址
        try {
            $shortUrl = $this->urlService->createShortUrl($request->url);
            $fullShortUrl = url($shortUrl);  // 生成完整的短網址
        } catch (\Exception $e) {

            return response()->json(['error' => '無法生成短網址'], 500);
        }

        // 返回成功響應
        return response()->json(['short_url' => $fullShortUrl], 201);
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
