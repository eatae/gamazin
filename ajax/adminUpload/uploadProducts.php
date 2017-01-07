<?
include_once(__DIR__ . '/../../inc/include.php');
$menu = getProducts();
?>

<form id='upload' action='../../handlers_forms/upload.hf.php' enctype='multipart/form-data' method='POST'>
					<!-- список товара -->
					<?
					foreach($menu as $keyCategory => $arrayCategory):
						$cnt = 0;
					?>
						<div class = 'category'>
							<div><?=$keyCategory?></div>

							<? 
							foreach($arrayCategory as $keyTitle => $arrayTitle):
							?>
								<div class='submenu'>
									<div class = 'title'><?=$keyTitle?></div>
								</div>
							<?
							endforeach;
							?>
						</div>
					<?
					endforeach;
					?>

				</form>
<form id='newUpload' action='../../handlers_forms/upload.hf.php' enctype='multipart/form-data' method='POST'>
				    <hr>

					<input type="hidden" name="page" value="upload">

					<p class = 'category'>
					    <label for='category'>Новая категория:</label>
					    <input type='text' name='category'>
					</p>

					<p class = 'newTitle'>
					    <label for='title'>Новое название:</label>
					    <input type='text' name='title'>
					</p>

					<p class = 'newForm'>
						<label for='price'>Цена:</label>
						<input type='text' name='price'>
						<br>
						<br>
						<label for='img'>Изображение:</label>
						<input type='file' name='img'>
						<br>
						<br>
						<input type='submit' value='Отправить'>
					</p>
				</form>
	</div>