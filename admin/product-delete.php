<?php
 require '../config/function.php';

$paramResultid = checkParamId('id');

if(is_numeric($paramResultid)){
    $productId = validate($paramResultid);
    $product  = getById('product', $productId);
    if($product['status'] == 200)
    {
        $response = delete('product', $productId);
        if($response)
        {
         /*   $deleteImage = "../".$product['data']['image'];
            if(file_exists($deleteImage)){
                unlink($deleteImage);
            }
         */
            redirect('product.php','Product Deleted Successully!!');
        }
        else{
            redirect('product.php','Something Went Wrong!!');
        }

    }else{
        redirect('product.php',$product['message']);
    }

}else{
    redirect('product.php','Something Went Wrong!!');
}