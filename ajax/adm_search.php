<?php
include_once(__DIR__ . '/adm_ajax_func.php');

?>

<form onsubmit='return false' id="search_form">
    <select id='adm_select' onChange='example_forSearch();' title="Параметр поиска(что ищем)">
        <option selected>Email покупателя</option>
        <option>Id покупателя</option>
        <option>Id заказа</option>
        <option>Дата заказа</option>
    </select>
    <input type="text" name="search" title="Данные для поиска"/>
    <!--<input type="submit" value="Поиск" onclick="console.log(adm_select.options[adm_select.selectedIndex].value)"/>-->
    <input type="submit" value="Поиск" onclick="callForSearch();"/>
</form>

<!--SEARCH BOX-->
<div id="ajax_box_searchPanel">

</div>

