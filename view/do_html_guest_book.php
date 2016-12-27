<?php
function do_html_guest_book( $out_msg, $message = 'Сообщений нет', $href = '' )
{
    if ( !$out_msg && empty($_SESSION['name']) ): ?>

            <!--MAIN-->
			<div id='main'>
				<div id='center'>
					<?=$message;?>
					<?=$href;?>
				</div>
				<div id='carton_reg'></div>
			</div>
		</div>
<?php return; endif; ?>

			<!--MAIN-->
			<div id='main'>
				<div id='center'>
					
					
					<!--CONTENT-->
					<div id='wrapMessage'>

                        <?php
                        if ( empty($_SESSION['name']) ):
                        ?>
                            <p>Оставлять отзывы могут только зарегистрированные пользователи.
                                <br><br><a href="register_form.php">Регистрация</a>
                            </p>
                        <?php
                        endif;
                        ?>

<!--                    <div class="message_box">
                            <div class="message_user_name">Вася написал(а):</div>
                            <div class="message_time">18:42 18.07.2016</div>
                            <p class="message">
                                Здесь текст сообщения.
                            </p>
                        </div>
-->
                        <?php
                        foreach ($out_msg as $in_msg):
                        ?>
                            <div class="message_box">
                                <div class="message_user_name"><?=$in_msg['login']?> написал(а):</div>
                                <div class="message_time"><?=$in_msg['date_time']?></div>
                                <p class="message">
                                    <?=$in_msg['msg']?>
                                </p>
                            </div>
                        <?php
                        endforeach;
                        ?>


                            <!-- форма -->
                        <?php
                        if ( $_SESSION['name'] ):
                        ?>
                            <div id='formMessage'>
                                <form action='handlers_forms/guest_book.hf.php' method='post'>
                                    <p>Добавить сообщение: </p>
                                     <textarea class='text_field' maxlength='500' name='message'></textarea>
                                     <input class='message_button' type='submit' value='Отправить'>
                                </form>
                            </div>

                        <?php
                        endif;
                        ?>

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
