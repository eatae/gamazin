<?php
header("Content-type: text/html; charset=utf-8");
require "gamaz_db.inc.php";

/* session param */
$week = (time() + (7 * 24 * 60 * 60)) - time();
//session.cookie_lifetime
session_set_cookie_params($week);
ini_set('session.gc_maxlifetime', $week);
session_start();





/** ВЫВОД ТОВАРА **/
/****************/
/*------------------------------*/
/*  Получаем массив меню с помощью getProducts (админка)
	Далее передаем его  */




/** АДМИНКА **/
/************/
/*------------------------------*/

/* ВЫБОРКА ПРОДУКТОВ ИЗ БАЗЫ */

function getProducts(){
	global $link;
	$prods = array();
	$menu = array();
	
	$sql = 'SELECT * FROM products';

	if(!$result = mysqli_query($link, $sql))
		throw new Exception('Невозможно подготовить запрос: '.mysqli_connect_error());
	
	for($cnt = 0; $row = mysqli_fetch_assoc($result); $cnt++){
		$prods[$cnt] = $row;
		$menu[$prods[$cnt]['category']][$prods[$cnt]['title']][] = $prods[$cnt];
		$category[] = $prods[$cnt]['category'];
		$title[] = $prods[$cnt]['title'];
	};
	mysqli_free_result($result);
	return $menu;
	// не закрываем соединение иначе другие не исполнятся
//	mysqli_close($link);
}



/* ПОЛУЧАЕМ РАСШИРЕНИЕ КАРТИНКИ */

function getTypeImg($type)
{
    if ($type == 'image/jpeg') {
		$type = '.jpg';
    } else if ($type == 'image/gif') {
		$type = '.gif';
    } else if ($type == 'image/png') {
		$type = '.png';
    } else if ($type == 'image/bmp') {
		$type = '.bmp';
    } else {
        return false;
    }

    return $type;
}





/* ЗАПИСЬ ПРОДУКТОВ В БАЗУ */


function setProduct(array $upload){
	global $link;
	/* extract array $upload */
	extract($upload);
	/*
	PROCEDURE set_products(IN 4 @param):
		-insert product
		-make file_dir_final
		-return(select) file_dir_final
	*/
	$sql = "CALL set_products('$up_cat', '$up_tit', '$up_price', '$file_type')";
	
	/* upload image */
	if( !empty($file_dir_tmp) ){
		if( !$result = mysqli_query($link, $sql) )
			throw new Exception('Hi, unable image dir query '. mysqli_connect_error());

		/* dir for image, default dir(in DB) = 'img/def.jpg' */
		if( $file_dir_final = mysqli_fetch_row($result) and $file_dir_final[0] != '' ){
            $dir_final = '../' . $file_dir_final[0];

            if( !move_uploaded_file($file_dir_tmp, $dir_final) )
                throw new Exception('Товар добавлен!<br>Невозможно загрузить картинку');
        };

        mysqli_free_result($result);
    };
}
		
	


/** ОБРАБОТКА ФОРМ **/
/*******************/
/*------------------------------*/

/* ПРОВЕРЯЕМ ЗАПОЛНЕННОСТЬ ФОРМЫ */

function lookPost(){
	foreach ($_POST as $key => $value) {
		// dir, x, y не бежим
		if ($key == 'dir' || 'x' || 'y') { continue; }
		if ( empty($value) )
			return false;
		}
	return true;
}



/* ФИЛЬТРУЕМ СТРОКИ ФОРМЫ */

function cleanStr($form = '') {
	global $link; //чтоб real_esc_str увидела объект $link
	$form = mysqli_real_escape_string($link, $form);
	$form = trim($form);
	$form = stripslashes($form);
	$form = strip_tags($form);
	$form = htmlspecialchars($form);
	return $form;
}



/* ФИЛЬТРУЕМ ЧИСЛА ФОРМЫ */

function cleanNum($form){
	if(is_numeric($form)){
		$form = abs((int)$form);
		return $form;
	}else {return false;}
}



/* ПРОВЕРКА email */

function validEmail($addres){
	if((strlen($addres) >= 6) && (preg_match("~^([a-z0-9_\-\.])+@([a-z0-9_\-\.])+\.([a-z0-9])+$~i", $addres) !== 0)) 
		return true; 
	else return false;
}



/* ПРОВЕРКА ПАРОЛЕЙ НА СООТВЕТСВИЕ */

function validPass($pass1, $pass2){
	if($pass1 === $pass2){
		if((strlen($pass1) >= 5) && (strlen($pass1) < 20))
			return ($pass1);//no sha1
			//return $pass1;
	}
	return false;
}



function validLogin($login){
	if(strlen($login) >= 3){
		return $login;
	}
	return false;
}



