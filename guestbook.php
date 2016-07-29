<?php
require_once('inc/gamaz_lib.inc.php');
require_once('inc/data_for_page.inc.php');

require_once('view/do_html_header.php');
require_once('view/do_html_guest_book.php');
require_once('view/do_html_footer.php');

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