<?php
require_once(__DIR__ . '/inc/include.php');
require_once(__DIR__ . '/view/do_html_guest_book.php');


$title = 'Магазин-Гамазин';

try {
    $out_msg = get_user_message();

    do_html_header($title);
    do_html_guest_book($out_msg);
    do_html_footer();

} catch(Exception $e) {
    do_html_header( 'Problem: ' );
    $href = '<br><br><a href="javascript:history.back()">Назад</a>';
    do_html_guest_book( '', $e->getMessage(), $href );
    do_html_footer();
    exit;
};
?>