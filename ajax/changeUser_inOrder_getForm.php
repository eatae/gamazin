<?php
session_start();
include_once(__DIR__ . '/../inc/gamaz_lib.inc.php');

/* GET FORM
 *
 * Отображается посредством AJAX
 * при нажатии User'ом 'Изменить'
 * для корректировки своих данных.
 *
 * Далее форма отправляет данные
 * changeUser_inOrder.php
 * где они проверяются и записываются в базу.
 *
 */


/*
 * IF CUSTOMER
 * change email, phone, name;
 *
 */
if( null != $_SESSION['cust_id']) {

    $dataOnCustomer = getDataOnCustomer( $_SESSION['user_id'], $_SESSION['cust_id'] );
    ?>

    <form id='form_user' action='javascript:void(0);' class='change_form'>

        <p>
            <label for='email'>Email:</label>
            <input name="email" type="text" value='<?php echo $_SESSION['email']; ?>'>
        </p>
        <p>
            <label for='name'>Имя:</label>
            <input name="name" type="text" value='<?php echo $dataOnCustomer['name']; ?>'>
        </p>
        <p>
            <label for='phone'>Телефон:</label>
            <input name="phone" type="text" value='<?php echo $dataOnCustomer['phone']; ?>'>
        </p>
        <p>
            <label for='password'>Пароль:</label>
            <input name="password" type="password">
        </p>

        <p>
            <!-- здесь нужно зацепить функцию из ajax.lib.js и передать post новые данные -->
            <input type='submit' value='Отправить' onclick="change_user_data();">
        </p>
    </form>

    <?
    exit;
}

/*
 * IF USER
 * change email
 */
elseif( null != $_SESSION['user_id']) {
    ?>

    <form id='form_user' action='javascript:void(0);' class='change_form'>
        <p>
            <label for='email'>Email:</label>
            <input name="email" type="text" value='<?php echo $_SESSION['email']?>'>
        </p>
        <p>
            <label for='password'>Пароль:</label>
            <input name="password" type="text">
        </p>

        <p>
            <!-- здесь нужно зацепить функцию из ajax.lib.js и передать post новые данные -->
            <input type='submit' value='Отправить' onclick="change_user_data();">
        </p>

    </form>

    <?
    exit;
}

else {
    echo 'Default getForm';
}