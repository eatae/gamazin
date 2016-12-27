<?php
/**
 * @param $block
 *
 * функция принимает имя блока (например: enter)
 * формирует путь и имя блока, и подключает его
 * блоки находятся в папке view_htmlBlock
 */
function getHtmlBlock($block, $data = null)
{
    $path = __DIR__ . '/../view_htmlBlock/' . $block . '_' . $_SESSION['status'] . 'Block.php';

    if ( !is_readable($path) || !is_callable($func = include_once($path)) ){
        echo 'Несрастушечка с блоком';
        return;
    }
    if (null != $data) {
        $func($data);
    }
    else {
        $func();
    }

}