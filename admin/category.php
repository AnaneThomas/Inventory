<?php include('includes/header.php'); ?>
    
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-ms">
        <div class="card-header">
            <h4 class="mb-0">Categories
                <a href="category-create.php" class="btn btn-primary float-end">Add Category</a>
            </h4>
        </div>
        <div class="card-body">
        <?php alertMessage(); ?>
            <?php $category = getAll('category');
                 if(!$category){
                    echo '<h4>Something went wrong</h4>';
                    return false;
                 }
                 if(mysqli_num_rows($category) > 0)
                //if($category)
                {

                
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- -->

                        <?php foreach($category as $Item) : ?>
                        <tr>
                            <td><?= $Item['id'] ?></td>
                            <td><?= $Item['name'] ?></td>
                            <td><?= $Item['description'] ?></td>
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

                                <a href="category-edit.php?id=<?= $Item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="category-delete.php?id=<?= $Item['id']; ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete')"
                                 >Delete</a>
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