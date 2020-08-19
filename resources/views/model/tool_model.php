<?php

$error = [];
$data = [];
$result = [];
//データベースに接続　tool、index
function get_db_connect() {
  try {
    $dbh = new PDO(DSN, DB_USER, DB_PASSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => DB_CHARSET));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch (PDOException $e) {
    throw $e;
  }
  return $dbh;
}

//sql実行 tool、index
function sql_prepare_execute_get($sql, $dbh, $bindData=array()) {
    $prepare = $dbh->prepare($sql);
    $prepare->execute($bindData);
    $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

//エラー表示 tool
function error_display($error){
    foreach ($error as $read) { 
        print $read."<br>";
    }
}

function entity_str($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function change_htmlsp_array($assoc_array) {
  foreach ($assoc_array as $key => $value) {
    foreach ($value as $keys => $values) {
      // 特殊文字をHTMLエンティティに変換
      $assoc_array[$key][$keys] = entity_str($values);
    }
  }
  return $assoc_array;
}

function fetch_all_query($db, $sql, $params = array()){
    try{
        $statement = $db->prepare($sql);
        $statement->execute($params);
      return $statement->fetchAll();
    }catch(PDOException $e){
        return $error[]=('データ取得に失敗しました。');
    }
}

function execute_query($dbh, $sql, $params = array()){
    try{
        $statement = $dbh->prepare($sql);
        return $statement->execute($params);
    }catch(PDOException $e){
        return $error[] = ('更新に失敗しました。');
    }
}

function get_items($dbh, $search_word){
    $sql = "
        SELECT 
            item_name,
            creator,
            caption,
            group_concat(category_name) AS category_name,
            img, 
            template_name,
            status,
            items.item_id
        FROM 
            items INNER JOIN categories
        ON 
            items.item_id = categories.item_id
        WHERE 
            items.item_name LIKE ?
        OR  caption LIKE ?
        OR  category_name LIKE ?
        GROUP BY 
            items.item_id
        ORDER BY
            items.item_id DESC
    ";
    return fetch_all_query($dbh, $sql, array('%'. $search_word .'%','%'. $search_word .'%','%'. $search_word .'%'));
}

function sample_items_search($dbh, $search_sql,  $search_words){
    $where = 'WHERE status = 0 && (';
    $where.= implode("OR", $search_sql);
    $sql = "
        SELECT 
            item_name,
            creator,
            caption,
            group_concat(category_name) AS category_name,
            img, 
            template_name,
            status,
            items.item_id
        FROM 
            items INNER JOIN categories
        ON 
            items.item_id = categories.item_id
    ";
    $sql.= $where;
    $sql.="
        )
        GROUP BY 
            items.item_id
        ORDER BY
            items.item_id DESC
        LIMIT 
            ?,10
        ";
        
    return fetch_all_query($dbh, $sql,  $search_words);
}

function get_all_items($dbh){
    $sql = '
        SELECT 
            item_name,
            creator,
            caption,
            group_concat(category_name) AS category_name,
            img,
            template_name,
            status,
            items.item_id
        FROM 
            items INNER JOIN categories
        ON 
            items.item_id = categories.item_id
      
        GROUP BY 
            items.item_id
        ORDER BY
            items.item_id DESC
    ';
    return fetch_all_query($dbh, $sql);
}

function item_insert($dbh, $item_name, $creator, $caption, $category, $template_name, $status, $new_img_filename) {
    try{
        $dbh->beginTransaction();
        $sql = '
        INSERT INTO 
            items (
                item_name, 
                creator, 
                caption,
                template_name, 
                status,
                img, 
                createdate, 
                updatedate
            )
        VALUE(:item_name, :creator, :caption, :template_name, :status, :img, now(), now())';        
        execute_query($dbh, $sql, array('item_name'=>$item_name, 'creator'=>$creator, 'caption'=>$caption, 'template_name'=>$template_name, 'status'=>$status, 'img'=>$new_img_filename));
        
        $item_id = $dbh->lastInsertId();

        foreach($category as $value){
            $sql = '
            INSERT INTO 
                categories (item_id, category_name)
            VALUE (:item_id, :category_name)';
            execute_query($dbh, $sql, array('item_id'=>$item_id, 'category_name'=>$value));
        }
        if(isset($error)===true){
            $dbh->rollback();
            throw $e;
        }else{
            $dbh->commit();
        }
    }catch(PDOException $e){
        echo 'a接続できませんでした。理由：'.$e->getMessage();
    }
}

//内容変更　tool
function db_detail_change($dbh, $img, $status, $item_id, $item_name, $creator, $caption){
    $sql = '
        UPDATE items SET
            img = :img,
            item_name = :item_name,
            creator = :creator,
            caption = :caption,
            status = :status,
            updatedate = now()
        WHERE
            item_id = :item_id';
    return execute_query($dbh, $sql, $params = array('img'=>$img, 'item_name'=>$item_name, 'creator'=>$creator, 'caption'=>$caption, 'status'=>$status, 'item_id'=>$item_id));
}

function destroy_item($dbh, $item_id, $deletefiles, $imgdir){
    $dbh->beginTransaction();
    if(delete_item($dbh, $item_id) && delete_categories($dbh, $item_id)
      && delete_image($deletefiles, $imgdir)){
      $dbh->commit();
      return true;
    }
    $dbh->rollback();
    return false;
}

function delete_item($dbh, $item_id){
    $sql = "
      DELETE FROM
        items
      WHERE
        item_id = :item_id
      LIMIT 1
    ";
    
    return execute_query($dbh, $sql, array('item_id'=>$item_id));
}

function delete_categories($dbh, $item_id){
    $sql = "
      DELETE FROM
        categories
      WHERE
        item_id = :item_id
    ";
    
    return execute_query($dbh, $sql, array('item_id'=>$item_id));
}

//削除　img
function delete_image($deletefiles, $imgdir){
    if(!empty ($deletefiles)){
        if(file_exists($imgdir.$deletefiles)){
            unlink($imgdir.$deletefiles);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

//エラーチェック　文字  tool
function check_error_name($value) {
    $check_space_name = mb_convert_kana($value, "s", "UTF-8");
    if(ctype_space($check_space_name)===TRUE){
        return '名前・作者名にスペースのみの項目があります。';
    } else if(mb_strlen($value)===0){
        return '名前・作者名に未記入の項目があります。';
    }
}

function check_error_login($value) {
    $check_space_name = mb_convert_kana($value, "s", "UTF-8");
    if(ctype_space($check_space_name)===TRUE){
        return 'ユーザーIDが間違っています。';
    } else if(mb_strlen($value)===0){
        return 'ユーザーIDが間違っています。';
    }
}

function check_error_caption($value) {
    $check_space_name = mb_convert_kana($value, "s", "UTF-8");
    if(ctype_space($check_space_name)===TRUE){
        return '説明文にスペースのみの項目があります。';
    } else if(mb_strlen($value)===0){
        return '説明文に未記入の項目があります。';
    } else if(mb_strlen($value)>200){
        return '説明文は40文字以内で記入してください。';
    }
}

//エラーチェック　数字  tool buy
function check_error_number($value) {
    $check_space_value = mb_convert_kana($value, "s", "UTF-8");
    if(ctype_space($check_space_value)===TRUE){
        return '値段・ライセンス数にスペースのみの項目があります。';
    }else if(mb_strlen($value)===0){
        return '値段・ライセンスに未記入の項目があります。';
    }else if(preg_match("/^[0-9]*$/", $value)!==1){
        return '値段・ライセンスは正数で入力してください。';
    }else if($value < 0){
        return '値段・ライセンスは0以上の正数を入力してください';
    }
}

//エラーチェック　id
function check_error_id($item_id){
    if (preg_match('/\A\d+\z/', $item_id) !== 1 ) {
        return '不正な処理です';
    }
}

//エラーチェック　ステータス  tool
function check_error_status($value){
    if($value !== "1" && $value !== "0"){
        //print $error[] =  'ステータスを選択してください';
        return 'ステータスを選択してください';
    }
}