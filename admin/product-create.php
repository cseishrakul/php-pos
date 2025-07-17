<?php session_start(); ?>

<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Product / Products</li>
        <a href="products.php" class="btn btn-primary ms-auto">Back</a>
    </ol>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add New Product</h5>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label fw-semibold">Select Category</label>
                        <select name="category_id" class="form-select" id="">
                            <option value="">Select Category</option>
                            <?php
                            $categories = getAll('categories');
                            if ($categories && mysqli_num_rows($categories) > 0) {
                                foreach ($categories as $categoryItem) {
                                    echo '<option value="'.$categoryItem['id'].'">' . $categoryItem['name'] . '</option>';
                                }
                            }else{
                                echo '<option>No Category Found!</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label"> Name </label>
                        <input type="text" name="name" required class="form-control" placeholder="Enter name">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" class="form=control" rows="3" cols="30"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Price</label>
                        <input type="text" name="price" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Quantity</label>
                        <input type="text" name="quantity" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Image</label>
                        <input type="file" name="image" required class="form-control">
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <label for="is_ban" class="form-check-label ms-2"> Status </label>
                            <input type="checkbox" name="status" class="form-check-input" id="is_ban">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary w-100" name="saveProduct">Save Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<?php include('includes/footer.php'); ?>