<?php

namespace App\Repositories;

use App\Models\Models\ShortUrl;

class ShortUrlRepository implements ShortUrlRepositoryInterface
{

    /**
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return ShortUrl::create($data);
    }

    /**
     *
     * @param string $shortCode
     * @return mixed
     */
    public function findByShortCode(string $shortCode)
    {
        return ShortUrl::where('short_code', $shortCode)->first();
    }
}
