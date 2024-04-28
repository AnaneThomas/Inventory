<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-ms">
        <div class="card-header">           
            <div class="row">
                <div class="col-md-4">
                <h4 class="mb-0">Orders</h4>
                </div>

                <div class="col-md-8">
                    <form action="" method="GET">
                        <div class="row g-1">
                            <div class="col-md-4" class="form-control">
                                <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date']:'';?>">
                            </div>

                            <div class="col-md-4">
                                
                                <select name="payment_status" class="form-select">
                                    <option value="">Select Payment</option>
                                    <option value="Cash Payment"
                                    <?= isset($_GET['payment_status']) == true ? ($_GET['payment_status'] == 'Cash Payment' ? 'selected':''):''; ?>
                                    >Cash Payment</option>
                                    <option value="Momo Payment"
                                    <?= isset($_GET['payment_status']) == true ? ($_GET['payment_status'] == 'Momo Payment' ? 'selected':''):''; ?>
                                    >Momo Payment</option>
                                    <option value="Bank Payment"
                                    <?= isset($_GET['payment status']) == true ? ($_GET['payment_status'] == 'Bank Payment' ? 'selected':''):''; ?>
                                    >Bank Payment</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="order.php" class="btn btn-danger">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php

            if(isset($_GET['date']) || isset($_GET['payment_status']))
            {
                $orderDate = validate($_GET['date']);
                $orderPaymenet = validate($_GET['payment_status']);

                if($orderDate != '' && $orderPaymenet == '')
                {
                    $query = "SELECT o.*, c.* FROM orders o, customer c WHERE c.id = o.customer_id AND o.order_date='$orderDate' ORDER BY o.id DESC";

                }elseif($orderDate == '' && $orderPaymenet != ''){
                    $query = "SELECT o.*, c.* FROM orders o, customer c WHERE c.id = o.customer_id AND o.payment_mode='$orderPaymenet' ORDER BY o.id DESC";

                }elseif($orderDate != '' && $orderPaymenet != ''){

                    $query = "SELECT o.*, c.* FROM orders o, customer c WHERE c.id = o.customer_id AND o.order_date='$orderDate' AND o.payment_mode='$orderPaymenet' ORDER BY o.id DESC";
                    
                }else{
                    
                    $query = "SELECT o.*, c.* FROM orders o, customer c WHERE c.id = o.customer_id ORDER BY o.id DESC";
                }
            }else{
            $query = "SELECT o.*, c.* FROM orders o, customer c WHERE c.id = o.customer_id ORDER BY o.id DESC";
            }
            $orders = mysqli_query($conn, $query);

            if($orders){
                if(mysqli_num_rows($orders)>0)
                {
                    ?>

                       <table class="table table-striped table-borederd align-items-center justify-content-center">
                        <thead>
                            <tr>
                                <th>Tracking No.</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Mode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($orders as $orderItem) : ?>
                                <tr>
                                    <td class="fw-bold"><?= $orderItem['tracking_no'] ;?></td>
                                    <td><?= $orderItem['name'] ;?></td>
                                    <td><?= $orderItem['phone'] ;?></td>
                                    <td><?= date('d M, Y',strtotime($orderItem['order_date']));?></td>
                                    <td><?= $orderItem['order_status'] ;?></td>
                                    <td><?= $orderItem['payment_mode'] ;?></td>
                                    <td>
                                        <a href="order-view.php?track=<?= $orderItem['tracking_no']?>" class="btn btn-info mb=0 px-2 btn-sm">View</a>
                                        <a href="order-view-print.php?track=<?= $orderItem['tracking_no']?>" class="btn btn-primary mb=0 px-2 btn-sm">Print</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                       </table>

                    <?php

                }else{
                    echo '<h5>No Record Available</h5>';
                    echo 'it is '.$orderPaymenet;
                }
            }else{
                echo '<h5>Something went wrong</h5>';
            }

            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>