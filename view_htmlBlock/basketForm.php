    <div class='down_form'>
        <div class='inner_down_form'>

            <!--  DOWN_FORM_QUANTITY   DOWN_FORM_TOTAL_SUM  -->
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

                <div class='submit'>
                    <!-- блок применяется в basket.php поэтому 'form_handler.php' -->
                    <form id='form_user' method='post' action='handlers_forms/order.hf.php'>
                        <!-- скрытые поля для form_handler -->
<!--                        <input type='hidden' name='page' value='basket'>-->
                        <input type='hidden' name='sum' value='<?=$checkBasket['all_sum']; ?>'>
                        <p>
                            <label for='email'>Email:</label>
                            <input name="email" type="text">
                        </p>
                        <p>
                            <label for='name'>Имя:</label>
                            <input name="name" type="text">
                        </p>
                        <p>
                            <label for='phone'>Телефон:</label>
                            <input name="phone" type="text">
                        </p>
                        <p>
                            <input type='submit' value='Заказать'>
                        </p>
                    </form>
                </div>

            </div>

            <div class='carton_basket'></div>

            <div class='inner_down'>
                * Можно указать реально существующий email, чтобы увидеть письмо.
            </div>


        </div>
    </div>