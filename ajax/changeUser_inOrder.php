<?php
session_start();
include_once(__DIR__ . '/../inc/gamaz_lib.inc.php');

/* CHANGE USER DATA
 *
 * IF CUSTOMER
 */

if( null != $_SESSION['cust_id'] && lookPost() ) {
    /* передаём кучу параметров функции,
     * которая проверяет и фильтрует все данные
     * подготовленным запросом. Вызывает процедуру,
     * которая UPDATE данные в базе и возвращает
     * custId or NULL
     */
    try {
        // login == $_SESSION['name']
        $custId = changeCustomerData(
            $_SESSION['user_id'], $_SESSION['name'], $_POST['password'],
            $_POST['phone'], $_POST['name'], $_POST['email']);

        if (null != $custId):
            /* если процедура возвращает !null то перезаписываем email,
             * который мог измениться или нет...
             */
            $_SESSION['email'] = cleanStr($_POST['email']);

            $dataOnCustomer = getDataOnCustomer($_SESSION['user_id'], $custId)
            /* далее выводим посредством AJAX блок формы заказа
             * в inner_block_right
             * (просто скопировал часть из htmlBlock/basketForm_c.php)
             */
            ?>


            <!-- HTML FOR inner_block_right -->
            <table>
                <tr>
                    <td>Ваш email:</td>
                    <td><? echo $_SESSION['email']; ?></td>
                </tr>
                <tr>
                    <td>Имя:</td>
                    <!-- function dataOnCustomer (gamaz_lig) call it in basketForm_userBlock -->
                    <td><? echo $dataOnCustomer['name']; ?></td>
                </tr>
                <tr>
                    <td>Телефон:</td>
                    <td><? echo $dataOnCustomer['phone']; ?></td>
                </tr>
            </table>

            <div class='href_change'>
                <div>
                    <a href="javascript:void(null);" onclick="get_form_change_data();">Изменить</a>
                </div>
            </div>
            <hr>

            <div class='submit'>
                <!-- блок применяется в basket.php поэтому 'form_handler.php' -->
                <form id='form_user' action='handlers_forms/order.hf.php' method="post">
                    <!--                    <input type='hidden' name='page' value='basket'>-->
                    <input type='hidden' name='sum' value='<?= $checkBasket['all_sum']; ?>'>

                    <p>
                        <input type='submit' value='Заказать'>
                    </p>
                </form>
            </div>
            <!-- END HTML -->


            <?
        endif;
    } catch (Exception $e) {
        echo $e->getMessage();
    }

}


/* ELSE IF USER */
/****************/

elseif ( null != $_SESSION['user_id'] && null != $_POST['email'] && null != $_POST['password']) {

    /* дергаем процедуру (change_user_data) которая выбирает (проверяет):
     *  Login, id_customer, password и возвращает user_id
     */
    try {
        /* login == SESSION['name'] */
        $userId = changeUserData($_SESSION['name'], $_POST['email'], $_POST['password']);

        if (null != $userId):

            $_SESSION['email'] = cleanStr($_POST['email']);
            ?>


            <!-- HTML FOR inner_block_right -->
            <table>
                <tr>
                    <td>Ваш email:</td>
                    <td><? echo $_SESSION['email']; ?></td>
                </tr>
            </table>

            <div class='href_change'>
                <div>
                    <a href="javascript:void(null);" onclick="get_form_change_data();">Изменить</a>
                </div>
            </div>
            <hr>

            <div class='submit'>
                <!-- блок применяется в basket.php поэтому 'form_handler.php' -->
                <form id='form_user' method='post' action='handlers_forms/order.hf.php'>
                    <!--                    <input type='hidden' name='page' value='basket'>-->
                    <input type='hidden' name='sum' value='<?= $checkBasket['all_sum']; ?>'>

                    <p>
                        <label for='name'>Имя:</label>
                        <input name="name" type="text">
                    </p>

                    <p>
                        <label for='name'>Телефон:</label>
                        <input name="phone" type="text">
                    </p>

                    <p>
                        <input type='submit' value='Заказать'>
                    </p>
                </form>
            </div>
            <!-- END HTML -->


            <?
        endif;

    } catch (Exception $e) {
        echo $e->getMessage();
    }

}
else{
    echo 'Default else: changeUser_inOrder.php';
}
?>