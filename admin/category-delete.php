<?php
 require '../config/function.php';

$paramResultid = checkParamId('id');

if(is_numeric($paramResultid)){
    $categoryId = validate($paramResultid);
    $category  = getById('category', $categoryId);
    if($category['status'] == 200)
    {
        $response = delete('category', $categoryId);
        if($response)
        {
            redirect('category.php','Category Deleted Successully!!');
        }
        else{
            redirect('category.php','Something Went Wrong!!');
        }

    }else{
        redirect('category.php',$category['message']);
    }

}else{
    redirect('category.php','Something Went Wrong!!');
}