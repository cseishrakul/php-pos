<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-Item active">Category / Products</li>
        <a href="category-create.php" class="btn btn-primary ms-auto">Create Category +</a>
    </ol>

    <div class="card">
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php
            $categories = getAll('categories');
            if (!$categories) {
                echo '<h4> Something went wrong! </h4>';
                return false;
            }
            if (mysqli_num_rows($categories) > 0) {

            ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $Item) : ?>
                                <tr>
                                    <td> <?= $Item['id'] ?> </td>
                                    <td> <?= $Item['name'] ?> </td>
                                    <td>
                                        <?php if ($Item['status'] == 1) {
                                            echo '<span class="badge bg-danger">Hidden</span>';
                                        }else{
                                            echo '<span class="badge bg-primary">Visible</span>';
                                        } ?>
                                    </td>
                                    <td>
                                        <a href="category-edit.php?id=<?= $Item['id'] ?>" class="btn btn-primary">Edit</a>
                                        <a href="category-delete.php?id=<?= $Item['id'] ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
            ?>

                <tr>
                    <td colspan="4"> No record found! </td>
                </tr>
            <?php } ?>

        </div>
    </div>

</div>

<?php include('includes/footer.php'); ?>