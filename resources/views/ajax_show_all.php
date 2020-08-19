<?php
require_once './conf/const.php';
require_once './model/tool_model.php';
require_once './model/index_model.php';
$sql      = '';
$sqltype  = '';
$imgdir   = './img/';
$error    = [];
$result   = [];
$data     = [];
$sample   = [];

$search_word   = '';
$template_word = '';

$dbh = get_db_connect();

if(isset($_POST['search_word'])=== true){
    $search_word = "";
    $data = [];
    $search_array = [];
    $search_string = '';
    $offset = '';
    $search_word = $_POST['search_word'];
    $offset = $_POST['offset'];

    $search_word = str_replace("　"," ",$search_word);
    $search_array = explode(" ", $search_word);
    $search_words = [];
    $search_sql = [];
    foreach($search_array as $value){
        $search_sql[] = ' items.item_name LIKE ? OR  caption LIKE ? OR  category_name LIKE ? ';
        $search_words[] = '%'.$value.'%';
        $search_words[] = '%'.$value.'%';
        $search_words[] = '%'.$value.'%';
    }
    $search_words[] = $offset;
    $sample = sample_items_search($dbh, $search_sql,  $search_words);
}elseif(isset($_POST['template_word'])=== true){
    $template_word = $_POST['template_word'];
    $sample = get_template($dbh, $template_word);
}

$sample = change_htmlsp_array($sample);
$data = caption_add_number($sample);

// ヘッダーを指定することによりjsonの動作を安定させる
header('Content-type: application/json');
// htmlへ渡す配列$productListをjsonに変換する
echo json_encode($data);