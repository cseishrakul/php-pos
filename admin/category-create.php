<?php session_start(); ?>

<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Category / Products</li>
        <a href="categories.php" class="btn btn-primary ms-auto">Back</a>
    </ol>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add New Category</h5>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label"> Name </label>
                        <input type="text" name="category_name" required class="form-control" placeholder="Enter name">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" class="form=control" rows="3" cols="30"></textarea>
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <label for="is_ban" class="form-check-label ms-2"> Status </label>
                            <input type="checkbox" name="status" class="form-check-input" id="is_ban">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary w-100" name="saveCategory">Save Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<?php include('includes/footer.php'); ?>