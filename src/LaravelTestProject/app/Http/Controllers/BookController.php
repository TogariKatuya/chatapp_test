<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function search(Request $request)
    {
        // 検索条件を配列にする
        $params = array(
            'intitle' => $_POST["query"],
        );

        // 半角，全角の空白削除
        $params["intitle"] = str_replace(array(" ", "　"), "", $params["intitle"]);

        $maxResults = 40;
        $startIndex = 0;

        $base_url = 'https://www.googleapis.com/books/v1/volumes?q=';

        // クエリ未入力の時
        // if ($params["intitle"] == "" && $params["inauthor"] == "") {
        //     set_message(MESSAGE_NO_QUERY);
        //     header('Location: post_search.php');
        //     exit();
        // }

        // クエリが未入力でなければURLに追加
        if ($params["intitle"] != "") {
            $base_url .= 'intitle:' . $params["intitle"] . '+';
        }

        $params_url = substr($base_url, 0, -1);  // 末尾につく「+」を削除
        $url = $params_url . '&maxResults=' . $maxResults . '&startIndex=' . $startIndex; // 最大40冊取得
        $json = file_get_contents($url);  // 書籍情報を取得
        $data = json_decode($json);  // デコード（objectに変換）

        if (isset($data->items)) {
            $books = $data->items;
        }
        function get_author($book)
        {
            $author_count = 0;
            $all_author = "";

            foreach ($book->volumeInfo->authors as $author) {
                if ($author_count < 2) {
                    $all_author .= ($all_author ? ' ' : '') . $author;
                }
                $author_count++;
            }

            if ($author_count > 2) {
                $all_author .= ' ...etc';
            }

            return $all_author;
        }

        function create_block($book, $count)
        {
            $image_link = $book->volumeInfo->imageLinks->thumbnail;
            $title = $book->volumeInfo->title;
            $author = get_author($book);

            if (strlen($title) > 23) {
                $title = mb_substr($title, 0, 6, "UTF-8") . '...';
            }
            print ("
                <img src=$image_link alt='画像'>
                <div>
                    <hr>
                    <h4> <b>『 $title 』</b> </h4>
                    著者：$author ");
            print ("</div>");
        }


    }
}
