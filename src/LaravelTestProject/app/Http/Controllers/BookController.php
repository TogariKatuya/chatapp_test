<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BookRepositoryInterface;

class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * 検索リクエストを処理し、Google Books APIを使用して本を検索します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->back()->with('error', 'Please enter a search query.');
        }

        $maxResults = 40;
        $startIndex = 0;

        $books = $this->bookRepository->searchBooks($query, $maxResults, $startIndex);

        return view('search_results', compact('books'));
    }
}
