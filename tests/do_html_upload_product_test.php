<?
require_once('../inc/gamaz_lib.inc.php');


function do_html_upload_product(){
	$menu = getProducts();
?>
<!--MAIN-->
			<div id='main'>
				<div id='center'>
				<form action='../form_handler.php' enctype='multipart/form-data' method='POST'>
				<input type="hidden" name="page" value="upload">
				<!-- список товара -->
			<? 
				foreach($menu as $keyMenu => $valMenu){ 
					$cnt = 0;
			?>
					<div class = 'category'><?=$keyMenu?></div>
					<!-- скрытое поле -->
					<input type="hidden" name="category" value="<?=$keyMenu?>">
					<div class='submenu'>
					
				<? 
					foreach($valMenu as $keyValMenu => $valValMenu){ 
				?>
						<div class = 'title'><?=$keyValMenu?></div>
						<input type="hidden" name="title" value="<?=$keyValMenu?>">
						<div class='buttMenu'>
							<p>Цена: <input class='button' type='text' name='price' size='6'>
							Изображение: <input name='img' type='file'/></p>
<!--							<input type="hidden" name="imgUrl" value="../img/<?/*=$valValMenu[$cnt]['product_id']*/?>">-->
							<?=$valValMenu[$cnt]['product_id']?>
							<p><input type="submit" value="Отправить"></p>
						</div>
						
						
						
						
						
						<?
						$cnt++;
					 }
					?>
				<?
				 }
				?>
				<p>Новая категория: <input type='text' name='newCat'>Новое название: <input type='text' name='newTit'></p>
					<p></p>
				</div>
					</form>
				<div id='carton_reg'></div>
			</div>
		</div>
<?php
}
do_html_upload_product();
?>