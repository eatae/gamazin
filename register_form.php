<?php
require_once(__DIR__ . '/inc/include.php');
require_once(__DIR__ . '/view/do_html_register_form.php');

$title = 'Форма регистрации';

do_html_header($title);
do_html_register_form();
do_html_footer();
?>