<?php
include_once(__DIR__ . '/../inc/gamaz_db.inc.php');



/* EMAIL */
function takeCustomer_byEmail($email, $search)
{
    global $link;

    $out_data = [];

    $sql = ( !empty($search) ) ?
        "CALL customer_byEmailSearch('$email')" :
        "CALL customer_byEmail('$email')";

    if ( !$result = mysqli_query($link, $sql) ) {
        throw New Exception('Невозможно подготовить запрос' . mysqli_connect_error());
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $out_data[] = $row;
    }

    mysqli_free_result($result);

    if ( empty($out_data) ) {
        throw New Exception('Нет данных о пользователе');
    }

    return $out_data;
}




/* Берём из Db всю инф. об одном заказе
*/
function takeOrder_byNumber($order_num)
{
    global $link;

    $out_data = [];

    $sql = "CALL order_byNumber($order_num)";

    if ( !$result = mysqli_query($link, $sql) ) {
        throw New Exception('Невозможно подготовить запрос' . mysqli_connect_error());
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $out_data[] = $row;
    }

    mysqli_free_result($result);

    if ( empty($out_data) ) {
        throw New Exception('Нет данных о заказе');
    }

    return $out_data;
}