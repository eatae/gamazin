<?php
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'eatae');
define('DB_PASS', '');
define('DB_NAME', 'gamazin');

$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME)
	or die(mysqli_connect_error());