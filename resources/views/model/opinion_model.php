<?php
function get_opinion($dbh){
    $sql = '
        SELECT
            id,
            name,
            opinion,
            datetime
        FROM
            opinions
        ORDER BY
            id DESC
    ';
    return fetch_all_query($dbh, $sql);
}

function opinion_insert($dbh, $name, $opinion){
    try{
        $sql = '
        INSERT INTO
            opinions (
                name,
                opinion,
                datetime
            )
        VALUE(:name, :opinion, now())';
        execute_query($dbh, $sql, array('name'=>$name, 'opinion'=>$opinion));
    }catch(PDOException $e){
        echo 'a接続できませんでした。理由：'.$e->getMessage();
    }
}