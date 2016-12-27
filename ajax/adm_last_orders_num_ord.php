<?php
include_once(__DIR__ . '/adm_ajax_func.php');



/* DISPLAY */

try {

    if (empty($_GET['order_num'])) {
        throw New Exception('Нет номера заказа');
    }
    /* обрабатываем строку из $_GET, получаем int */
    $order_num = (int)explode(' ', $_GET['order_num'])[1];
    /* получаем массив с данными о заказе */
    $orderInfo = takeOrder_byNumber($order_num);


    $numPage = (int)$_GET['page_num'];
    $double_return = (int)$_GET['double_return'];

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
                <td><?php echo $arr['title']?></td>
                <td><?php echo $arr['price']?> кл</td>
                <td><?php echo $arr['quantity']?></td>
            </tr>
            <?php
        endforeach
        ?>
        <tr>

            <td>Заказ № <?php echo $order_num ?></td>
            <td><?php echo $arr['email']?></td>
            <td>Сумма <?php echo $arr['amount']?> кл</td>
        </tr>
    </table>

    <?

} catch (Exception $e) {
    /* поймали исключения */
    echo $e->getMessage();
}



/** кнопка 'НАЗАД' **/

/* к странице last_orders */
if( !empty($numPage) ) {
    ?>

    <nav id="back">
        <ul>
            <li>
                <span onclick="getPageForOrders(<?php echo $numPage ?>)">назад</span>
            </li>
        </ul>
    </nav>

    <?
}
/* если пришёл double_return то нужно
 * передать его
 * возврат к странице по email
 */
elseif ( !empty($double_return) && !empty($_GET['cust_email']) ) {
    ?>

    <nav id="back">
        <ul>
            <li>
                <span onclick="takeCustomerByEmail('<?php echo $_GET['cust_email'] ?>', <?php echo $double_return ?>)">назад</span>
            </li>
        </ul>
    </nav>
    <?
}
/* возврат к странице по email */
elseif ( !empty($_GET['cust_email']) ) {

    ?>

    <nav id="back">
        <ul>
            <li>
                <span onclick="takeCustomerByEmail('<?php echo $_GET['cust_email'] ?>')">назад</span>
            </li>
        </ul>
    </nav>
    <?
}