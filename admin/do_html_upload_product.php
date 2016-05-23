<?
function do_html_upload_product(){
	$menu = getProducts();
	
?>
<!--MAIN-->
			<div id='main'>
				<div id='center'>
					<form id='upload' action='../form_handler.php' enctype='multipart/form-data' method='POST'>
					<input type="hidden" name="page" value="upload">
					<!-- список товара -->
					<?
					foreach($menu as $keyCategory => $arrayCategory){ 
						$cnt = 0;
					?>
						<div class = 'category'>
							<div><?=$keyCategory?></div>

							<? 
							foreach($arrayCategory as $keyTitle => $arrayTitle){ 
							?>
								<div class='submenu'>
									<div class = 'title'><?=$keyTitle?></div>
								</div>
							<?
						 	}
							?>
						</div>
					<?
					 }
					?>
					<hr>
					<hr>
				</form>
				<form id='newUpload' action='../form_handler.php' enctype='multipart/form-data' method='POST'>
					<input type="hidden" name="page" value="upload">
					<p class = 'category'>Новая категория: <input type='text' name='category'></p>
					<p class = 'newTitle'>Новое название: <input type='text' name='title'></p>
					<p class = 'newForm'>
						Цена:
						<input type='text' name='price' size='6'>
						<br>
						<br>
						Изображение:
						<input type='file' name='img'>
						<br>
						<br>
						<input type='submit' value='Отправить'>
					</p>
				</form>
			<div id='carton_reg'></div>
			</div>
		</div>
	</div>
<?php
}
?>