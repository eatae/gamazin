<?
header("Content-type: text/html; charset=utf-8");
require "../inc/gamaz_db.inc.php";


$title = $_GET['title_name'];
if(!empty($title)){
	$sql = "SELECT * FROM products
				WHERE title = '$title'";
	$result = mysqli_query($link, $sql) or die('not prdcts'.mysqli_connect_error());
	while($prods = mysqli_fetch_assoc($result)){
//		echo '<pre>';
//		print_r($prods);
//		echo "<img src='../".$prdcts['img']."'>";
?>
		<div class='choice'>
			<a name='<?=$prods['product_id'] ?>'></a>
			<img src='<?=$prods['img'] ?>' class='photo'>
			<div class = 'name'>
				<?=$prods['title'] ?>
				<span class='price'><?=$prods['price'] ?> кл.</span>
			</div>
			<div class = 'button_choice'>
				<a href='#'>В корзину</a>
			</div>
		</div>
<?
	}
}
	mysqli_free_result($result);
	mysqli_close($link);
?>
