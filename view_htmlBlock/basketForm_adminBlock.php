<?php
return function(array $checkBasket)
{
    /* если покупатель */
    if ( null != $_SESSION['cust_id'] ) {

        $dataOnCustomer = getDataOnCustomer( $_SESSION['user_id'], $_SESSION['cust_id'] );
        include_once(__DIR__ . '/basketForm_c.php');
    }
    else {
        include_once(__DIR__ . '/basketForm_u.php');
    }
};