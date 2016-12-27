<?php
function do_html_basket()
{
    /* if empty basket */
    if ( empty($_COOKIE['basket']) ) {

        $back = '<br><br><a href="javascript:history.back()">Назад</a>';

        $errorString = "<!-- MAIN -->
			            <div id='main'>
				            <div id='center'>

					        <!--CONTENT-->
					            <div id='wrapContent_noMenu'>
						            <div id='content'> </div>
                                        Ваша корзина пуста
                                        <br>
                                        $back
						                <!--картонка-->
						                <div id='carton1'></div>
					                </div>
						 <!--картонка-->
<!--					<div id='carton2'></div>-->
				            </div>
			            </div>
		            </div>";



        echo $errorString;

        return;
    }

    /* Take the BIG BASKET from DB */
    $checkBasket = checkBasketForBasket($_COOKIE['basket']);
?>

			<!--MAIN-->
			<div id='main'>
				<div id='center'>
                    <!--CONTENT-->
                        <div id='in_basket'>

                    <!--** FOREACH **-->
                        <?foreach ($checkBasket as $product):
                            if (is_array($product)) : ?>

                            <div class='one_div_basket'
                                id='<?=$product['product_id']; ?>'>


                                <!-- IMG -->
                                <div class='block_left'>
                                    <img src='<?=$product['img']; ?>'>
                                </div>


                                <!-- TITLE  ADD  DEL -->
                                <div class='block_center'>
                                    <div class='prod_title'>
                                        <?=$product['title']; ?>
                                    </div>
                                    <div class='del' onclick='basketFromBasket(this)'></div>
                                    <div class='add' onclick='basketFromBasket(this)'></div>
                                </div>


                                <!--  PRICE  QUANTITY  SUM  -->
                                <div class='block_right'>
                                    <div class='prod_price'>
                                        <?=$product['price']; ?> кл
                                    </div>
                                    <div class='operator'>
                                         *
                                    </div>
                                    <div class='prod_quantity'>
                                        <?=$product['quantity']; ?>
                                    </div>
                                    <div class='prod_sum'>
                                        <?=$product['sum']; ?> кл
                                    </div>
                                </div>


                            </div>
                            <?endif;
                          endforeach; ?>

                          <div class='carton_basket'></div>
                        </div>

<!--          TEST              -->
                        <? var_dump( $_SESSION );
                           //var_dump( $_COOKIE );
                           //var_dump(session_name());
                        ?>


                        <!--  DOWN FORM  -->
                        <? getHtmlBlock('basketForm', $checkBasket) ?>


                        <div id='carton1'></div>
				</div>
			</div>
		</div>

<?php
}   //end function
