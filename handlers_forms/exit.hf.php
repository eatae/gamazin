<?php
include_once('top_include.php');

/**** ВЫХОД ****/

$old_user = $_SESSION['name'];

$reDir = $_POST['dir'];
if ( $_POST['dir'] == '/admin/admin_panel.php' ) $reDir = '../'.$_POST['dir'];

header("Refresh: 2; url=$reDir");

if ( !empty($old_user) ) {
    $tit = 'Выход';
    $message = 'Вы успешно вышли из системы!';
    $_SESSION = [];
    session_destroy();
    setcookie( session_name(), '', time() - 42000 , '/');

    do_html_header($tit);
    do_html_form_handler($message);
    do_html_footer();

} else {
    $message = 'Не получается выйти из системы!';
    do_html_header($tit);
    do_html_form_handler($message);
    do_html_footer();
};