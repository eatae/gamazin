<?php

include_once(__DIR__ . '/../../inc/gamaz_db.inc.php');


function searchByDate($date, $pageNum)
{
    if (7 > strlen($date)) {
        var_dump(strlen($date));
        throw new Exception('Неверно указана дата. Нужно, например 2016-11');
    }


    global $link;

    $out_data = [];

    $pageNum *= 10;

    $sql = 'CALL orders_searchByDate(?, ?)';

    if (!$stmt = mysqli_prepare($link, $sql)) {
        throw new Exception('Невозможно подготовить запрос');
    }

    mysqli_stmt_bind_param($stmt, 'si', $date, $pageNum);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('EXECUTE:' . $stmt->error);
    }

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $out_data[] = $row;
    }

    mysqli_stmt_close($stmt);

    if (empty($out_data)) {
        throw New Exception('Данные отсутствуют');
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


/*
 * BACK
 * извлекаем массив из json строки
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
    /* также получим из базы ['count'] всех записей */
    $orders = searchByDate($_GET['date'], $_GET['pageNum']);
    $numbers = get_page_numbers($orders[0]['count']);


    /*
     * back
     * создаём новый json который при необходимости передадим далее
     */
    $backDate = $cleanBack('searchByDate', $_GET['date']);
    $backDate = json_encode($backDate);

    /* показ таблицы с данными из Db */
    ?>
    <table id="table_orders">
        <tr>
            <th>Номер заказа</th>
            <th>email</th>
            <th>Сумма</th>
            <th>Дата</th>
        </tr>
        <?php
        foreach ($orders as $arr):
            ?>
            <tr>
                <td class="clickable bolder"
                    onclick='searchByOrder( <?php echo $arr['order_id'] ?>, <?php echo $backDate ?> )'>
                    № <?php echo $arr['order_id'] ?>
                </td>
                <td onclick='searchByEmail( "<?php echo $arr['email'] ?>",  <?php echo $backDate ?>)' class="clickable">
                    <?php echo $arr['email'] ?>
                </td>
                <td><?php echo $arr['amount'] ?> кл.</td>
                <td><?php echo $arr['order_date'] ?></td>
            </tr>
            <?php
        endforeach
        ?>
    </table>

    <nav id="num_page_orders">
        <ul>
            <?

            /* pagination */
            $length = count($numbers);

            for ($cnt = 0; $length > $cnt; $cnt++):
                /* отображаем номера страниц и делаем нажатымы
                   с счётчиками намудрили, чтоб нумерация шла с единицы
                */
                if ((int)$_GET['pageNum'] == $cnt) {
                    $countPage = $cnt;
                    ?>
                    <li>
                        <span class="adm_press_button"><?php echo ++$countPage ?></span>
                    </li>
                    <?
                } else {
                    $countPage = $cnt;
                    ?>
                    <li>
                        <span class=""><?php echo ++$countPage ?></span>
                    </li>
                    <?
                }
            endfor;

            ?>
        </ul>
    </nav>

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

