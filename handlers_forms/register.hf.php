<?php
include_once(__DIR__ . '/top_include.php');

$reg = [];
$reg['email'] = cleanStr($_POST['email']);
$reg['login'] = cleanStr($_POST['login']);
$pass1 = cleanStr($_POST['pass1']);
$pass2 = cleanStr($_POST['pass2']);

$reg['passwd'] = validPass($pass1, $pass2);

try {
    //проверка заполненности полей
    if (!lookPost())
        throw new Exception('Заполните все поля');

    if (!validLogin($reg['login']))
        throw new Exception('Login должен содержать не менее трёх символов');

    //проверка валидности email
    if (!validEmail($reg['email']))
        throw new Exception('Недопустимый адрес email');

    //проверка пароля
    if (!$reg['passwd'])
        throw new Exception('Нужно указать пароль не меньше 5 и не больше 20 символов');

    //регистрация пользователя и запись в сессию
    regUser($reg);

    $tit = 'All good!';
    $message = 'Вы успешно зарегистрированы!';

    header("Refresh: 2; url= ../index.php");

    do_html_header($tit);
    do_html_form_handler($message);
    do_html_footer();

} catch (Exception $e) {
    do_html_header('Problem: ');
    $href = '<br><br><a href="javascript:history.back()">Назад</a>';
    do_html_form_handler($e->getMessage(), $href);
    do_html_footer();
    exit;
};