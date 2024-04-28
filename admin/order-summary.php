<?php
 include('includes/header.php');

 if(!isset($_SESSION['productItems'])){
    echo '<script> window.location.href = "order-create.php"; </script>';
 }
  ?>

<div class="modal fade" id="oderSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">

            <div class="mb-3 p-4">
                <h5 id="orderPlaceSuccessMessage"></h5>
            </div>
                   
            <div class="modal-footer">
                <a href="order.php" class="btn btn-secondary">Close</a>
                <button type="button" class="btn btn-success" onclick="printMyBillingArea()">Print</button>
                <button type="button" class="btn btn-warning " onclick="downnloadPDF('<?=  $_SESSION['invoice_no']; ?>')">Download PDF</button>
            </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="mb-0">Order Summary
                        <a href="order-create.php" class="btn btn-danger float-end">Back to Create Order</a>
                    </h4>
                </div>
                <div class="card-body">
                <?php alertMessage(); ?>


                <div id="myBillArea">
                    <?php
                    if(isset($_SESSION['cphone'])){
                        $phone = validate($_SESSION['cphone']);
                        $invoiceNo = validate($_SESSION['invoice_no']);
                        $orderBy = validate($_SESSION['loggedInUser']['name']);

                        $customerQuery = mysqli_query($conn, "SELECT c.* , o.* FROM customer as c, orders as o WHERE phone='$phone' LIMIT 1");
                        if($customerQuery)
                        {
                            if(mysqli_num_rows($customerQuery)>0){
                                $customerRowData = mysqli_fetch_assoc($customerQuery);
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
                                               <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Customer Name: <?= $customerRowData['name']?></p>
                                               <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Customer Phone: <?= $customerRowData['phone']?></p>
                                               <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Customer Email: <?= $customerRowData['email']?></p>
                                            </td>

                                            <td align="end">                               
                                               <h5 style="font-size: 20px; line-height: 30px; margin:0, padding:0;">Invoice Details</h5>
                                               <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Invoice No.: <?=  $invoiceNo; ?></p>
                                               <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Invoice Date: <?= date('d M Y') ?></p>
                                               <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Order Place By: <?= $orderBy;?></p>
                                               <p style="font-size: 14px; line-height: 10px; margin:0px, padding:0;">Address: 1st main road, Banda-Ghana</p>
                                            </td>

                                        </tr>
                                    </tbody>

                                </table>

                                <?php

                            }else{
                                echo '<h5>No Customer Found</h5>';
                            }
                        }
                    }

                    ?>

                    <?php

                       if(isset($_SESSION['productItems'])){

                        $sessionProduct = $_SESSION['productItems'];
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
                                $amountPaid = validate($_SESSION['amountPaid']);
                               


                                

                                $i = 1;
                                $totalAmount = 0;
                                $totalQuantity = 0;
                                foreach($sessionProduct as $key => $row) :
                                    $totalAmount += $row['price'] * $row['quantity'];
                                    $totalQuantity += $row['quantity'];

                                    $equal = $totalAmount == $amountPaid;
                                    $lessThan = $totalAmount - $amountPaid;
                                    $greaterThan = $amountPaid - $totalAmount;

                                ?>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                    <td style="border-bottom: 1px solid #ccc;"><?= $row['name'] ?></td>
                                    <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['price'],0) ?></td>
                                    <td style="border-bottom: 1px solid #ccc;"><?= $row['quantity']?></td>
                                    <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                    <?= number_format($row['price'] * $row['quantity'],0); ?>.00
                                    </td>
                                </tr>
                                <?php endforeach; ?>

                                <tr>
                                    <td colspan="4" align="end" style="font-weight: bold;"> Grand Total:</td>
                                    <td colspan="1" style="font-weight: bold;"><?= number_format($totalAmount, 0); ?>.00</td>
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
                                    <td colspan="5">Total Quantity: <?= $totalQuantity;?></td>
                                </tr>
                                
                                <tr>
                                    <td colspan="5">Payment Mode: <?= $_SESSION['payment_mode'];?></td>
                                </tr>

                            </tbody>
                            </table>
                        </div>

                        <?php

                       }else{
                        echo '<h5>No Item Added</h5>';
                       }

                    ?>


                </div>

                <?php if(isset($_SESSION['productItems'])) : ?>
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-primary px-4 mx-1" id="saveOrder">Save</button>
                        <button type="button" class="btn btn-success" onclick="printMyBillingArea()">Print</button>
                        <button type="button" class="btn btn-warning " onclick="downnloadPDF('<?=  $_SESSION['invoice_no']; ?>')">Download PDF</button>
                    </div>
                <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>