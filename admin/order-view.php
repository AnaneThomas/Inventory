<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-ms">
        <div class="card-header">
            <h4 class="mb-0">View Order
            <a href="order-view-print.php?track=<?= $_GET['track']; ?>" class="btn btn-primary btn-sm float-end">Print</a>
            <a href="order.php" class="btn btn-danger btn-sm float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php

            if(isset($_GET['track']))
            {
                if($_GET['track'] == ''){
                    ?>
                    <div class="text-center py-5">
                        <h5>No Tracking Number Found</h5>
                        <a href="order.php" class="btn btn-primary mt-4 w-25">Back to Orders</a>
                    </div>
                    <?php
                    return false;
                }

                $trackingNo = validate($_GET['track']);
                $query = "SELECT o.*, c.* FROM orders o, customer c 
                    WHERE c.id = o.customer_id AND tracking_no='$trackingNo' ORDER BY o.id DESC";

                $orders = mysqli_query($conn, $query);
                if($orders)
                {
                    if(mysqli_num_rows($orders)>0)
                    {
                        $orderData = mysqli_fetch_assoc($orders);
                        $orderId = $orderData['id'];

                        ?>

                        <div class="card card-body shadow border-1 mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Order Details</h4>
                                    <label class="mb-1">
                                        Tracking No.: <span class="fw-bold"><?= $orderData['tracking_no'];?></span>
                                    </label>
                                    <br>

                                    <label class="mb-1">
                                        Order Date: <span class="fw-bold"><?= $orderData['order_date'];?></span>
                                    </label>
                                    <br>

                                    <label class="mb-1">
                                        Order Status: <span class="fw-bold"><?= $orderData['order_status'];?></span>
                                    </label>
                                    <br>

                                    <label class="mb-1">
                                        Payment Mode: <span class="fw-bold"><?= $orderData['payment_mode'];?></span>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <h4>User Details</h4>
                                    <label class="mb-1">
                                        Full Name: <span class="fw-bold"><?= $orderData['name'];?></span>
                                    </label>
                                    <br>

                                    <label class="mb-1">
                                        Phone: <span class="fw-bold"><?= $orderData['phone'];?></span>
                                    </label>
                                    <br>

                                    <label class="mb-1">
                                        Email: <span class="fw-bold"><?= $orderData['email'];?></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <?php

                        $orderItemQuery = "SELECT oi.price as orderItemprice, oi.quantity as orderItemQuantity, o.*, oi.*, p.* 
                        FROM orders as o, order_items as oi, product as p 
                        WHERE oi.order_id = o.id AND p.id = oi.product_id AND o.tracking_no='$trackingNo'";
                        $orderItemRes = mysqli_query($conn, $orderItemQuery);
                        if($orderItemRes)
                        {
                            if(mysqli_num_rows($orderItemRes)>0)
                            {
                                ?>

                                <h4 class="my-3">Order Items Details</h4>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach($orderItemRes as $row) : ?>
                                            <tr>
                                                <td><?= $row['name']; ?></td>
                                                <td width="15%" class="fw-bold text-center"><?= number_format($row['orderItemprice'],0); ?></td>
                                                <td width="15%" class="fw-bold text-center"><?= $row['orderItemQuantity']; ?></td>
                                                <td width="15%" class="fw-bold text-center"><?= number_format($row['orderItemprice'] * $row['orderItemQuantity'],0);?> </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <tr>
                                            <td class="text-end fw-bold">Total Price:</td>
                                            <td colspan="3" class="text-end fw-bold">Rs: <?= number_format($row['total_amount'],0); ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <?php
    
                            }else{
                                echo '<h5>No Record Found</h5>';
                                return false;
                            }

                        }else{
                           echo '<h5>Something went wrong</h5>';
                           return false;
                        }

                        ?>

                        <?php

                    }else{
                        echo '<h5>No Record Found</h5>';
                        return false;
                    }

                }else{
                    echo '<h5>Something went wrong</h5>';
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
    </div>
</div>

<?php include('includes/footer.php'); ?>