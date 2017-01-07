<?php
function do_html_header( $tit )
{
	$pageData = data_for_page();

    // нажатая кнопка меню
    $active_button = [];

    switch ($_SERVER['PHP_SELF']) {
        case '/index.php':
            $active_button = ["class='active'", '', ''];
            break;
        case '/guestbook.php':
            $active_button = ['', "class='active'", ''];
            break;
        case '/contacts.php':
            $active_button = [ '', '', "class='active'"];
            break;
    }
?>

<!DOCTYPE html>
<html lang='ru'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href='/style/style.css' rel='stylesheet' type='text/css'>
	<link href='https://www.google.com/fonts#ChoosePlace:select/Collection:Russo+One/Script:cyrillic'>
	<title><?=$tit?></title>
	<script src='/js/leftMenu.js'></script>
	
	<!-- AJAX -->
	<script type='text/javascript' src='/js/xmlHttpRequest.js'></script>
	<script type='text/javascript' src='/js/ajaxLibrary.js'></script>
	
	<!-- tag <script> for upload_products -->
	<?=$pageData[2]?>
</head>

<body>
	<div id='wrapper'>
<!--	<img id='grid' src="img/marking/grid_5px.png">-->
		<div id='outer'>
			<div class='indent'></div>
			
			<!--HEADER-->
			<div id='header'>
				<img src='/img/marking/header.jpg'/>
			</div>
			
			<!--TOP-->
			<div id='top'>
				<!--TOP MENU-->
				<div id='topmenu'>
					<ul>
						<li><a href='<?=$pageData[3]?>index.php' <?=$active_button[0]?>>Почемучто</a></li>
                        <li><a href='<?=$pageData[3]?>guestbook.php' <?=$active_button[1]?>>Отзывы</a></li>
						<li><a href='<?= $pageData[3] ?>contacts.php' <?= $active_button[2] ?>>Контакты</a></li>
					</ul>

					<? getHtmlBlock('enter', $pageData); ?>

				</div>
			</div>

<?php
} /*end function*/
?>