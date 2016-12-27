<?php
include_once('top_include.php');

/**** ГОСТЕВАЯ ****/

try {
    /* проверяем заполненность */
    if( !lookPost() )
        throw new Exception('Заполните текстовое поле!');

    /* фильтруем текст сообщения */
    $text = cleanStr($_POST['message']);

    /* записываем сообщение в БД */
    save_message($text, $_SESSION['name']);

    /* показываем красивое сообщение и перенаправляем */
    header("Refresh: 2; url='../guestbook.php'");
    do_html_header('All good');
    do_html_form_handler('Сообщение успешно добавлено!');
    do_html_footer();

} catch (Exception $e) {
    $href = '<br><br><a href="javascript:history.back()">Назад</a>';
    do_html_header('Problem: ');
    do_html_form_handler($e->getMessage(), $href);
    do_html_footer();
    exit;
}
