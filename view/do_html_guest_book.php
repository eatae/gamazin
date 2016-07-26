<?php
function do_html_guest_book(){
?>

			<!--MAIN-->
			<div id='main'>
				<div id='center'>
					
					
					<!--CONTENT-->
					<div id='wrapMessage'>
					<p class="message">

					</p>
						 <!--картонка-->
						<div id='carton1'></div>
					</div>
						 <!--картонка-->
<!--					<div id='carton2'></div>-->
				</div>
			</div>
		</div>
<?
//menu();
//for showItems.js
if($_GET['basket']){
		echo '<script>showItems('.'\''.$_GET['tit'].'\''.','.'\'id_'.$_GET['basket'].'\''.');</script>';
	}
}
?>