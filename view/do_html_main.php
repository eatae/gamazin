<?php
function do_html_main(){
	global $menu;
	$menu = getProducts(); // look header
?>

			<!-- MAIN -->
			<div id='main'>
				<div id='center'>

						<!-- LEFT MENU -->
					<div id='borderleftmenu'>
						<div id='leftmenu'>
						
								
							<div id='up_leftmenu'>
							    <!-- BASKET -->
								<a id='basket' href='#'>Корзина: <?= checkBasketForMain()['count']; ?></a>
							</div>
							
							<ul>
							<?
							foreach($menu as $nameCategory => $arrayCategory):
							?>
								<li class='outmenu'>
									<p class='out'><?=$nameCategory?></p>
									<div class='submenu'>
										<div class='bla'>
											<ul>
												<?
												foreach($arrayCategory as $titleName=>$titleVal):
												?>
												    <li onclick="showProducts(this)" ><?=$titleName?></li>
												<?
												endforeach;
												?>
											</ul>
										</div>
									</div>
								</li>
								
							<?
							endforeach;
							?>
							</ul>
							
							<div id='bottom_leftmenu'>
							</div>
							
							
						</div>
					</div>
					<!--END LEFT MENU-->
					
					
					<!--CONTENT-->
					<div id='wrapContent'>
						<div id='content'> </div>
						 <!--картонка-->
						<div id='carton1'></div>
					</div>
						 <!--картонка-->
<!--					<div id='carton2'></div>-->
				</div>
			</div>
		</div>
<?
}   //end function