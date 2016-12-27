<div class='down_form'>
    <div class='inner_down_form'>

        <!--  LEFT BLOCK   DOWN_FORM_QUANTITY   DOWN_FORM_TOTAL_SUM  -->
        <div class='inner_block_left'>
            <div class='all_count'>
                <div>Количество: <span id='all_count'><?=$checkBasket['count']; ?></span></div>
            </div>
            <div class='all_sum'>
                <div>Стоимость: <span id='all_sum'><?=$checkBasket['all_sum']; ?></span> кл</div>
            </div>
        </div>

        <!--  RIGHT BLOCK  -->
        <div class='inner_block_right'>

            <table>
                <tr>
                    <td>Ваш email:</td>
                    <td><? echo $_SESSION['email']; ?></td>
                </tr>
            </table>

            <div class='href_change'>
                <div>
                    <a href="javascript:void(null);" onclick="get_form_change_data();">Изменить</a>
                </div>
            </div>
            <hr>


            <div class='submit'>
                <!-- блок применяется в basket.php поэтому 'form_handler.php' -->
                <form id='form_user' method='post' action='handlers_forms/order.hf.php'>
<!--                    <input type='hidden' name='page' value='basket'>-->
                    <input type='hidden' name='sum' value='<?=$checkBasket['all_sum']; ?>'>
                    <p>
                        <label for='name'>Имя:</label>
                        <input name="name" type="text">
                    </p>
                    <p>
                        <label for='name'>Телефон:</label>
                        <input name="phone" type="text">
                    </p>
                    <p>
                        <input type='submit' value='Заказать'>
                    </p>
                </form>
            </div>

        </div>

        <div class='carton_basket'></div>

        <!-- LOWER BLOCK -->
        <div class='inner_down'>
            <p>* Уважаемый <span id='msg_downForm'><? echo $_SESSION['name']; ?></span>, вы являетесь зарегистрированным пользователем,</p>
            <p>чтобы оформить заказ, нужно указать имя и телефон.</p>
        </div>

    </div>
</div>
