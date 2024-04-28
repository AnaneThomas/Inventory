<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-ms">
        <div class="card-header">
            <h4 class="mb-0">print Order
            <a href="order.php" class="btn btn-danger btn-sm float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <div id="myBillingArea">
                <?php

                    if(isset($_GET['track']))
                    {
                        $trackingNo = validate($_GET['track']);
                        if($trackingNo  == ''){
                            ?>
                            <div class="text-center py-5">
                                <h5>Please Provide Tracking Number</h5>
                                <a href="order.php" class="btn btn-primary mt-4 w-25">Back to Orders</a>
                            </div>
                            <?php
                            return false;
                        }

                        $orderQuery = "SELECT o.*, c.* FROM orders o, customer c WHERE c.id=o.customer_id AND tracking_no='$trackingNo' LIMIT 1";
                        $orderQueryRes = mysqli_query($conn, $orderQuery);
                        if($orderQueryRes){
                            if(mysqli_num_rows($orderQueryRes)>0)
                            {
                                $orderRow = mysqli_fetch_assoc($orderQueryRes);
                            
                                ?>

                                        <table style="width: 100%; margin-bottom: 20px ">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center;" colspan="2">
                                                    <h4 style="font-size: 23px; line-height: 30px; margin:2px, padding:0;">ROCKY'S MOTTOS</h4>
                                                    <p style="font-size: 16px; line-height: 10px; margin:2px, padding:0;">#555, 1st street, 3rd cross, Banda-Ghana</p>
                                                    <p style="font-size: 16px; line-height: 10px; margin:2px, padding:0;">Rocky Mottos Limited.</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                    <h5 style="font-size: 20px; line-height: 30px; margin:0, padding:0;">Customer Details</h5>
                                                    <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Customer Name: <?= $orderRow['name']?></p>
                                                    <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Customer Phone: <?= $orderRow['phone']?></p>
                                                    <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Customer Email: <?= $orderRow['email']?></p>
                                                    </td>

                                                    <td align="end">                               
                                                    <h5 style="font-size: 20px; line-height: 30px; margin:0, padding:0;">Invoice Details</h5>
                                                    <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Invoice No.: <?=  $orderRow['invoice_no']; ?></p>
                                                    <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Invoice Date: <?= date('d M Y') ?></p>
                                                    <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Address: 1st main road, Banda-Ghana</p>
                                                    </td>

                                                </tr>
                                            </tbody>

                                        </table>

                                <?php

                            }
                            else{
                            echo '<h5>No Data Found</h5>';
                            return false;
                            }
                        }else{
                            echo '<h5>Something went wrong</h5>';
                            return false;
                        }

                        

                        $orderItemQuery = "SELECT o.total_amount as totalAmount, o.amountPaid as amountPaid, oi.price as orderItemPrice, oi.quantity as orderItemQuantity, o.*, oi.*, p.* 
                        FROM orders as o, order_items as oi, product as p 
                        WHERE oi.order_id=o.id AND p.id = oi.product_id AND o.tracking_no='$trackingNo'";
                        $orderItemQueryRes = mysqli_query($conn, $orderItemQuery);

                        if($orderItemQueryRes)
                        {
                            if(mysqli_num_rows($orderItemQueryRes)>0)
                            {
                                ?>

                                <div class="table-responsive mb-3">
                                    <table style="width: 100%;" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;">Product Name</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Price</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Quantity</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Total Price</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php

                                        $i = 1;
                                        
                                        foreach($orderItemQueryRes as $key => $row) :
                                            $totalAmount = $row['totalAmount'];
                                            $amountPaid = $row['amountPaid'];

                                           // $equal = $totalAmount == $amountPaid;
                                            $lessThan = $totalAmount - $amountPaid;
                                            $greaterThan = $amountPaid - $totalAmount;
                    
                                        ?>
                                        <tr>
                                            <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                            <td style="border-bottom: 1px solid #ccc;"><?= $row['name'] ?></td>
                                            <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['orderItemPrice'],0) ?></td>
                                            <td style="border-bottom: 1px solid #ccc;"><?= $row['orderItemQuantity']?></td>
                                            <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                            <?= number_format($row['orderItemPrice'] * $row['orderItemQuantity'],0); ?>.00
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>

                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;"> Grand Total:</td>
                                            <td colspan="1" style="font-weight: bold;"><?= number_format($row['total_amount'], 0); ?>.00</td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;"> Payment:</td>
                                            <td colspan="1" style="font-weight: bold;"><?= number_format($amountPaid, 0); ?>.00</td>
                                        </tr>

                                        <tr>
                                    <?php
                                    
                                       if($totalAmount > $amountPaid){
                                        ?> 
                                        <td colspan="4" align="end" style="font-weight: bold;">Balance:</td>
                                        <td colspan="1" style="font-weight: bold;">-<?= number_format($totalAmount - $amountPaid,0); ?>.00</td>  
                                        <?php
                                       }elseif($totalAmount < $amountPaid){
                                        ?> 
                                        <td colspan="4" align="end" style="font-weight: bold;">Balance:</td>
                                        <td colspan="1" style="font-weight: bold;">+<?= number_format($amountPaid - $totalAmount,0); ?>.00</td> 
                                        <?php 
                                       }else{
                                        ?> 
                                        <td colspan="4" align="end" style="font-weight: bold;">Balance:</td>
                                        <td colspan="1" style="font-weight: bold;"><?= number_format("0.00",0); ?>.00</td> 
                                        <?php                                
                                       }

                                    ?>
                                    
                                </tr>

                                        <tr>
                                            <td colspan="5">Payment Mode: <?= $row['payment_mode'];?></td>
                                        </tr>

                                    </tbody>
                                    </table>
                                </div>

                                <?php

                            }else{
                                echo '<h5>No Data Found</h5>';
                            return false;
                            }

                        }else{
                            echo '<h5>Something went wrong</h5>';
                            return false;
                        }


                    }else{
                        ?>
                        <div class="text-center py-5">
                            <h5>No Tracking Number Found</h5>
                            <a href="order.php" class="btn btn-primary mt-4 w-25">Back to Orders</a>
                        </div>
                        <?php
                    }

                ?>
            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-info px-3 mx-1" onclick="printMyBillingArea()">Print</button>
                <button class="btn btn-primary px-3 mx-1" onclick="downnloadPDF('<?=  $orderRow['invoice_no']; ?>')">Downolad PDF</button>
            </div>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
