<?php

namespace App\Repositories;

interface BookRepositoryInterface
{
    public function searchBooks($query, $maxResults, $startIndex);
}
