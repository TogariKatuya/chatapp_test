<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * 検索リクエストを処理し、Google Books APIを使用して本を検索します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // クエリのバリデーション
        $request->validate([
            'query' => 'required|string',
        ], [
            'query.required' => '検索ワードが未入力です。',
        ]);

        // リクエストからクエリを取得
        $query = $request->input('query');

        // ページネーションのためのパラメータを取得
        $perPage = 10;
        $page = $request->input('page', 1);
        $startIndex = ($page - 1) * $perPage;

        // 検索結果の最大数と開始インデックスの設定
        $maxResults = 10;

        $books = $this->bookService->searchBooks($query, $maxResults, $startIndex);

        // 検索結果をビューに渡して表示
        return view('search_results', [
            'books' => $books,
            'query' => $query,
            'currentPage' => $page,
            'perPage' => $perPage
        ]);
    }

}
