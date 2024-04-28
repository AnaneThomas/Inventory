<?php
    $page = substr($_SERVER['SCRIPT_NAME'], strripos($_SERVER['SCRIPT_NAME'], "/")+1);
?>


<div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link <?= $page == 'index.php' ? 'active':''; ?>" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <a class="nav-link <?= $page == 'order-create.php' ? 'active':''; ?>" href="order-create.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                            Create Order
                        </a>

                        <a class="nav-link <?= $page == 'order.php' ? 'active':''; ?>" href="order.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                            Orders
                        </a>

                        <div class="sb-sidenav-menu-heading">Interface</div>

                        <a class="nav-link 
                        <?= ($page == 'category-create.php') || ($page == 'category.php') ? 'collapse active':'collapsed'; ?>" href="#" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapsecategory" aria-expanded="false" aria-controls="collapsecategory">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Categories
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse 

                        <?= $page == 'category-create.php' ? 'show':''; ?>
                        <?= $page == 'category.php' ? 'show':''; ?>

                        " id="collapsecategory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link <?= $page == 'category-create.php' ? 'active':''; ?>" href="category-create.php">Create Category</a>
                                <a class="nav-link <?= $page == 'category.php' ? 'active':''; ?>" href="category.php">View Category</a>
                            </nav>
                        </div>

   
                        <a class="nav-link 
                        <?= ($page == 'product-create.php') || ($page == 'product.php')? 'collapse active':'collapsed'; ?>" href="#" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapseProduct" aria-expanded="false" aria-controls="collapseProduct">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Products
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse 

                        <?= $page == 'product-create.php' ? 'show':''; ?>
                        <?= $page == 'product.php' ? 'show':''; ?>

                        " id="collapseProduct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link <?= $page == 'product-create.php' ? 'active':''; ?>" href="product-create.php">Create Products</a>
                                <a class="nav-link <?= $page == 'product.php' ? 'active':''; ?>" href="product.php">View Products</a>
                            </nav>
                        </div>
                        

                        <div class="sb-sidenav-menu-heading">Manage Users</div>

                        <a class="nav-link 
                        <?= ($page == 'customer-create.php') || ($page == 'customer.php') ? 'collapse active':'collapsed'; ?> " href="#" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapseCustomer"
                        aria-expanded="false" aria-controls="collapseCustomer">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Customer
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse 

                        <?= $page == 'customer-create.php' ? 'show':''; ?>
                        <?= $page == 'customer.php' ? 'show':''; ?>

                        " id="collapseCustomer" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link <?= $page == 'customer-create.php' ? 'active':''; ?>" href="customer-create.php">Add Customer</a>
                                <a class="nav-link <?= $page == 'customer.php' ? 'active':''; ?>" href="customer.php">View Customer</a>
                            </nav>
                        </div>

                        <a class="nav-link
                        <?= ($page == 'admin-create.php') || ($page == 'admin.php') ? 'collapse active':'collapsed'; ?>" href="#" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapseAdmin"
                        aria-expanded="false" aria-controls="collapseAdmin">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Admin/Staff
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse
                        
                        <?= $page == 'admin-create.php' ? 'show':''; ?>
                        <?= $page == 'admin.php' ? 'show':''; ?>

                        " id="collapseAdmin" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link <?= $page == 'admin-create.php' ? 'active':''; ?>" href="admin-create.php">Add Admin</a>
                                <a class="nav-link <?= $page == 'admin.php' ? 'active':''; ?>" href="admin.php">View Admin</a>
                            </nav>
                        </div>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Administrator
                </div>
            </nav>
        </div>