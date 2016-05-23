<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require "gamaz_db.inc.php";


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

function getTypeImg($type){
	if($type == 'image/jpeg'){
		$type = '.jpg';
		return $type;
	}else if($type == 'image/gif'){
		$type = '.gif';
		return $type;
	}else if($type == 'image/png'){
		$type = '.png';
		return $type;
	}else if($type == 'image/bmp'){
		$type = '.bmp';
		return $type;
	}else {return false;};
}





/* ЗАПИСЬ ПРОДУКТОВ В БАЗУ */
/**
 * @param array $upload
 * @throws Exception
 */
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
	if(!empty($file_dir_tmp)){
		if(!$result = mysqli_query($link, $sql))
			throw new Exception('Hi, unable image dir query '. mysqli_connect_error());
		
		/* dir for image, default dir(in DB) = 'img/def.jpg' */
		if($file_dir_final = mysqli_fetch_row($result) and $file_dir_final[0] != ''){
			mysqli_free_result($result);
			if(!move_uploaded_file($file_dir_tmp, $file_dir_final[0]))
				throw new Exception('Товар добавлен!<br>Невозможно загрузить картинку');
		};
		
	};
}
		
	


/** ОБРАБОТКА ФОРМ **/
/*******************/
/*------------------------------*/

/* ПРОВЕРЯЕМ ЗАПОЛНЕННОСТЬ ФОРМЫ */

function lookPost(){
	foreach($_POST as $value){
		if(empty($value))
			return false;
		}
	return true;
}



/* ФИЛЬТРУЕМ СТРОКИ ФОРМЫ */

function cleanStr($form = ''){
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
			return sha1($pass1);
			//return $pass1;
	}
	return false;
}




/** РЕГИСТРАЦИЯ ВХОД И ВЫХОД ПОЛЬЗОВАТЕЛЯ **/
/***************************************/
/*-------------------------------------*/


/** РЕГИСТРАЦИЯ ПОЛЬЗОВАТЕЛЯ **/

function regUser(/*array $reg*/){
	global $link;
	/* extract array $reg */
	extract($reg);
	
	/* PROCEDURE reg_user(IN 3 @param):
		-if not user - set user, return true
		-else return 'false' */
	$sql = "CALL reg_user('$login', '$passwd', '$email')";
	
	if(!$result = mysqli_query($link, $sql))
		throw new Exception('Hi, bad query in regUser '.mysqli_connect_error());
	
	if($user = mysqli_fetch_row($result) and $user[0] === 'true')
		return true;
	
	throw new Exception('Такое имя уже есть');
	
}





/** ВХОД ПОЛЬЗОВАТЕЛЯ **/

function enter($login, $passwd){
	global $link;
	$sql = "SELECT password FROM users
				WHERE login LIKE ?";
	
	$stmt = mysqli_stmt_init($link);
	if(!mysqli_stmt_prepare($stmt, $sql))
		throw new Exception('Невозможно подготовить запрос');
	
	mysqli_stmt_bind_param($stmt, 's', $login);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$result = mysqli_fetch_assoc($result);
	// ??? login ли нужно проверять (тестим).
	if(!$login)
		throw new Exception('Неверное имя или пароль, 
								попробуйте ещё раз 
								или зарегистрируйтесь.');
	mysqli_stmt_close($stmt);
	
	/* имя есть, проверяем пароль */
	if($result['password'] != $passwd)
		throw new Exception('Неверное имя или пароль, 
								попробуйте ещё раз 
								или зарегистрируйтесь...');
	return true;
}

