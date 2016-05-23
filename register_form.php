<?php
require_once('inc/gamaz_lib.inc.php');
require_once('inc/data_for_page.inc.php');

require_once('view/do_html_header.php');
require_once('view/do_html_register_form.php');
require_once('view/do_html_footer.php');

$title = 'Форма регистрации';

do_html_header($title);
do_html_register_form();
do_html_footer();
?>