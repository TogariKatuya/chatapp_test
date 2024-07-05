<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Config;

class GoogleBooksRepository implements BookRepositoryInterface
{
    protected $baseUrl;
    public function __construct()
    {
        $this->baseUrl = Config::get('services.googlebooks.api_url');
    }

    /**
     * Google Books API を使用して本を検索します。
     *
     * @param string $query
     * @param int $maxResults
     * @param int $startIndex
     * @return array
     */
    public function searchBooks($query, $maxResults, $startIndex)
    {
        $url = $this->baseUrl . '?q=' . urlencode($query) . '&maxResults=' . $maxResults . '&startIndex=' . $startIndex;

        $json = file_get_contents($url);
        $data = json_decode($json);

        return isset($data->items) ? $data->items : [];
    }
}
