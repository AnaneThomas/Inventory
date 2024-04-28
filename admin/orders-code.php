<?php

require '../config/function.php' ;

if(!isset($_SESSION['productItems'])){
    $_SESSION['productItems'] = [];
}
if(!isset($_SESSION['productItemI'])){
    $_SESSION['productItemI'] = [];
}

if(isset($_POST['addItem']))
{
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM product WHERE id='$productId' LIMIT 1 "); 

    if($checkProduct){
            if(mysqli_num_rows($checkProduct)>0)
            {
                $row = mysqli_fetch_assoc($checkProduct);
                if($row['quantity'] < $quantity){
                    redirect('order-create.php','Only ' .$row['quantity']. ' quantity available');
                }

                $productDate = [
                    'product_id' => $row['id'],
                    'name' => $row['name'],
                    'image' => $row['image'],
                    'price' => $row['price'],
                    'quantity' => $quantity
                ];

                if(!in_array($row['id'], $_SESSION['productItemI'])){

                array_push($_SESSION['productItemI'],$row['id']);
                array_push($_SESSION['productItems'],$productDate);

                }else{
                    foreach($_SESSION['productItems'] as $key => $productSessionItem){
                        if($productSessionItem['product_id'] == $row['id']){
                            $newQuantity = $productSessionItem['quantity'] +  $quantity;

                            $productDate = [
                                'product_id' => $row['id'],
                                'name' => $row['name'],
                                'image' => $row['image'],
                                'price' => $row['price'],
                                'quantity' => $newQuantity
                            ];
                            $_SESSION['productItems'][$key] = $productDate;

                        }
                    } 
                }
                redirect('order-create.php','Item Added');

            }else
            {
                redirect('order-create.php','No product found!!');
            }

    }else{
        redirect('order-create.php','Something went wrong!!');
    }
}


if(isset($_POST['productInDe']))
{
    $productId = validate($_POST['product_Id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;

    foreach($_SESSION['productItems'] as $key => $item){
        if($item['product_id'] ==  $productId){

            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }

    if($flag){
        jsonResponse(200 , 'Success', 'Quantity Updated');
    }else{
       /* $response = [
            'status' => 200,
            'status_type' => 'Success',
            'message' => 'Quantity Updated'
        ];
        echo json_encode($response);
        return;
       */
       jsonResponse(500 , 'error', 'Somthing went wrong');
    }
}

//order details
if(isset($_POST['placeOrder'])){
    $cphone = validate($_POST['cphone']);
    $amountPaid = validate($_POST['amountPaid']);
    $payment_mode = validate($_POST['payment_mode']);

    // check customer
    $checkCustomer = mysqli_query($conn, "SELECT * FROM customer WHERE phone='$cphone' LIMIT 1 ");

    if( $checkCustomer){
        if(mysqli_num_rows( $checkCustomer)>0){
            $_SESSION['invoice_no'] = "INV-".rand(111111,999999);
            $_SESSION['cphone'] = $cphone;
            $_SESSION['amountPaid'] = $amountPaid;
            $_SESSION['payment_mode'] =  $payment_mode;
            jsonResponse(200 , 'Success', 'Customer Found');

        }else{
            $_SESSION['cphone'] = $cphone;
            jsonResponse(404, 'warning', 'Customer Not Found');
        }
    }else{
        jsonResponse(500, 'Error', 'Somthing went wrong');
    }
}

// add customer details

if(isset($_POST['saveCustomerBtn'])){
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);

    if($name != '' && $phone != '')
    {

        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
        ];

        $result = insert('customer', $data);
        if($result)
        {
            jsonResponse(200, 'success', 'Customer Created Successfully'); 
        }else{
            jsonResponse(500, 'error', 'Somthing went wrong');
        }


    }else{
        jsonResponse(422, 'warning', 'Please fill the required fields');
    }

}


// order details
if(isset($_POST['saveOrder']))
{
    $phone = validate($_SESSION['cphone']);
    $invoice_no = validate($_SESSION['invoice_no']);
    $amountPaid = validate($_SESSION['amountPaid']);
    $payment_mode = validate($_SESSION['payment_mode']);
    $order_place_by_id = $_SESSION['loggedInUser']['name'];

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customer WHERE phone='$phone' LIMIT 1 ");
    if(!$checkCustomer){
        jsonResponse(500, 'error', 'Somthing went wrong');
    }

    if(mysqli_num_rows($checkCustomer)>0){
        $customerData = mysqli_fetch_assoc($checkCustomer);

        if(!isset($_SESSION['productItems'])){
            jsonResponse(404, 'warning', 'No Item Orded');
        }

        $sessionProduct = $_SESSION['productItems'];

        $totalAmount = 0;
        foreach($sessionProduct as $amount){
            $totalAmount += $amount['price'] * $amount['quantity'];
        }

        $data = [
            'customer_id' => $customerData['id'],
            'tracking_no' => rand(111111,999999),
            'invoice_no' => $invoice_no,
            'total_amount' => $totalAmount,
            'order_date' => date('Y-m-d'),
            'order_status' => 'booked',
            'payment_mode' => $payment_mode,
            'order_place_by_id' => $order_place_by_id

        ];

        $customerData = $customerData['id'];
        $tracking_no = rand(111111,999999);
        $invoice = $invoice_no;
        $total = $totalAmount;
        $order_date = date('Y-m-d');
        $order_status = 'book';
        $payment = $payment_mode;
        $paid = $amountPaid;
        $order_place = $order_place_by_id;



        // $result = insert('order', $data);
        $query = "INSERT INTO orders (customer_id, tracking_no, invoice_no ,total_amount, order_date, order_status,	payment_mode, amountPaid, order_place_by_id)
        VALUES ('$customerData', '$tracking_no', '$invoice', '$total', '$order_date', '$order_status', '$payment', '$paid', '$order_place')";
        $result = mysqli_query($conn, $query);
        $lastOrderId = mysqli_insert_id($conn);

        foreach($sessionProduct as $productItem){
            $productId = $productItem['product_id'];
            $price = $productItem['price'];
            $quantity = $productItem['quantity'];

            // insert order item
            $dataOrderItem = [
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity, 
            ];

            $result = insert('order_items', $dataOrderItem);

            // checking for the books quantity and decreasing quantity and making total quantity
            $checkProductQuantity = mysqli_query($conn, "SELECT * FROM product WHERE id='$productId' LIMIT 1 ");
            $checkProductData = mysqli_fetch_assoc($checkProductQuantity);
            $totalProductProductQuantity = $checkProductData['quantity'] - $quantity;
           

           // $updateProduct = [
           //     'quantity' => $totalProductProductQuantit
           // ];

           // $updateProductQty = Update('product',$productId,$updateProduct);
            $updateProductQty = "UPDATE product SET quantity='$totalProductProductQuantity' WHERE id='$productId'";
            $result = mysqli_query($conn, $updateProductQty);


        }

        unset($_SESSION['productItems']);
        unset($_SESSION['productItemI']);
        unset($_SESSION['cphone']);
        unset($_SESSION['payment_mode']);
        unset($_SESSION['invoice_no']);

        jsonResponse(200, 'success', 'Order place Successfully');

    }else{
        jsonResponse(404, 'warning', 'No customer Found');
    }

}

