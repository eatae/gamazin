<?php

if(empty($_POST)){
	header("HTTP/1.0 404 Not Found");
	exit;
}
require "inc/gamaz_lib.inc.php";
require_once('inc/data_for_page.inc.php');

require_once('view/do_html_header.php');
require_once('view/do_html_form_handler.php');
require_once('view/do_html_footer.php');




switch($_POST['page']){
	
	
	/**** ЗАГРУЗКА ТОВАРА ****/
	case 'upload':
		$upload = array();
		$upload['up_cat'] = cleanStr($_POST['category']);
		$upload['up_tit'] = cleanStr($_POST['title']);
		$upload['up_price'] = cleanNum($_POST['price']);
			
		$upload['file_type'] = getTypeImg($_FILES['img']['type']);
		$upload['file_dir_tmp'] = $_FILES['img']['tmp_name'];
		$upload['file_dir_final'] =	'';
	/* TEST */
//				echo '<pre>';
//				print_r($_POST);
//				print_r($_FILES);
//				if ($_FILES['img']['type'] == '')
//					echo 'Пустая строка';
//				else{echo gettype($_FILES['img']['type']);}
		try
		{
			setProduct($upload);
			
			$tit = 'All good!';
			$message = 'Товар успешно добавлен!';


			header("Refresh: 2; url= admin/upload_products.php");
			
			do_html_header($tit);
			do_html_form_handler($message);
			do_html_footer();
		}
		catch(Exception $e){
			do_html_header('Problem: ');
			$href = '<br><br><a href="javascript:history.back()">Назад</a>';
			do_html_form_handler($e->getMessage(), $href);
			//echo $fileUrl;
			//print_r($_FILES);
			do_html_footer();
			exit;
		};
	break;
	
	
	
	/**** РЕГИСТРАЦИЯ ****/
	case 'register':
		$reg = array();
		$reg['email'] = cleanStr($_POST['email']);
		$reg['login'] = cleanStr($_POST['login']);
		$pass1 = cleanStr($_POST['pass1']);
		$pass2 = cleanStr($_POST['pass2']);

		$reg['passwd'] = validPass($pass1, $pass2);

		try
		{
			//проверка заполненности полей
			if(!lookPost())
				throw new Exception('Заполните все поля');

			//проверка валидности email
			if(!validEmail($reg['email']))
				throw new Exception('Недопустимый адрес email');

			//проверка пароля
			if(!$reg['passwd'])
				throw new Exception('Нужно указать пароль не меньше 5 и не больше 20 символов');

			//регистрация пользователя
			regUser($reg);
			//запись имени в сессию 
			$_SESSION['valid_user'] = $reg['login'];

			$tit = 'All good!';
			$message = 'Вы успешно зарегистрированы!';

			header("Refresh: 2; url= index.php");

			do_html_header($tit);
			do_html_form_handler($message);
			do_html_footer();
		}

		catch (Exception $e){
			do_html_header('Problem: ');
			$href = '<br><br><a href="javascript:history.back()">Назад</a>';
			do_html_form_handler($e->getMessage(), $href);
			do_html_footer();
//			echo '<br><h1>'.$e->getMessage().'</h1><br>';
//			echo '<a href="javascript:history.back()">Назад</a>';
			exit;
		};
	break;
	
	
	
	/**** ВХОД ****/
	case 'enter':
		$login = cleanStr($_POST['login']);
		$passwd = cleanStr($_POST['pass']); //sha1
		$dir = $_POST['dir'];
		if($dir == '/form_handler.php')$dir = 'index.php';
		if($dir == '/admin/upload_products.php')$dir = '/admin/upload_products.php';
		
		try {
			enter($login, $passwd);
			$_SESSION['valid_user'] = $login;
			
			header("Refresh: 2; url=$dir");
			
			$message = 'Вы успешно вошли в систему!';
			
			do_html_header($tit);
			do_html_form_handler($message);
		}
	
		catch (Exception $e){
			$href = "<br><br><a href='register_form.php'>Регистрация</a>";
			do_html_header('Problem: ');
			do_html_form_handler($e->getMessage(), $href);
			exit;
		}
	break;
	
	
	
	/**** ВЫХОД ****/
	case 'exit':
		$old_user = $_SESSION['valid_user'];
	
		$dir = $_POST['dir'];
		if($dir == '/form_handler.php')$dir = 'index.php';
		if($dir == '/admin/upload_products.php')$dir = '../index.php';
	
		header("Refresh: 2; url=$dir");
	
		if(!empty($old_user)){
			$message = 'Вы успешно вышли из системы!';
			$_SESSION['valid_user'] = '';

			do_html_header($tit);
			do_html_form_handler($message);
		}else{
			$message = 'Не получается выйти из системы!';
			do_html_header($tit);
			do_html_form_handler($message);
		};
	break;
}
?>