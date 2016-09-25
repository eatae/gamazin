<?php
function do_html_basket()
{
    $checkBasket = checkBasketForBasket($_COOKIE['basket']);

//    echo '<pre>';
//    print_r($inBasket);
?>

			<!--MAIN-->
			<div id='main'>
				<div id='center'>
                    <!--CONTENT-->
                        <div id='in_basket'>

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


                        <!--  DOWN FORM  -->
                        <div class='down_form'>
                            <div class='inner_down_form'>


                                <!--  DOWN_FORM_QUANTITY   DOWN_FORM_PRICE  -->
                                <div class='inner_block_left'>
                                    <div class='all_count'>
                                        <div>
                                            Количество: <span id='all_count'><?=$checkBasket['count']; ?></span>
                                        </div>
                                    </div>
                                    <div class='all_sum'>
                                        <div>
                                            Стоимость:
                                            <span id='all_sum'><?=$checkBasket['all_sum']; ?></span>
                                            кл
                                        </div>
                                    </div>
                                </div>


                                <div class='inner_block_right'>
                                    <div>email:</div>
                                    <form onsubmit='name_action()'>
                                        <input type='text' name='email'>
                                        <input type='submit'>
                                    </form>
                                </div>

                                <div class='carton_basket'></div>

                                <div class='inner_down'>
                                    * Можно указать реально существующий email, чтоб посмотреть как работает.
                                </div>


                            </div>
                        </div>
                        <div id='carton1'></div>
				</div>
			</div>
		</div>

<?php
}   //end function
