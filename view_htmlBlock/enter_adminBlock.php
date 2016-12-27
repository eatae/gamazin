<?php
/**
 * заглушечку ставим
 */
return function($data) {
    $foo = include_once(__DIR__ . '/enter_userBlock.php');
    $foo($data);
};