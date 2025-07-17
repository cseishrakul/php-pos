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
            <h5 class="mb-0">Update Category / Products</h5>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <?php
                if (isset($_GET['id'])) {
                    if ($_GET['id'] != '') {
                        $categoryId = $_GET['id'];
                    } else {
                        echo '<h5> No Id Found! </h5>';
                        return false;
                    }
                } else {
                    echo '<h5> No Id Given in params! </h5>';
                    return false;
                }

                $categoryData = getById('categories', $categoryId);
                if ($categoryData) {
                    if ($categoryData['status'] == 200) {
                ?>
                        <input type="hidden" name="categoryId" value="<?= $categoryData['data']['id'] ?>">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label"> Name </label>
                                <input type="text" name="category_name" required class="form-control" placeholder="Enter your name" value="<?= $categoryData['data']['name'] ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" class="form=control" rows="3" cols="30"> <?= $categoryData['data']['description'] ?> </textarea>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-center">
                                <div class="form-check mt-4">
                                    <label for="is_ban" class="form-check-label ms-2"> Status </label>
                                    <input type="checkbox" name="status" class="form-check-input" <?php if ($categoryData['data']['status']) echo 'checked'; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary w-100" name="updateCategory">Update Category</button>
                            </div>
                        </div>
                <?php
                    } else {
                        echo '<h5>' . $categoryData['message'] . '</h5>';
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