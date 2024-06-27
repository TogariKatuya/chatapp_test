<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * 検索リクエストを処理し、Google Books APIを使用して本を検索します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // リクエストからクエリを取得
        $query = $request->input('query');

        // クエリが空の場合は、エラーメッセージを表示して前のページにリダイレクト
        if (!$query) {
            return redirect()->back()->with('error', 'Please enter a search query.');
        }

        // 検索結果の最大数と開始インデックスの設定
        $maxResults = 40;
        $startIndex = 0;

        // Google Books APIのベースURLとクエリを結合してURLを生成
        $base_url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($query);
        $url = $base_url . '&maxResults=' . $maxResults . '&startIndex=' . $startIndex;

        // URLからJSONデータを取得
        $json = file_get_contents($url);

        // JSONデータをPHPオブジェクトにデコード
        $data = json_decode($json);

        // 検索結果の本の情報を取得（itemsが存在する場合は取得し、存在しない場合は空の配列をセット）
        $books = isset($data->items) ? $data->items : [];

        // 検索結果をビューに渡して表示
        return view('search_results', compact('books'));
    }
}