function validName($name){
	if( strlen( (string)$name ) >= 2 ){
		return $name;
	}
	return false;
}




/** РЕГИСТРАЦИЯ ВХОД И ВЫХОД ПОЛЬЗОВАТЕЛЯ **/
/***************************************/
/*-------------------------------------*/


/** РЕГИСТРАЦИЯ ПОЛЬЗОВАТЕЛЯ **/

function regUser(array $reg){
	global $link;
	/* extract array $reg */
	extract($reg);
	
	/* PROCEDURE reg_user(IN 3 @param):
		-if not user - set user, return true
		-else return 'false' */
	$sql = "CALL reg_user('$login', '$passwd', '$email')";

	if( !$result = mysqli_query($link, $sql) ) {
		throw new Exception('Hi, bad query in regUser ' . mysqli_connect_error());
	}
	/* заполняем сессию */
	if( $user = mysqli_fetch_row($result) and $user[0] !== null ) {
			$_SESSION['name'] = $login;
			$_SESSION['user_id'] = $user[0];
			$_SESSION['cust_id'] = null;
			$_SESSION['email'] = $email;
			// присваиваем статус
			$_SESSION['status'] = 'user';
	}
	else {
		throw new Exception('Такой login уже есть');
	}


}





/** ВХОД ПОЛЬЗОВАТЕЛЯ **/

