<?php
require_once(__DIR__ . '/inc/include.php');
require_once(__DIR__ . '/view/do_html_main.php');

$title = 'Магазин-Гамазин';
//phpinfo();
do_html_header($title);
//var_dump($_COOKIE);
//var_dump($_SESSION);
do_html_main();
do_html_footer();
?>