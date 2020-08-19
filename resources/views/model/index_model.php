<?php
function caption_add_number($sample){
    foreach($sample as $array){
        $data = [];
        $result = [];
        $data = explode("\n", $array['caption']);
        foreach($data as $value){
            $result[] = $value;
        }
        $array['caption'] = $result;
        $productList[] = $array;
    }
    return $productList;
}

function get_template($dbh, $template_word){
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
            status = 0 && items.template_name LIKE ?
        GROUP BY 
            items.item_id
        ORDER BY
            items.item_id DESC
    ";
    return fetch_all_query($dbh, $sql, array('%'. $template_word .'%'));
}