function enterUser($login, $pass)
{
	global $link;

/** if login and password match in Db - query returns:
 *      user_id
 *      customer_id
 *      admin
 *      email
 */
	$sql = "SELECT U.user_id, U.customer_id,
                   U.admin, E.email
                FROM users U
                LEFT JOIN email E
                ON U.user_id = E.user_id
                WHERE U.login = ?
                  AND U.password = ?";


	$stmt = mysqli_stmt_init($link);

	if(!mysqli_stmt_prepare($stmt, $sql))
		throw new Exception('Невозможно подготовить запрос');

	mysqli_stmt_bind_param($stmt, 'ss', $login, $pass);

	mysqli_stmt_execute($stmt);

	// порядок переменных выборки определяет запрос ($sql)
	mysqli_stmt_bind_result($stmt, $user_id, $cust_id, $admin, $email);

	mysqli_stmt_fetch($stmt);

	mysqli_stmt_close($stmt);

	// смотрим выполнился ли запрос и пишем в $_SESSION
	if ( null != $user_id ) {
		$_SESSION['name'] = $login;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['cust_id'] = $cust_id;
		$_SESSION['email'] = $email;
		// присваиваем статус
		$_SESSION['status'] = (null != $admin) ? 'admin' : 'user';
	}
	else {
		throw new Exception('Неверное имя или пароль,
								попробуйте ещё раз
								или зарегистрируйтесь...');
	}
}
//http://php.net/manual/ru/mysqli-stmt.prepare.php







/** ГОСТЕВАЯ КНИГА **/
/********************/

function get_user_message()
{
	global $link;

	$out_msg = [];

	$sql = "SELECT m.msg, m.date_time, u.login
              FROM msgs AS m, users as u
              WHERE m.user_id = u.user_id
              ORDER BY m.date_time DESC
              LIMIT 10";

	if (!$result = mysqli_query($link, $sql)) {
		throw New Exception('Невозможно подготовить запрос' . mysqli_connect_error());
	}

	while ($row = mysqli_fetch_assoc($result)) {
		$out_msg[] = $row;
	}

	return $out_msg;
}


/* save message */

function save_message($message, $login )
{
	global $link;

	$sql = "INSERT INTO msgs(user_id, msg)
              SELECT user_id, ? as msg
                FROM users
                WHERE users.login = ?";

	$stmt = mysqli_stmt_init($link);

	if(!mysqli_stmt_prepare($stmt, $sql))
		throw new Exception('Невозможно подготовить запрос');

	mysqli_stmt_bind_param($stmt, 'ss', $message, $login);

	mysqli_stmt_execute($stmt);

	mysqli_stmt_close($stmt);

	return true;

}





/*** КОРЗИНА ***/


/* basket for main */

function checkBasketForMain(){
    $basket = ['count' => 0];
    if ( isset($_COOKIE['basket']) && !empty($_COOKIE['basket']) ){
        $basket['basket'] = json_decode($_COOKIE['basket'], true);
        $basket['count'] = array_sum( $basket['basket'] );
    }
    return $basket;
}




/* basket for basket */

function checkBasketForBasket($basket)
{
    $ids = '';
    $checkBasket = ['all_sum' => 0, 'count' => 0, ];
    global $link;

    /* получаем строку из cookie для вставки в запрос к Db */
    $basket = json_decode($basket, true);
    reset($basket);
    foreach ($basket as $key => $val) {
        if ((int)$key) {
            $ids .= $key . ', ';
        }
    }
    $ids = substr($ids, 0, -2); // обрезали пробел с запятой

    /* array from Db */
    $sql = "SELECT product_id, title, price, img
              FROM products
              WHERE product_id IN($ids)";

    if( !$result = mysqli_query($link, $sql)){
        return mysqli_connect_error();
    }

    while($row = mysqli_fetch_assoc($result)){
		/* массив массивов (ключ id) */
		// array [id] = query result
        $checkBasket[$row['product_id']] = $row;
		// add quantity
        $checkBasket[$row['product_id']]['quantity'] = $basket[$row['product_id']];
		// add price
		$checkBasket[$row['product_id']]['sum'] = $row['price'] * $basket[$row['product_id']];
		// total price
		$checkBasket['all_sum'] += $row['price'] * $basket[$row['product_id']];
		// total quantity
		$checkBasket['count'] += $basket[$row['product_id']];
    }
	mysqli_free_result($result);

    return $checkBasket;

}






/*** ЗАКАЗ ***/

/**
 * insert order in Db
 *
 * PROCEDURE 'order_CustOrderEmail':
 *		in param: name, email, total price (sum).
 *		insert Customers(name), return custId
 * 		insert Orders(custId, amount(sum)), return OrderId
 * 		insert Email(custId, email);
 * 		return OrderId.
 *
 * if new Customers and no User
 */
function insert_CustOrderEmail($name, $phone, $email, $sum)
{
	global $link;

	// prepare sql
	$sql = "CALL order_CustOrderEmail(?, ?, ?, ?)";

	/* prepare stmt for PROCEDURE */
	if ( !$stmt = mysqli_prepare($link, $sql)) {
		throw new Exception('Невозможно подготовить запрос');
	}
	// prepare param
	mysqli_stmt_bind_param($stmt, 'sssi', $name, $phone, $email, $sum);
	// exec query
	if ( !mysqli_stmt_execute($stmt)) {
		throw new Exception('EXECUTE: ' . $stmt->error);
	}
	// prepare result (orderId)
	if ( !mysqli_stmt_bind_result($stmt, $orderId) ) {
		throw new Exception('BIND_RESULT: ' . $stmt->error);
	}
	// check result in $orderId
	if ( !mysqli_stmt_fetch($stmt) ) {
		throw new Exception('BIND_RESULT: ' . $stmt->error);
	}
	mysqli_stmt_close($stmt);

	return $orderId;

}


/* if new Customer is User */

function insert_U_CustOrderEmail($name, $phone, $email, $user_id, $sum)
{
    global $link;

    // prepare sql
    $sql = "CALL order_U_CustOrderEmail(?, ?, ?, ?, ?)";

    /* prepare stmt for PROCEDURE */
    if ( !$stmt = mysqli_prepare($link, $sql)) {
        throw new Exception('Невозможно подготовить запрос');
    }

    // prepare param
    mysqli_stmt_bind_param($stmt, 'sssii', $name, $phone, $email, $user_id, $sum);

    // exec query
    if ( !mysqli_stmt_execute($stmt)) {
        throw new Exception('EXECUTE: ' . $stmt->error);
    }

    // prepare result (orderId)
    if ( !mysqli_stmt_bind_result($stmt, $orderId, $cust_id) ) {
        throw new Exception('BIND_RESULT: ' . $stmt->error);
    }

    // check result in $orderId
    if ( !mysqli_stmt_fetch($stmt) ) {
        throw new Exception('BIND_RESULT: ' . $stmt->error);
    }

    mysqli_stmt_close($stmt);

    return ['order_id' => $orderId, 'cust_id' => $cust_id];

}



/* if User is Customer*/

function insert_C_CustOrderEmail($email, $user_id, $cust_id, $sum)
{
    global $link;

    // prepare sql
    $sql = "CALL order_C_CustOrderEmail(?, ?, ?, ?)";

    /* prepare stmt for PROCEDURE */
    if ( !$stmt = mysqli_prepare($link, $sql)) {
        throw new Exception('Невозможно подготовить запрос');
    }

    // prepare param
    mysqli_stmt_bind_param($stmt, 'siii', $email, $user_id, $cust_id, $sum);

    // exec query
    if ( !mysqli_stmt_execute($stmt)) {
        throw new Exception('insert_C_CustOrderEmail EXECUTE: ' . $stmt->error);
    }

    // prepare result (orderId)
    if ( !mysqli_stmt_bind_result($stmt, $orderId) ) {
        throw new Exception('insert_C_CustOrderEmail BIND_RESULT: ' . $stmt->error);
    }

    // check result in $orderId
    if ( !mysqli_stmt_fetch($stmt) ) {
        throw new Exception('insert_C_CustOrderEmail FETCH: ' . $stmt->error);
    }

    mysqli_stmt_close($stmt);

    return $orderId;

}



/*
 * INSERT in orders_items
 * */

function insert_Order_Items($orderId, $checkBasket)
{
	global $link;

	// string sql
	$sql = "INSERT INTO Order_Items VALUES(?, ?, ?, ?)";
	// prepare stmt
	if( !$stmt = mysqli_prepare($link, $sql) ) {
		throw new Exception('Prepare: ' . mysqli_stmt_error($stmt));
	} // bind param
	if( !mysqli_stmt_bind_param($stmt, 'iiii', $orderId, $productId, $quantity, $price) ) {
		throw new Exception('Bind param: ' . mysqli_stmt_error($stmt));
	}

	/* foreach BIG BASKET and execute */
	foreach( $checkBasket as $val ) {
		if ( !is_array($val) )
			continue;
		$productId = $val['product_id'];
		$quantity = $val['quantity'];
		$price = $val['price'];

		// execute with bind param
		if( !mysqli_stmt_execute($stmt) ) {
			throw new Exception('insert_Order_Items, Execute: ' . mysqli_stmt_error($stmt));
		}
	}

	mysqli_stmt_close($stmt);
}



/*
 * GET data on customer of Db
 * */

function getDataOnCustomer($user_id, $cust_id)
{
    global $link;

    $sql = "SELECT C.name, C.phone
	FROM Customers C
	INNER JOIN Users U
	ON C.customer_id = U.customer_id
	WHERE U.user_id = '$user_id'
      AND U.customer_id = '$cust_id'";

    if( !$result = mysqli_query($link, $sql)){
        echo 'getDataOnCustomer ' . mysqli_connect_error();
    }

    return mysqli_fetch_assoc($result);
}



/*
 * send a message email
 * */
function sendMessage($mail, $stringMess)
{
	$to = $mail;
	$subject = 'gamazin';
	$message = $stringMess;
	$headers = 'From: al-loco$mail.ru' . "\r\n" .
			   'Content-type: text/html; charset=utf-8' . "\r\n";

	if ( !mail($to, $subject, $message, $headers) ) {
		throw new Exception('Error: mail');
	}
}


/*
 * change customer data of order
 *
 * изменяем данные Customer'а во время заказа
 *
 */

function changeCustomerData( $userId, $login, $password, $phone, $name, $email )
{
    global $link;

    $password = cleanStr($password);
    $phone = cleanStr($phone);
    $name = cleanStr($name);
    $email = cleanStr($email);

    if( !validName($name) ) {
        throw new Exception('Неправильно введено имя');
    }

    if ( !validEmail($email) ){
        throw new Exception('Неправильно указан email');
    }

    $sql = 'CALL change_cust_data(?,?,?,?,?,?)';

    if ( !$stmt = mysqli_prepare($link, $sql) ) {
        throw new Exception('Невозможно подготовить запрос');
    }

    mysqli_stmt_bind_param( $stmt, 'isssss', $userId, $login, $password, $phone, $name, $email );

    // exec query
    if ( !mysqli_stmt_execute($stmt) ) {
        throw new Exception('EXECUTE: ' . $stmt->error);
    }

    // prepare result - вернется не массив, а сразу значение.
    if ( !mysqli_stmt_bind_result($stmt, $result) ) {
        throw new Exception('BIND RESULT: ' . $stmt->error);
    }

    if ( !mysqli_stmt_fetch($stmt) ) {
        throw new Exception('FETCH: ' . $stmt->error);
    }

    mysqli_stmt_close($stmt);

    return $result;
}



/*
 * change customer data of order
 *
 * изменяем данные User'а во время заказа
 *
 */

function changeUserData( $login, $email, $password )
{
    global $link;

    $password = cleanStr($password);
    $email = cleanStr($email);



    if ( !validEmail($email) ) {
        throw new Exception('Неправильно указан email');
    }

    $sql = 'CALL change_user_data(?,?,?)';

    if ( !$stmt = mysqli_prepare($link, $sql) ) {
        throw new Exception('Невозможно подготовить запрос...');
    }

    mysqli_stmt_bind_param($stmt, 'sss', $login, $password, $email );

    if ( !mysqli_stmt_execute($stmt) ){
        throw new Exception('EXECUTE ' . $stmt->error);
    }

    // prepare result - вернется не массив, а сразу значение.
    if ( !mysqli_stmt_bind_result($stmt, $result) ) {
        throw new Exception('BIND RESULT: ' . $stmt->error);
    }

    if ( !mysqli_stmt_fetch($stmt) ) {
        throw new Exception('FETCH: ' . $stmt->error);
    }

    mysqli_stmt_close($stmt);

    return $result;

}