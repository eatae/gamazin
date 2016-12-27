<?php
// АДМИНКА
require_once('../inc/include.php');

require_once('../view/do_html_header.php');
require_once('do_html_admin_panel.php');
require_once('../view/do_html_footer.php');

$title = 'Админ панель';

do_html_header($title);
do_html_admin_panel();
do_html_footer();
?>