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
            <h5 class="mb-0">Update Product / Products</h5>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">

                <?php
                if (isset($_GET['id'])) {
                    if ($_GET['id'] != '') {
                        $productId = $_GET['id'];
                    } else {
                        echo '<h5> No Id Found! </h5>';
                        return false;
                    }
                } else {
                    echo '<h5> No Id Given in params! </h5>';
                    return false;
                }

                $productData = getById('products', $productId);
                if ($productData) {
                    if ($productData['status'] == 200) {
                ?>
                        <input type="hidden" name="productId" value="<?= $productData['data']['id'] ?>">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label fw-semibold">Select Category</label>
                                <select name="category_id" class="form-select" id="">
                                    <option value="">Select Category</option>
                                    <?php
                                    $categories = getAll('categories');
                                    if ($categories && mysqli_num_rows($categories) > 0) {
                                        foreach ($categories as $categoryItem) {
                                            $selected = ($productData['data']['category_id'] == $categoryItem['id']) ? 'selected' : '';
                                            echo '<option value="' . $categoryItem['id'] . '" ' . $selected . '>' . $categoryItem['name'] . '</option>';
                                        }
                                    } else {
                                        echo '<option>No Category Found!</option>';
                                    }
                                    ?>
                                </select>
                            </div>


                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label"> Name </label>
                                <input type="text" name="name" required class="form-control" placeholder="Enter your name" value="<?= $productData['data']['name'] ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" class="form=control" rows="3" cols="30"> <?= $productData['data']['description'] ?> </textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Price</label>
                                <input type="text" name="price" required class="form-control" placeholder="Enter your name" value="<?= $productData['data']['price'] ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Quantity</label>
                                <input type="text" name="quantity" required class="form-control" placeholder="Enter your name" value="<?= $productData['data']['quantity'] ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control">
                                <?php if (!empty($productData['data']['image'])) : ?>
                                    <img src="../assets/uploads/products/<?= $productData['data']['image']; ?>" alt="Product Image" class="w-50 mt-2">
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3 d-flex align-items-center">
                                <div class="form-check mt-4">
                                    <label for="is_ban" class="form-check-label ms-2"> Status </label>
                                    <input type="checkbox" name="status" class="form-check-input" <?php if ($productData['data']['status']) echo 'checked'; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary w-100" name="updateProduct">Update Product</button>
                            </div>
                        </div>
                <?php
                    } else {
                        echo '<h5>' . $productData['message'] . '</h5>';
                    }
                } else {
                    echo '<h5> Something went wrong! </h5>';
                }
                ?>

            </form>
        </div>
    </div>

</div>

<?php include('includes/footer.php'); ?>