<?php

if(empty($_POST)){
	header("HTTP/1.0 404 Not Found");
	exit;
}

require_once(__DIR__ . '/inc/include.php');
require_once(__DIR__ . '/view/do_html_form_handler.php');




switch($_POST['page']) {


	/**** ЗАГРУЗКА ТОВАРА ****/
	case 'upload':
		$upload = array();
		$upload['up_cat'] = cleanStr($_POST['category']);
		$upload['up_tit'] = cleanStr($_POST['title']);
		$upload['up_price'] = cleanNum($_POST['price']);

		$upload['file_type'] = getTypeImg($_FILES['img']['type']);
		$upload['file_dir_tmp'] = $_FILES['img']['tmp_name'];
		$upload['file_dir_final'] = '';

		try {
			setProduct($upload);

			$tit = 'All good!';
			$message = 'Товар успешно добавлен!';


			header("Refresh: 2; url= admin/upload_products.php");

			do_html_header($tit);
			do_html_form_handler($message);
			do_html_footer();
		} catch (Exception $e) {
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

		try {
			//проверка заполненности полей
			if (!lookPost())
				throw new Exception('Заполните все поля');

			if (!validLogin($reg['login']))
				throw new Exception('Login должен содержать не менее трёх символов');

			//проверка валидности email
			if (!validEmail($reg['email']))
				throw new Exception('Недопустимый адрес email');

			//проверка пароля
			if (!$reg['passwd'])
				throw new Exception('Нужно указать пароль не меньше 5 и не больше 20 символов');

			//регистрация пользователя и запись в сессию
			regUser($reg);

			$tit = 'All good!';
			$message = 'Вы успешно зарегистрированы!';

			header("Refresh: 2; url= ../index.php");

			do_html_header($tit);
			do_html_form_handler($message);
			do_html_footer();

		} catch (Exception $e) {
			do_html_header('Problem: ');
			$href = '<br><br><a href="javascript:history.back()">Назад</a>';
			do_html_form_handler($e->getMessage(), $href);
			do_html_footer();
			exit;
		};
		break;



	/**** ВХОД ****/

	case 'enter':

		$reDir = $_POST['dir'];
		if ( $_POST['dir'] == '/admin/upload_products.php' ) $reDir = '../'.$_POST['dir'];

		try {
			if (!lookPost())
				throw new Exception('Заполните все поля или зарегестрируйтесь');

			/* login */
			$login = cleanStr($_POST['login']);

			if (!validLogin($login))
				throw new Exception('Имя должно содержать больше трёх символов');

			/* password */
			$pass = cleanStr($_POST['pass']);//no sha1
			if (!$pass or strlen($pass) < 5)

				throw new Exception('Неверный пароль');

			/* query Db and set $_SESSION*/
			enterUser($login, $pass);

			header("Refresh: 2; url=$reDir");

			$message = 'Вы успешно вошли в систему!';

			do_html_header($tit);
			do_html_form_handler($message);
		} catch (Exception $e) {
			$href = "<br><br><a href='../register_form.php'>Регистрация</a>";
			do_html_header('Problem: ');
			do_html_form_handler($e->getMessage(), $href);
			exit;
		}
		break;



	/**** ВЫХОД ****/

	case 'exit':
		$old_user = $_SESSION['name'];

        $reDir = $_POST['dir'];
        if ( $_POST['dir'] == '/admin/upload_products.php' ) $reDir = '../'.$_POST['dir'];

		header("Refresh: 2; url=$reDir");

		if ( !empty($old_user) ) {
			$tit = 'Выход';
			$message = 'Вы успешно вышли из системы!';
			$_SESSION = [];
            setcookie( session_name(), '', time() - 42000 );
            session_destroy();

			do_html_header($tit);
			do_html_form_handler($message);
		} else {
			$message = 'Не получается выйти из системы!';
			do_html_header($tit);
			do_html_form_handler($message);
		};
		break;



	/**** ГОСТЕВАЯ ****/

	case 'message':
		try {
			/* проверяем заполненность */
			if( !lookPost() )
				throw new Exception('Заполните текстовое поле!');

			/* фильтруем текст сообщения */
			$text = cleanStr($_POST['message']);

			/* записываем сообщение в БД */
			save_message($text, $_SESSION['name']);

			/* показываем красивое сообщение и перенаправляем */
			header("Refresh: 2; url='guestbook.php'");
			do_html_header('All good');
			do_html_form_handler('Сообщение успешно добавлено!');

		} catch (Exception $e) {
			$href = '<br><br><a href="javascript:history.back()">Назад</a>';
			do_html_header('Problem: ');
			do_html_form_handler($e->getMessage(), $href);
			exit;
		}
		break;





	/**** КОРЗИНА ЗАКАЗ ****/

	case 'basket':
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

			// clear basket and refresh
			header( "Set-cookie: basket=");
			header( "Refresh: 2; url='index.php'" );

            $name = !empty($name) ? $name : $_SESSION['name'];
            $mail = !empty($mail) ? $mail : $_SESSION['email'];

			// send mail
			$stringMess = $name . ', благодарим Вас за заказ.';
			sendMessage($mail, $stringMess);

			do_html_header( 'All good' );
			do_html_form_handler( $name . ', благодарим Вас за заказ.' );



		} catch ( Exception $e ) {
			$href = '<br><br><a href="javascript:history.back()">Назад</a>';
			do_html_header('Problem: ');
			do_html_form_handler( $e->getMessage(), $href );
			exit;
		}
		break;
}

?>