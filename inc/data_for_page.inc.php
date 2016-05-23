<?php
// вызов функции в header
function data_for_page($user=''){
	$arr = array();
	$uri = $_SERVER['REQUEST_URI'];
	
	$arr[0] = ($uri == '/admin/upload_products.php') ? '../' : '' ;
	
	if($user){
		$arr[1] = "\n<div id='helloUser'>Hello " .$user. " !</div>\n
			
					<form method='post' action='".$arr[0]."form_handler.php'>\n
						<input type='hidden' name='page' value='exit'>\n
						<input type='hidden' name='dir' value='".$uri."'>\n
						<input type='image' id='exit' src='/img/marking/transparence.png'>\n
					</form>\n";
	}else{
		$arr[1] = "\n<form method='post' action='".$arr[0]."form_handler.php'>\n
						<input type='hidden' name='page' value='enter'>\n
						<input type='hidden' name='dir' value='".$uri."'>\n
						<input type='text' class='pl' name='login'>\n
						<input type='password' class='pl' name='pass'>\n
						<input type='image' src='/img/marking/transparence.png'>\n
					</form>\n";
		};
	
	
	switch($uri){
		case "/admin/upload_products.php":
			$arr[2] = "<script src='../js/uploads_prod.js'></script>";
			$arr[3] = '../';
			break;
		
		case "/index.php":
			$arr[2] = '';//"<script src='js/showItems.js'></script>";
			$arr[3] = '';
			break;
	};
	return $arr;
}