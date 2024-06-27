<?php

namespace App\Repositories;

class GoogleBooksRepository implements BookRepositoryInterface
{
    protected $baseUrl = 'https://www.googleapis.com/books/v1/volumes';

    public function searchBooks($query, $maxResults, $startIndex)
    {
        $url = $this->baseUrl . '?q=' . urlencode($query) . '&maxResults=' . $maxResults . '&startIndex=' . $startIndex;

        $json = file_get_contents($url);
        $data = json_decode($json);

        return isset($data->items) ? $data->items : [];
    }
}
