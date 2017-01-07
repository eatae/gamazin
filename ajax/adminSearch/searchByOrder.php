<?php

include_once(__DIR__ . '/../../inc/gamaz_db.inc.php');

/*
 * DB
 * получаем заказ
 */
function searchByOrder($orderId)
{
    global $link;

    $out_data = [];

    $sql = "CALL order_byNumber(?)";

    if (!$stmt = mysqli_prepare($link, $sql)) {
        throw new Exception('Невозможно подготовить запрос');
    }

    mysqli_stmt_bind_param($stmt, 'i', $orderId);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('EXECUTE:' . $stmt->error);
    }

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $out_data[] = $row;
    }

    mysqli_stmt_close($stmt);

    if (empty($out_data)) {
        throw new Exception('Нет данных о заказе');
    }

    return $out_data;

}


/*
 * BACK
 */
$backJson = json_decode($_GET['back'], true);

if (null == $backJson) {
    $backJson = [];
}


/*
 * CLEAN BACK
 * анонимная функция, замыкание $backJson
 */
$cleanBack = function ($nameFunc, $data) use ($backJson) {
    if ('string' != gettype($nameFunc)) {
        throw new Exception('Имя функции должно быть строкой');
    }
    /* неочевидно / нестирать */
    /*if ( !empty($out_arr = $backJson) ) {
        foreach ( $out_arr as $key => $val ) {
            /* если в backJson такая функция уже есть
             * то удаляем её, и позднее вставляем новое значение
             *//*
            if ( $val['func'] == $nameFunc ) {
                unset($out_arr[$key]);
            }
        }
    }
    /* создаём новый массив, записываем в него новое значение */
    $out_arr = $backJson;
    $out_arr[] = ['func' => $nameFunc, 'data' => $data];
    /* сбрасываем индексы */
    $out_arr = array_values($out_arr);
    /* возвращаем очищенный массив */
    return $out_arr;
};


/* DISPLAY */

try {

    if (empty($_GET['orderId'])) {
        throw New Exception('Нет номера заказа');
    }

    /* обрабатываем строку из $_GET, получаем int */
    $orderId = (int)$_GET['orderId'];

    /*
     * back
     * создаём новый json который при необходимости передадим далее
     */
    $backOrder = $cleanBack('searchByOrder', $orderId);
    $backOrder = json_encode($backOrder);

    /* получаем массив с данными о заказе */
    $orderInfo = searchByOrder($orderId);


    ?>

    <table id="one_order">
        <tr>
            <th>Название</th>
            <th>Цена</th>
            <th>Кол-во</th>
        </tr>
        <?php
        foreach ($orderInfo as $arr):
            ?>
            <tr>
                <td><?php echo $arr['title'] ?></td>
                <td><?php echo $arr['price'] ?> кл</td>
                <td><?php echo $arr['quantity'] ?></td>
            </tr>
            <?php
        endforeach
        ?>
        <tr>
            <td>Заказ № <?php echo $orderId ?></td>

            <!-- back -->
            <td onclick='searchByEmail( "<?php echo $arr['email'] ?>",  <?php echo $backOrder ?>)'
                class="clickable"> <?php echo $arr['email'] ?> </td>

            <td>Сумма <?php echo $arr['amount'] ?> кл</td>
        </tr>
    </table>

    <?

} catch (Exception $e) {
    /* поймали исключения */
    echo $e->getMessage();
}


/** кнопка 'НАЗАД' **/


if (!empty($backJson)) {
    ?>

    <nav id="back">
        <ul>
            <li>
                <span onclick='searchBack(<?php echo $_GET['back'] ?>)'>Назад</span>
            </li>
        </ul>
    </nav>
    <?
}