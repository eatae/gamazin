<?
require_once('../inc/gamaz_lib.inc.php');
require_once('../inc/data_for_page.inc.php');

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
						<div class = 'category'>
							<div><?=$keyMenu?></div>

					<? 
						foreach($valMenu as $keyValMenu => $valValMenu){ 
					?>
							<div class='submenu'>
								<div class = 'title'><?=$keyValMenu?></div>
							</div>
						<?
						 }
						?>
						</div>	
					<?
					 }
					?>
<!--					<hr>-->
					<p>Новая категория: <input type='text' name='newCat'>Новое название: <input type='text' name='newTit'></p>
						<p></p>
				</form>
			</div>
			<div id='carton1'></div>
		</div>
	</div>
<?php
}
do_html_upload_product();
?>