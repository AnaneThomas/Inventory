<?php
   require '../config/function.php';

   if(isset($_POST['saveAdmin'])){
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1:0;

    if($name != '' && $email != '' && $password != ''){
        $emailcheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
        if($emailcheck){
            if(mysqli_num_row($emailcheck)>0){
                redirect('admin-create.php','Email Already Exit');
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'name' =>  $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban,	
        ];
        $result = insert('admin',$data);
        if($result){
            redirect('admin.php','Admin Created Successfully');
        }else{
            redirect('admin-create.php','Something Went Wrong!!');
        }

    }else{
        redirect('admin-create.php','Please fill the require fields');
    }
   }

 
 /* 
if(isset($_POST['']))
{
 $adminId = validate($_POST['admin_id']);

 $adminData = getById('admin',  $adminId );
 if($adminData['status'] != 200){
     redirect('admin-edit.php?id='.$adminId,'Please fill the require fields');
 }

     $name = validate($_POST['name']);
     $email = validate($_POST['email']);
     $password = validate($_POST['password']);
     $phone = validate($_POST['phone']);
     $is_ban = isset($_POST['is_ban']) == true ? 1:0;

     if($password != ''){
         $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
     }else{
         $hashedpassword = $adminData['data']['password'];
     }

     if($name != '' && $email != '')
     {
         $data = [
             'name' =>  $name,
             'email' => $email,
             'password' => $hashedpassword,
             'phone' => $phone,
             'is_ban' => $is_ban	
         ];
         $result = update('admin', $adminId, $data);
         if($result){
             redirect('admin-edit.php?=id'.$adminId,'Admin Updated Successfully');
         }else{
             redirect('admin-edit.php?=id'.$adminId,'Something Went Wrong!!');
         }
     }
     else{
         redirect('admin-create.php','Please fill the require fields');
     }
}
*/



if(isset($_POST['updateAdmin']))
{
    $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']); 
    
// $admin_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM admin WHERE id='$admin_id' ";
    $query_run = mysqli_query($conn, $query);


    if(mysqli_num_rows($query_run)> 0 ){
        $adminData = mysqli_fetch_array($query_run);
    }
    
        
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1:0;

    if($password != ''){
        $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
        }else{
            $hashedpassword = $adminData['password'];
        }


    $query = "UPDATE admin SET name='$name', email='$email', password='$hashedpassword', phone='$phone', is_ban='$is_ban' WHERE id='$admin_id'";

    $result = mysqli_query($conn, $query);
    
    if($result){
        redirect('admin-edit.php?id='.$admin_id ,'Admin Updated Successfully');
    }else{
        redirect('admin-edit.php?id='.$admin_id ,'Something Went Wrong!!');
    }

}

// insert category

if(isset($_POST['saveCategory'])){

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;

    $data = [
        'name' =>  $name,
        'description' => $description,
        'status' => $status,	
    ];
    $result = insert('category',$data);
    if($result){
        redirect('category.php','Category Created Successfully');
    }else{
        redirect('category-create.php','Something Went Wrong!!');
    }
    
}

// update category
/*
if(isset($_POST[''])){

    $categoryid = validate($_POST['categoryid']);

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;

    $data = [
        'name' =>  $name,
        'description' => $description,
        'status' => $status,	
    ];
    $result = update('category', $categoryid , $data);
    if($result){
        redirect('category-edit.php?id='.$categoryid,'Category Updated Successfully');
    }else{
        redirect('category-edit.php?id='.$categoryid,'Something Went Wrong!!');
    }
    
}
*/


if(isset($_POST['updateCategory']))
{
    $categoryid = mysqli_real_escape_string($conn, $_POST['categoryid']); 
    
     
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;

    $query = "UPDATE category SET name='$name', description='$description', status='$status' WHERE id='$categoryid'";

    $result = mysqli_query($conn, $query);
    
    if($result){
        redirect('category-edit.php?id='.$categoryid ,'Category Updated Successfully');
    }else{
        redirect('category-edit.php?id='.$categoryid ,'Something Went Wrong!!');
    }

}


// insert product

if(isset($_POST['saveProduct']))
{
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
   
    $status = isset($_POST['status']) == true ? 1:0;

    if($_FILES['image']['size'] > 0)
    {
        $path = "../assets/upload/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $filname = time().'.'.$image_ext;
        move_uploaded_file($_FILES['image']['tem_name'], $path."/".$filname);

        $finalImage = "assets/upload/products/".$filname;

    }else{
        $finalImage = "";
    }

    $data = [
        'category_id' =>  $category_id,
        'name' =>  $name,
        'description' => $description,
        'price' =>  $price,
        'quantity' =>  $quantity,
        'image' =>  $finalImage,
        'status' => $status,	
    ];

    $result = insert('product',$data);

    if($result){
        redirect('product.php','Product Created Successfully');
    }else{
        redirect('product-create.php','Something Went Wrong!!');
    }
 }
 
 // update product with functon
/*
 if(isset($_POST['']))
 {
    $product_id = validate($_POST['product_id']);

    $proudctData = getById('product',$product_id);
    if(!$proudctData)
    {
        redirect('product.php','No such product found');
    }

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
   
    $status = isset($_POST['status']) == true ? 1:0;

    if($_FILES['image']['size'] > 0)
    {
        $path = "../assets/upload/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $filname = time().'.'.$image_ext;
        move_uploaded_file($_FILES['image']['tem_name'], $path."/".$filname);

        $finalImage = "assets/upload/products/".$filname;

        $deleteImage = "../".$proudctData['data']['image'];
        if(file_exists($deleteImage))
        {
            unlink($deleteImage);
        }

    }else{
        $finalImage = $proudctData['data']['image'];
    }

    $data = [
        'category_id' =>  $category_id,
        'name' =>  $name,
        'description' => $description,
        'price' =>  $price,
        'quantity' =>  $quantity,
        'image' =>  $finalImage,
        'status' => $status,	
    ];

    $result = update('product', $product_id, $data);

    if($result){
        redirect('product-edit.php?id='.$product_id ,'Product Updated Successfully');
    }else{
        redirect('product-edit.php?id='.$product_id ,'Something Went Wrong!!');
    }
 }

*/

// update product

 if(isset($_POST['Product']))
 {
    $product_id = mysqli_real_escape_string($conn, $_POST['pId']); 
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

     
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1:0;

    if($_FILES['image']['size'] > 0)
    {
        $path = "../assets/upload/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $filname = time().'.'.$image_ext;
        move_uploaded_file($_FILES['image']['tem_name'], $path."/".$filname);

        $finalImage = "assets/upload/products/".$filname;

        $deleteImage = "../".$proudctData['data']['image'];
        if(file_exists($deleteImage))
        {
            unlink($deleteImage);
        }

    }

    $query = "UPDATE product SET category_id='$category_id', name='$name', description='$description', price='$price', quantity='$quantity', Image='$finalImage', status='$status' WHERE id='$product_id'";

    $result = mysqli_query($conn, $query);
    
    if($result){
        redirect('product-edit.php?id='.$product_id ,'Product Updated Successfully');
    }else{
        redirect('product-edit.php?id='.$product_id ,'Something Went Wrong!!');
    }

}

// insert customer

if(isset($_POST['saveCustomer']))
{
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
   
    $status = isset($_POST['status']) ? 1:0;

    if($name != '')
    {
        $emailcheck = mysqli_query($conn, "SELECT * FROM customer WHERE email='$email' ");
        if($emailcheck){
            if(mysqli_num_rows($emailcheck)>0){
                redirect('customer.php','Email Already Exit');
            }
        }

        $data = [
            'name' =>  $name,
            'email' =>  $email,
            'phone' =>  $phone,
            'status' => $status,	
        ];

        $result = insert('customer', $data);

        if($result){
            redirect('customer.php','Customer Created Successfully');
        }else{
            redirect('customer.php','Something Went Wrong!!');
        }

    }
    else
    {
        redirect('customer.php?','Please fill required fields !!');
    }

}

// update customer

if(isset($_POST['updateCustomer']))
{
    $customerId = validate($_POST['customerId']);

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
   
    $status = isset($_POST['status']) ? 1:0;

    if($name != '' && $email != '')
    {
        $emailcheck = mysqli_query($conn, "SELECT * FROM customer WHERE email='$email' AND id!=' $customerId' ");
        if($emailcheck){
            if(mysqli_num_rows($emailcheck)>0){
                redirect('customer-edit.php?id='.$customerId ,'Email Already Exit');
            }
        }

        $query = "UPDATE customer SET name='$name', email='$email', phone='$phone', status='$status' WHERE id='$customerId'";

        $result = mysqli_query($conn, $query);

        if($result){
            redirect('customer-edit.php?id='.$customerId,'Customer Updated Successfully');
        }else{
            redirect('customer-edit.php?id='.$customerId,'Something Went Wrong!!');
        }

    }
    else
    {
        redirect('customer-edit.php?id='.$customerId,'Please fill required fields !!');
    }

}

