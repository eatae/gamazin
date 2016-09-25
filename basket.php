<?php
require_once(__DIR__ . '/inc/include.php');
require_once(__DIR__ .'/view/do_html_basket.php');

$title = 'Корзина';

do_html_header($title);
do_html_basket();
do_html_footer();
?>