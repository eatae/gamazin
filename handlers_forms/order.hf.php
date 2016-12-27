<?php
include_once('top_include.php');


/**** ОФОРМЛЕНИЕ ЗАКАЗА ****/

try {


    if ( !lookPost() )
        throw new Exception('Заполните все поля');

    if ( empty($_COOKIE['basket']) )	// на isset не нужно проверять
        throw new Exception('Корзина пуста');

    /* Take the BIG BASKET from DB */
    $checkBasket = checkBasketForBasket( $_COOKIE['basket'] );


    /* IF OLD CUSTOMER AND USER*/

    if ( null != $_SESSION['cust_id'] ) {

        // call PROCEDURE, take orderId and cust_id.
        $result['order_id'] = insert_C_CustOrderEmail(
            $_SESSION['email'],
            $_SESSION['user_id'],
            $_SESSION['cust_id'],
            $checkBasket['all_sum']
        );
    }


    /* IF USER NO CUSTOMER */

    elseif ( null !== $_SESSION['user_id'] ) {

        $name = cleanStr($_POST['name']);
        $phone = cleanStr($_POST['phone']);

        if ( !validName($name) )
            throw new Exception('Некорректно указан Email или Имя');

        // call PROCEDURE, take orderId and cust_id.
        $result = insert_U_CustOrderEmail(
            $name,
            $phone,
            $_SESSION['email'],
            $_SESSION['user_id'],
            $checkBasket['all_sum']
        );

        // set SESSION cust_id
        $_SESSION['cust_id'] = (int)$result['cust_id'];

    }


    /* IF NEW CUSTOMER NO USER */

    else {
        $name = cleanStr($_POST['name']);
        $phone = cleanStr($_POST['phone']);
        $mail = cleanStr($_POST['email']);
        $sum = $checkBasket['all_sum'];

        if ( !validEmail($mail) or !validName($name) )
            throw new Exception('Некорректно указан Email или Имя');

        // call PROCEDURE, take orderId
        $result['order_id'] = insert_CustOrderEmail( $name, $phone, $mail, $sum );
    }


    // insert in DB table 'Order_Items' many values
    insert_Order_Items( (int)$result['order_id'], $checkBasket );

    $cookieTime = time()-3600;
    // clear basket and refresh
    setcookie('basket', '', $cookieTime, '/');
    header( "Refresh: 2; url='../index.php'" );

    $name = !empty($name) ? $name : $_SESSION['name'];
    $mail = !empty($mail) ? $mail : $_SESSION['email'];

    // send mail
    $stringMess = $name . ', благодарим Вас за заказ.';
    sendMessage($mail, $stringMess);

    do_html_header( 'All good' );
    do_html_form_handler( $stringMess );
    do_html_footer();


} catch ( Exception $e ) {
    $href = '<br><br><a href="javascript:history.back()">Назад</a>';
    do_html_header('Problem: ');
    do_html_form_handler( $e->getMessage(), $href );
    do_html_footer();
    exit;
}
