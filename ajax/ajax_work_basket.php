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
    // take small basket from $_COOKIE
    $checkBasket = checkBasketForMain();

    // take id from $_GET
    $id = (int)$data;

    if ( array_key_exists($id, $checkBasket['basket']) )
    {
        --$checkBasket['basket'][$id];

        // если удалили последний товар данного наименования
        if (0 === $checkBasket['basket'][$id]) {
            // то удаляем этот элемент из корзины
            unset($checkBasket['basket'][$id]);
        }
        // уменьшаем счётчик элементов
        --$checkBasket['count'];

        // если счётчик == 0, удаляем $_COOKIE['basket']
        if (0 === $checkBasket['count']) {
            $cookieTime = time() - (14 * 24 * 60 * 60);
            $cookieBasket = '';
        }
        // иначе перезаписываем $_COOKIE['basket']
        else {
            $cookieBasket = json_encode( $checkBasket['basket'] );
            $cookieTime = time() + (14 * 24 * 60 * 60);
        }

        setcookie('basket', $cookieBasket, $cookieTime, '/');
    }

    echo $checkBasket['count'];
}