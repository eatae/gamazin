<?php
include_once(__DIR__ . '/adm_ajax_func.php');


/* DISPLAY */

try {

    if (empty($_GET['cust_email'])) {
        throw New Exception('Нет email заказчика');
    }

    /* @search */
    $customerInfo = takeCustomer_byEmail($_GET['cust_email'], $_GET['search']);


    /* получаем номер предыдущей страницы
     * либо пред-предыдущей - double_return
     * */
    $numPage = (int)$_GET['page_num'];

    $double_return = (int)$_GET['double_return'];

    $back = ( !empty((int)$numPage) ) ? $numPage : $double_return;

    /* TEST */
    //var_dump($_GET);

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
                <td><?php echo $arr['customer_id']?></td>
                <td class="cust_email"><?php echo $arr['email']?></td>
                <td><?php echo $arr['name']?></td>
                <td><?php echo $arr['phone']?></td>

                <!-- TEST -->
                <td onclick="takeOrderByNumber(this, <?php echo $back ?>)" class="clickable bolder">
                    № <?php echo $arr['order_id']?>
                </td>
<!--                <td onclick="test(this);">-->
<!--                    --><?php //echo $arr['order_id']?>
<!--                </td>-->

                <td><?php echo $arr['amount']?> кл</td>
                <td><?php echo $arr['order_date']?></td>
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

if ( !empty($numPage) ) {
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
elseif ( !empty($double_return) && !empty($_GET['cust_email']) ) {
    ?>

    <nav id="back">
        <ul>
            <li>
                <span onclick="getPageForOrders(<?php echo $double_return ?>)">назад</span>
            </li>
        </ul>
    </nav>
    <?
}