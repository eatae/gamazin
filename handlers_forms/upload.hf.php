<?php
include_once(__DIR__ . '/top_include.php');


$upload = [];
$upload['up_cat'] = cleanStr($_POST['category']);
$upload['up_tit'] = cleanStr($_POST['title']);
$upload['up_price'] = cleanNum($_POST['price']);

$upload['file_type'] = getTypeImg($_FILES['img']['type']);
$upload['file_dir_tmp'] = $_FILES['img']['tmp_name'];
$upload['file_dir_final'] = '';


try {
    foreach ($_POST as $key => $value) {
        if (empty($value))
            throw new Exception('Заполните, пожалуйста, все поля');
    }

    // save in Db and save image
    setProduct($upload);

    $tit = 'All good!';
    $message = 'Товар успешно добавлен!';

    header("Refresh: 1; url= ../admin/admin_panel.php");

    do_html_header($tit);
    do_html_form_handler($message);
    do_html_footer();

} catch (Exception $e) {
    do_html_header('Problem: ');
    $href = '<br><br><a href="javascript:history.back()">Назад</a>';
    do_html_form_handler($e->getMessage(), $href);
    do_html_footer();
};
