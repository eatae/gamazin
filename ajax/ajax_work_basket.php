<?php
// setcookie('basket', '', time() -30);
require_once(__DIR__ . '/../inc/gamaz_lib.inc.php');


if ( isset($_GET['action']) && !empty($_GET['data']) ) {
    $action = $_GET['action'];
    $data = $_GET['data'];

    switch ($action) {
        case 'main_add':
            addFromMain($data);
            break;
        case 'basket_add':
            addFromBasket($data);
            break;
        case 'basket_del':
            delFromBasket($data);
            break;
        default:
            echo 'нет данных';
    }
    exit;
}






/** main add **/

function addFromMain($data)
{
    $checkBasket = checkBasketForMain();

    $id = (int)$data;   // data is id
    $cookieTime = time() + (14 * 24 * 60 * 60);

    if ($checkBasket['count'] == 0)
    {
        // $id - ключ
        $cookieBasket = json_encode( [ $id => 1 ] );
        setcookie('basket', $cookieBasket, $cookieTime, '/');
        ++$checkBasket['count'];
    }
    else if ( array_key_exists($id, $checkBasket['basket']) )
    {
        ++$checkBasket['basket'][$id];
        $cookieBasket = json_encode( $checkBasket['basket'] );
        setcookie('basket', $cookieBasket, $cookieTime, '/');
        ++$checkBasket['count'];
    }
    else
    {
        $checkBasket['basket'][$id] = 1;
        $cookieBasket = json_encode( $checkBasket['basket'] );
        setcookie('basket', $cookieBasket, $cookieTime, '/');
        ++$checkBasket['count'];
    }

    echo json_encode($checkBasket);
}








/** basket add **/

function addFromBasket($data)
{
    $checkBasket = checkBasketForMain();

    $id = (int)$data;   // data is id
    $cookieTime = time() + (14 * 24 * 60 * 60);

    if ( array_key_exists($id, $checkBasket['basket']) )
    {
        ++$checkBasket['basket'][$id];
        $cookieBasket = json_encode( $checkBasket['basket'] );
        setcookie('basket', $cookieBasket, $cookieTime, '/');
        ++$checkBasket['count'];
    }

    echo $checkBasket['count'];
}




/** basket delete **/

function delFromBasket($data)
{
    $checkBasket = checkBasketForMain();

    $id = (int)$data;   // data is id
    $cookieTime = time() + (14 * 24 * 60 * 60);

    if ( array_key_exists($id, $checkBasket['basket']) )
    {
        if(0 === $checkBasket['basket'][$id]){
            return;
        }
        --$checkBasket['basket'][$id];
        $cookieBasket = json_encode( $checkBasket['basket'] );
        setcookie('basket', $cookieBasket, $cookieTime, '/');
        --$checkBasket['count'];
    }

    echo $checkBasket['count'];
}