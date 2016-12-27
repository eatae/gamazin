<?php
include_once(__DIR__ . '/../inc/gamaz_db.inc.php');


function get_last_orders($pageNumber = 0, $in_date = null)
{
    global $link;
    $out_msg = [];
    $pageNumber *= 10;

    $sql = "CALL orders_pagination($pageNumber)";

    if (!$result = mysqli_query($link, $sql)) {
        throw New Exception('Невозможно подготовить запрос' . mysqli_connect_error());
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $out_msg[] = $row;
    }

    return $out_msg;
}



function get_page_numbers($quantity)
{
    $arr = [];
    /* делим и округляем до большего числа */
    $quantity = (int)ceil($quantity / 10);

    for( $cnt=0; $cnt < $quantity; $cnt++){
        $arr[] = $cnt;
    }
    return ($arr);
}






/* DISPLAY */

try {
    /* также получим из базы ['count'] всех записей */
    if ( !empty($_GET['page']) ) {
        $orders = get_last_orders($_GET['page']);
        //var_dump($orders);
        $numbers = get_page_numbers($orders[0]['count']);
    }
    else {
        $orders = get_last_orders();
        //var_dump($orders);
        $numbers = get_page_numbers($orders[0]['count']);
    }



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
            <td onclick="takeOrderByNumber(this)" class="clickable">
                № <?php echo $arr['order_id']?>
            </td>
            <td onclick="takeCustomerByEmail(this)" class="clickable">
                <?php echo $arr['email']?>
            </td>
            <td><?php echo $arr['amount']?> кл.</td>
            <td><?php echo $arr['order_date']?></td>
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
            for( $cnt=0; $length > $cnt; $cnt++):
                /* отображаем номера страниц и делаем нажатымы
                   с счётчиками намудрили, чтоб нумерация шла с единицы
                */
                if ( empty($_GET['page']) && 0 == $cnt) {
                    $countPage = $cnt;
                    ?>
                    <li>
                        <span class="adm_press_button"><?php echo ++$countPage ?></span>
                    </li>
                    <?
                } elseif ( $_GET['page'] == $cnt ) {
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
                        <span><?php echo ++$countPage ?></span>
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

