<?php
include_once('top_include.php');


/* ВХОД ПОЛЬЗОВАТЕЛЯ */

$reDir = $_POST['dir'];
if ( $_POST['dir'] == '/admin/admin_panel.php' ) $reDir = '../'.$_POST['dir'];

/* TEST */

try {
    if (!lookPost())
        throw new Exception('Заполните все поля или зарегестрируйтесь');

    /* login */
    $login = cleanStr($_POST['login']);

    if (!validLogin($login))
        throw new Exception('Имя должно содержать больше трёх символов');

    /* password */
    $pass = cleanStr($_POST['pass']);//no sha1

    if (!$pass or strlen($pass) < 5)
        throw new Exception('Неверный пароль');

    /* query Db and set $_SESSION*/
    enterUser($login, $pass);

    header("Refresh: 2; url=$reDir");

    $message = 'Вы успешно вошли в систему!';

    do_html_header($tit);
    do_html_form_handler($message);
    do_html_footer();

} catch (Exception $e) {
    $href = "<br><br><a href='../register_form.php'>Регистрация</a>";
    do_html_header('Problem: ');
    do_html_form_handler($e->getMessage(), $href);
    do_html_footer();
    exit;
}