<?php
function do_html_register_form(){
?>

<!--MAIN-->
			<div id='main'>
				<div id='center'>
					<form id='reg_form' action='form_handler.php' method="post">
						<input type="hidden" name="page" value="register">
						<p>e-mail: <input type='text' class='aaaa' name='email'></p>
						<p>login: <input type='text' class='aaaa' name='login'></p>
						<p>pass: <input type='password' class='aaaa' name='pass1'></p>
						<p>pass: <input type='password' class='aaaa' name='pass2'></p>
						<p><input type="submit" value="Отправить данные"></p>
					</form>
				
				</div>
				<div id='carton_reg'></div>
			</div>
		</div>
<?php
}
?>