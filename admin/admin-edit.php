<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-ms">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin
                <a href="admin.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
        <?php alertMessage(); ?>

            <form action="code.php" method="POST">

            <?php
                    if(isset($_GET['id']))
                    {
                        $admin_id = mysqli_real_escape_string($conn, $_GET['id']);
                        $query = "SELECT * FROM admin WHERE id='$admin_id' ";
                        $query_run = mysqli_query($conn, $query);


                        if(mysqli_num_rows($query_run)> 0 ){
                            $admin = mysqli_fetch_array($query_run);
                            ?>
                        
                            <input type="hidden" name="admin_id" value="<?= $admin['id']; ?>">

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="">Name *</label>
                                    <input type="text" name="name" value="<?= $admin['name']; ?>" required class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">Email*</label>
                                    <input type="email" name="email" value="<?= $admin['email']; ?>" required class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">Password *</label>
                                    <input type="text" name="password" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">Phone Number *</label>
                                    <input type="text" name="phone" value="<?= $admin['phone']; ?>" required class="form-control">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="">Is Ban *</label>
                                    <input type="checkbox" name="is_ban" <?= $admin['is_ban'] == true ? 'checked':''; ?> style="width:30px;hight:30px">
                                </div>

                                <div class="col-md-3 mb-3 text-end">
                                    <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                                </div>
                            </div>

                        <?php

                    }else{
                        echo '<h5>uegiugeuyfg</h5>';
                        return false;
                    }

                }else{
                    echo '<h5>Something went wrong</h5>';
                    return false;
                }

            ?>

            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>