<?php

namespace App\Services;

use App\Repositories\BookRepositoryInterface;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function searchBooks($query, $maxResults, $startIndex)
    {
        return $this->bookRepository->searchBooks($query, $maxResults, $startIndex);
    }
}
