<?php
if( empty($_POST) ){
    header("HTTP/1.0 404 Not Found");
    exit;
}

require_once(__DIR__ . '/../inc/include.php');
require_once(__DIR__ . '/../view/do_html_form_handler.php');