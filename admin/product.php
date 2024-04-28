<?php include('includes/header.php'); ?>
    
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-ms">
        <div class="card-header">
            <h4 class="mb-0">Products
                <a href="product-create.php" class="btn btn-primary float-end">Add Products</a>
            </h4>
        </div>
        <div class="card-body">
        <?php alertMessage(); ?>
            <?php $product = getAll('product');
                 if(!$product){
                    echo '<h4>Something went wrong</h4>';
                    return false;
                 }
                 if(mysqli_num_rows($product) > 0)
                //if($product)
                {

                
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- -->

                        <?php foreach($product as $Item) : ?>
                        <tr>
                            <td><?= $Item['id'] ?></td>
                            <td>
                                <img src="../<?= $Item['image'] ?>" style="width:50px,height:50px" alt="Product Image"/>
                            </td>
                            <td><?= $Item['name'] ?></td>
                            <td>
                                <?php
                                    if($Item['status'] == 1){
                                        echo '<span class="badge bg-danger">Hidden</span>';
                                    }
                                    else{
                                        echo '<span class="badge bg-primary">Visible</span>';
                                    }
                                ?>
                            </td>


                            <td>

                                <a href="product-edit.php?id=<?= $Item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                <a 
                                    href="product-delete.php?id=<?= $Item['id']; ?>" 
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete')"
                                >
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                       <!--   -->




                    </tbody>
                </table>
            </div>

            <?php
            }else{
                ?>
            <!-- <tr>
                    <td colspan="4">No Record Found</td>
                </tr>-->
                <h4 class="mb=0">No Record Found</h4>
                <?php
            }
        ?>


        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>