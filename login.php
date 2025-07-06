<?php include('includes/header.php');
if (isset($_SESSION['loggedIn'])) {
?>
    <script>
        window.location.href = 'index.php'
    </script>
<?php
}
?>
<div class="container">
    <div class="py-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card shadow-sm rounded-4">
                    <div class="p-5">
                        <h4 class="text-dark mb-3">Sign into your pos system</h4>
                        <?php alertMessage(); ?>
                        <form action="login-code.php" method="POST">
                            <div class="mb-3">
                                <label for="">Email Address</label>
                                <input type="email" name="email" class="form-control" required id="" placeholder="example@email.com">
                            </div>
                            <div class="mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" required id="" placeholder="*********">
                            </div>
                            <button type="submit" name="loginBtn" class="btn btn-primary w-100 mt-2">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php')  ?>