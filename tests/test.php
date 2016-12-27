<?php
//phpinfo();
require_once(__DIR__ . '/../inc/include.php');

//header("Content-Type: text/html; charset=utf-8");
















/*
$sql = "CALL change_cust_data(5, 'User5', '55555', '89261778779', 'Покупатель N5', 'user5@mail.ru')";

$result = mysqli_query($link, $sql);



var_dump( mysqli_fetch_assoc($result)['dec_custId'] );












/*
 *
function orderEmail($name, $email, $sum)
{
	$name = cleanStr($name);
	$email = cleanStr($email);
	$sum = cleanNum($sum);

	global $link;
	$sql = "CALL order_CustOrderEmail('$name', '$email', $sum)";

	if( !$result = mysqli_query($link, $sql) ) {
		echo 'Bad query';
		var_dump($result);
	}
	echo mysqli_fetch_row($result)[0];
	//print_r(mysqli_fetch_row($result));

}

orderEmail('Name', 'Email', 200);















//$category = array();
//$title = array();
//$menu = array();
//
//
//
//
//$reg = [
//		'login' => 'www',
//		'passwd' => 'wwwww',
//		'email' => 'www@tt.ru'
//		];
//extract($reg);
//echo $login . '<br>', $email . '<br>';
//$sql = "CALL reg_user('$login', '$passwd', '$email')";
//$result = mysqli_query($link, $sql);
//$result = mysqli_fetch_row($result);
//var_dump($result);
//
//

//
//
//
//
///** ВЫБОРКА ДЛЯ МЕНЮ **/
//$sql = "SELECT * FROM products";
//
//if(!$result = mysqli_query($link, $sql))
//	printf('Ошибка: %s\n', mysqli_connect_error());
//
////
////for($cnt = 0; $row = mysqli_fetch_assoc($result); $cnt++){
////	$prods[$cnt] = $row;
////	$category[] = $prods[$count]['category'];
////	$title[] = $prods[$count]['title'];
////}
////
////$category = array_unique($category);
////$title = array_unique($title);
//
//function selectProduct(){
//	global $result, $prods, $category, $title, $menu;
//	for($cnt = 0; $row = mysqli_fetch_assoc($result); $cnt++){
//		$prods[$cnt] = $row;
//		$menu[$prods[$cnt]['category']][$prods[$cnt]['title']][] = $prods[$cnt];
//		$category[] = $prods[$cnt]['category'];
//		$title[] = $prods[$cnt]['title'];
//	};
//
//	$category = array_unique($category);
//	$title = array_unique($title);
//}
//selectProduct();
//
//
//function structArrMenu(){
//	foreach($menu as $keyMenu => $valMenu){
//		echo $keyMenu.'<br><br>';
//		foreach($valMenu as $keyValMenu => $valValMenu){
//			echo $keyValMenu.' menu <br>';
//			for($i = 0; $i < count($valValMenu); $i++){
//				echo '^^^^^^'.$valValMenu[$i]['title'].'^^^^^^'.$valValMenu[$i]['price'].'<br>';
//			};
//
//
//		};
//
//	};
//}
////print_r($menu);
//
//
//
//
//









//
//
//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
//var_dump($prods);
//echo '<br><br><br><br>';
//var_dump($category);
//echo '<br><br><br><br>';
//var_dump($title);








//	unset($res[$row['user_id']]['user_id']);

//function(){
//		if($prods[$cnt]['category'] == $category[$prods[$cnt]['category']])
//		return $prods[$cnt]['title'];
//}

	
//	foreach($res as $res_key => $res_val){
//		if($res_val['category'] == $cat_val)
//			echo "<br>___".$res_val['title'];
//		var_dump($res_val);


//
//mysqli_free_result($result);
//mysqli_close($link);



































/*


$email = "22222@zxmn.ru";
function regUser_test(){
	global $link, $login, $passwd, $email;
	
	$sql = "SELECT LAST_INSERT_ID()";
	if(!$result = mysqli_query($link, $sql))
		echo 'Невозможно извлечь user_id';
	$user_id = mysqli_fetch_row($result);
	mysqli_free_result($result);
	print_r($row);
}
regUser_test();


$arr = array(0 => 1);
print_r($arr);
$arr = $arr[0];
echo '<br>'.$arr;
print_r($_SERVER['REQUEST_URI']);



$login = '111';

$p1 = "078517";
$p2 = "078517";

function validPass($pass1, $pass2){
	if($pass1 === $pass2)
		echo "пароли равны <br>";
	echo strlen($pass1);
	if((strlen($pass1) > 5) && (strlen($pass1) < 20))
		echo "good <br>";
	echo 'end';
}

validPass($p1, $p2);





function regUser(){
	global $link, $login;
		//проверяем есть ли такое имя в базе
	$sql = "SELECT * FROM users WHERE login=? LIMIT 1";
	
	$stmt = mysqli_stmt_init($link);
	if(!mysqli_stmt_prepare($stmt, $sql))
		echo ('Невозможно подготовить запрос 1');
	
	mysqli_stmt_bind_param($stmt, 's', $login);
	mysqli_stmt_execute($stmt);
	$obj_res = mysqli_stmt_get_result($stmt);
	$result = mysqli_fetch_assoc($obj_res);
	
	mysqli_stmt_close($stmt);
	return $result;
}

$res = regUser();
var_dump($res);
if($res)
	echo('Hi');
*/
?>