<?php
include_once(__DIR__ . '/../inc/gamaz_db.inc.php');


/*
 * ORDERS
 *
 * use:
 *  last orders + pagination
 *
 *  search by order_date + pagination
 *
 * @pageNumber num
 * @search string = order_date
 */

function get_orders($date, $pageNumber = 0)
{
    global $link;

    $out_data = [];

    $pageNumber *= 10;

    /* search */
    if (!empty($search)) {
        $sql = 'CALL orders_searchByDate(?, ?)';

        if (7 < count($search)) {
            throw new Exception('Укажите правильно дату');
        }
        $search = str_replace('/', '-', $search);

        if (!$stmt = mysqli_prepare($link, $sql)) {
            throw new Exception('Невозможно подготовить запрос');
        }

        mysqli_stmt_bind_param($stmt, 'si', $date, $pageNumber);
    } /* all orders */
    else {
        $sql = 'CALL orders_pagination(?)';

        if (!$stmt = mysqli_prepare($link, $sql)) {
            throw new Exception('Невозможно подготовить запрос');
        }

        mysqli_stmt_bind_param($stmt, 'i', $pageNumber);

    }

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('EXECUTE:' . $stmt->error);
    }

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $out_data[] = $row;
    }

    mysqli_stmt_close($stmt);

    mysqli_free_result($result);

    if ( empty($out_data) ) {
        throw New Exception('Нет данных о пользователе');
    }


    return $out_data;
}


/*
 *  count pagination
 */
function get_page_numbers($quantity)
{
    $arr = [];
    /* делим и округляем до большего числа */
    $quantity = (int)ceil($quantity / 10);

    for ($cnt = 0; $cnt < $quantity; $cnt++) {
        $arr[] = $cnt;
    }
    return ($arr);
}


//////////////////////////////////////////////////
/*
 * EMAIL
 *
 * use:
 *  заказы click customer email
 *  поиск search customer email
 *
 * @email string GET
 * @search string GET
 */

function takeCustomer_byEmail($email, $search)
{
    global $link;

    /* stmt - http://php.net/manual/ru/mysqli.prepare.php */
    $sql = (!empty($search)) ?
        "CALL customer_byEmailSearch(?)" :
        "CALL customer_byEmail(?)";

    if (!$stmt = mysqli_prepare($link, $sql)) {
        throw new Exception('Невозможно подготовить запрос');
    }

    mysqli_stmt_bind_param($stmt, 's', $email);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('EXECUTE:' . $stmt->error);
    }

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $out_data[] = $row;
    }

    mysqli_stmt_close($stmt);

    mysqli_free_result($result);

    if ( empty($out_data) ) {
        throw new Exception('Нет данных о пользователе');
    }


    return $out_data;

}


//////////////////////////////////////////////////
/*
 * ONE ORDERS
 *
 *  Берём из Db всю инф. об одном заказе по id
 */
function takeOrder_byNumber($order_num)
{
    global $link;

    $out_data = [];

    $sql = "CALL order_byNumber(?)";

    if (!$stmt = mysqli_prepare($link, $sql)) {
        throw new Exception('Невозможно подготовить запрос');
    }

    mysqli_stmt_bind_param($stmt, 'i', $order_num);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('EXECUTE:' . $stmt->error);
    }

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $out_data[] = $row;
    }

    mysqli_stmt_close($stmt);

    if (empty($out_data)) {
        throw new Exception('Нет данных о пользователе');
    }

    return $out_data;
}
