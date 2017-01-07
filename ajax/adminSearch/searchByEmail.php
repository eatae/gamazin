<?php

include_once(__DIR__ . '/../../inc/gamaz_db.inc.php');

/*
 * DB
 * получаем покупки по email
 */
function customersByEmail($email)
{
    global $link;

    /* stmt - http://php.net/manual/ru/mysqli.prepare.php */
    $sql = "CALL customer_byEmail(?)";


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

    if (empty($out_data)) {
        throw new Exception('Нет данных о пользователе');
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

    if (empty($_GET['email'])) {
        throw New Exception('Нет email заказчика');
    }

    /* @search */
    $customerInfo = customersByEmail($_GET['email']);

    /*
     * back
     * создаём новый json который при необходимости передадим далее
     */
    $backEmail = $cleanBack('searchByEmail', $_GET['email']);
    $backEmail = json_encode($backEmail);

    ?>

    <table id="one_customer">
        <tr>
            <th>ID</th>
            <th>email</th>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Заказ</th>
            <th>Сумма</th>
            <th>Дата</th>
            <th>User</th>
        </tr>
        <?php
        foreach ($customerInfo as $arr):
            ?>

            <tr>
                <td><?php echo $arr['customer_id'] ?></td>
                <td class="cust_email"><?php echo $arr['email'] ?></td>
                <td><?php echo $arr['name'] ?></td>
                <td><?php echo $arr['phone'] ?></td>

                <!-- back -->
                <td class="clickable bolder"
                    onclick='searchByOrder( <?php echo $arr['order_id'] ?>, <?php echo $backEmail ?> )'>
                    № <?php echo $arr['order_id'] ?>
                </td>

                <td><?php echo $arr['amount'] ?> кл</td>
                <td><?php echo $arr['order_date'] ?></td>
                <td>
                    <?php
                    if (null != $arr['login']) {
                        echo $arr['login'];
                    } else {
                        echo 'no user';
                    }
                    ?>
                </td>
            </tr>

            <?php
        endforeach
        ?>
    </table>


    <?

} catch (Exception $e) {
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