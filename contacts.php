<?php
require_once(__DIR__ . '/inc/include.php');
require_once(__DIR__ . '/view/do_html_contacts.php');

$title = 'Контакты';

do_html_header($title);
do_html_contacts();
do_html_footer();
?>