<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-ms">
        <div class="card-header">
            <h4 class="mb-0">Edit Product
                <a href="product.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
        <?php alertMessage(); ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">
            <?php
                        if($_GET['id'])
                        {
                            $product_id = mysqli_real_escape_string($conn, $_GET['id']);
                            $query = "SELECT * FROM product WHERE id='$product_id' ";
                            $query_run = mysqli_query($conn, $query);


                            if(mysqli_num_rows($query_run)> 0 ){
                                $product = mysqli_fetch_array($query_run);
                               ?>

                        
                        <input type="hidden" name="pId" value="<?= $product['id'] ?>">

                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label>Select Category *</label>
                                <select name="category_id" class="form-select">
                                    <option value="">Select Category</option>
                                    <?php
                                        $category = getAll('category');
                                        if($category){

                                            if(mysqli_num_rows($category) > 0){
                                                foreach($category as $catItem){
                                                    ?>
                                                        <option value="<?= $catItem['id']; ?>"
                                                        <?= $product['category_id'] == $catItem['id'] ? 'selected':''; ?>
                                                        >
                                                        <?=  $catItem['name']; ?>

                                                        </option>
                                                    <?php
                                                }
                                            }else{
                                                echo '<option value="">No product found</option>';
                                            }


                                        }else{
                                            echo '<option value="">Something went wrong</option>';
                                        }
                                    ?>
                                </select>
                            </div>


                            <div class="col-md-12 mb-3">
                                <label for="">Product name *</label>
                                <input type="text" name="name" value="<?= $product['name']; ?>" required class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="">Description *</label>
                                <textarea name="description" class="form-control" rows="3"><?= $product['description']; ?></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="">Price *</label>
                                <input type="text" name="price" value="<?= $product['price']; ?>" required class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="">Quantity *</label>
                                <input type="text" name="quantity" value="<?= $product['quantity']; ?>" required class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="">Image *</label>
                                <input type="file" name="image"  class="form-control">
                                <img src="../<?= $product['image']; ?>" style="width:40px, height=:40px ;" alt="Image">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Status (Unchecked=Visible, Checked=Hidden)</label>
                                <br>
                                <input type="checkbox" name="status" <?= $product['status'] == true ? 'checked':''; ?> style="width:30px,height:30px">
                            </div>

                            <div class="col-md-6 mb-3 text-end">
                                <br>
                                <button type="submit" name="Product" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    <?php
                  
                        }else
                        {
                            echo '<H5>'.$product['message'].'</H5>';
                        }

                    }else{
                        echo '<H5>Something went wrong</H5>';
                        return false;
                    }

                ?>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>