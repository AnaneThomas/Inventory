<?php
 require '../config/function.php';

$paramResultid = checkParamId('id');

if(is_numeric($paramResultid)){
    $adminId = validate($paramResultid);
    $admin  = getById('admin', $adminId);
    if($admin['status'] == 200)
    {
        $adminDeleteRes = delete('admin', $adminId);
        if($adminDeleteRes)
        {
            redirect('admin.php','Admin Deleted Successully!!');
        }
        else{
            redirect('admin.php','Something Went Wrong!!');
        }

    }else{
        redirect('admin.php',$admin['message']);
    }

}else{
    redirect('admin.php','Something Went Wrong!!');
}