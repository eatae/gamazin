<?
header("Content-type: text/html; charset=utf-8");
require_once(__DIR__ . "/../inc/gamaz_db.inc.php");


$title = $_GET['title_name'];

if (!empty($title)) :
	$sql = "SELECT * FROM Products
				WHERE title = '$title'";
	$result = mysqli_query($link, $sql) or die('not prdcts'.mysqli_connect_error());

	while ($prods = mysqli_fetch_assoc($result)) : ?>

		<div class='choice'>
			<a name='<?=$prods['product_id'] ?>'></a>
			<img src='<?= (is_file(__DIR__ . '/../' . $prods['img'])) ? $prods['img'] : 'img/def.jpg' ?>' class='photo'>
			<div class = 'name'>
				<?=$prods['title'] ?>
				<span class='price'><?=$prods['price'] ?> кл.</span>
			</div>
			<div class = 'button_choice'>
				<a name = '<?=$prods['product_id'] ?>' onclick="basketFromMain(this)">В корзину</a>
			</div>
		</div>

<?  endwhile;

endif;

mysqli_free_result($result);
mysqli_close($link);
?>
