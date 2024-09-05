<?php

namespace App\Repositories;

interface ShortUrlRepositoryInterface
{
    public function create(array $data);
    public function findByShortCode(string $shortCode);
}
