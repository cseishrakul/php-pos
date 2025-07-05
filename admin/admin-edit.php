<?php session_start(); ?>

<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Admins / Staff</li>
        <a href="admins.php" class="btn btn-primary ms-auto">Back</a>
    </ol>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Update Admin / Staff</h5>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <?php
                if (isset($_GET['id'])) {
                    if ($_GET['id'] != '') {
                        $adminId = $_GET['id'];
                    } else {
                        echo '<h5> No Id Found! </h5>';
                        return false;
                    }
                } else {
                    echo '<h5> No Id Given in params! </h5>';
                    return false;
                }

                $adminData = getById('admins', $adminId);
                if ($adminData) {
                    if ($adminData['status'] == 200) {
                ?>
                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id'] ?>">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label"> Name </label>
                                <input type="text" name="name" required class="form-control" placeholder="Enter your name" value="<?= $adminData['data']['name'] ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label"> Email </label>
                                <input type="email" name="email" required class="form-control" placeholder="example@email.com" value="<?= $adminData['data']['email'] ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label"> Password </label>
                                <input type="password" name="password" required class="form-control" placeholder="********">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label"> Phone Number </label>
                                <input type="text" name="phone" required class="form-control" placeholder="+8801XXXXXXX" value="<?= $adminData['data']['phone'] ?>">
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-center">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="is_ban" class="form-check-input" id="is_ban" <?= $adminData['data']['is_ban'] == true ? 'checked' : '' ?>>
                                    <label for="is_ban" class="form-check-label ms-2"> Is Banned? </label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary w-100" name="updateAdmin">Update Admin</button>
                            </div>
                        </div>
                <?php
                    } else {
                        echo '<h5>' . $adminData['message'] . '</h5>';
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