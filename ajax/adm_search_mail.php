<?php
include_once(__DIR__ . '/adm_ajax_func.php');

?>

<form action="#">
    <select id="adm_select" onChange='changed();'>
        <option selected>Email покупателя</option>
        <option>Id покупателя</option>
        <option>Id заказа</option>
        <option>Дата заказа</option>
    </select>
    <input type="text" />
    <input type="submit" value="Поиск"/>
</form>

