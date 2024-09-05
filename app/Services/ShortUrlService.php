<?php

namespace App\Services;

use App\Repositories\ShortUrlRepositoryInterface;

class ShortUrlService
{
    protected $urlRepository;

    public function __construct(ShortUrlRepositoryInterface $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    /**
     *
     * @param string $originalUrl
     * @return string
     */
    public function createShortUrl(string $originalUrl): string
    {
        $shortCode = $this->generateShortCode();
        $this->urlRepository->create([
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
        ]);

        return $shortCode;
    }

    /**
     * @param string $shortCode
     * @return string
     */
    public function getOriginalUrl(string $shortCode): ?string
    {
        $url = $this->urlRepository->findByShortCode($shortCode);
        return $url ? $url->original_url : '';
    }

    /**
     * @return string
     */
    protected function generateShortCode(): string
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
    }
}
