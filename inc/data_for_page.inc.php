<?php
// вызов функции в header
function data_for_page()
{
	$arr = [];
	$arr['uri'] = $_SERVER['REQUEST_URI'];
	$arr[0] = ($arr['uri'] == '/admin/admin_panel.php') ? '../' : '' ;


	switch ( $arr['uri'] ) {

		case "/admin/admin_panel.php":
			$arr[2] = "<script src='../js/uploads_prod.js'></script>\n\t" .
                "<script src='../js/adm_press_button.js'></script>";
			$arr[3] = '../';
			break;

		default:
			$arr[2] = '';
			$arr[3] = '';
	};

	return $arr;
}