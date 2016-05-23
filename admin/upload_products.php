<?
//ЗАГРУЗКА ПРОДУКТОВ
require_once('../inc/gamaz_lib.inc.php');
require_once('../inc/data_for_page.inc.php');

require_once('../view/do_html_header.php');
require_once('do_html_upload_product.php');
require_once('../view/do_html_footer.php');

$title = 'Загрузка продуктов';

do_html_header($title);
do_html_upload_product();
do_html_footer();
?>