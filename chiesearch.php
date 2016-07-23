<?php
/**
 * APIへのリクエスト（GET）
 *
 */

// コマンドライン引数から検索キーワードを取得
$query = $argv[1];
if (empty($argv[1])){
    print('Please input a query!');
    exit;
}

// 質問検索API
$api = 'http://chiebukuro.yahooapis.jp/Chiebukuro/V1/questionSearch';
// アプリケーションID
$appid = '';    // 登録時のアプリケーションIDを入力する
// 質問文に含まれる文字列をクエリで渡す
$params = array(
    'query'     => $query,       /* 検索キーワードを指定 */
    'condition' => 'solved',     /* 解決済みの質問 */
    'sort'      => '-anscount',  /* 回答数順で降順にソート */
    'results'   => 100           /* 返却結果の数 */
);

// リクエスト用のURLを生成
$url = $api . '?appid=' . $appid . '&' . http_build_query($params);

// XML形式のレスポンスを取得
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_xml = curl_exec($ch);
curl_close($ch);

// XML文字列を連想配列に変形
$xml_obj = simplexml_load_string($response_xml);

// 質問文とベストアンサーを出力
foreach ($xml_obj->{'Result'}->{'Question'} as $que) {
    print($que->{'Content'});
    print($que->{'BestAnswer'});
}

?>

