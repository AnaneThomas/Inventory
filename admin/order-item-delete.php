<?php

require '../config/function.php' ;

$paramResult = checkParamId('index');

if(is_numeric($paramResult)){

    $indexValue = validate($paramResult);

    if(isset($_SESSION['productItems']) && isset($_SESSION['productItemI'])){
        unset($_SESSION['productItems'][$indexValue]);
        unset($_SESSION['productItemI'][$indexValue]);
        redirect('order-create.php', 'Item Removed');
    }else{
        redirect('order-create.php', 'There is no Item');
    }

}else{
    redirect('order-create.php', 'Param not numeric');
}