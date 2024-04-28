<?php
 require '../config/function.php';

$paramResultid = checkParamId('id');

if(is_numeric($paramResultid)){
    $customerId = validate($paramResultid);
    $customer  = getById('customer', $customerId);
    if($customer['status'] == 200)
    {
        $response = delete('customer', $customerId);
        if($response)
        {
            redirect('customer.php','Customer Deleted Successully!!');
        }
        else{
            redirect('customer.php','Something Went Wrong!!');
        }

    }else{
        redirect('customer.php',$customer['message']);
    }

}else{
    redirect('customer.php','Something Went Wrong!!');
}