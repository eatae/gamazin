<?php
/**
 * @param checkBasket = BIG BASKET from DB
 * возвращаем во view функцию которая содержит в себе форму
 */
return function(array $checkBasket) {
    include_once(__DIR__.'/basketForm.php');
};