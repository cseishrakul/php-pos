<?php session_start(); ?>

<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Order / Products</li>
        <a href="orders.php" class="btn btn-primary ms-auto">Back</a>
    </ol>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-warning">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
    ?>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add New Order</h5>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="order-code.php" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label"> Select Product </label>
                        <select name="product_id" id="" class="form-control">
                            <option value=""> -- Select Product -- </option>

                            <?php
                            $products = getAll('products');
                            if ($products) {
                                if (mysqli_num_rows($products) > 0) {
                                    foreach ($products as $prodItem) {
                            ?>
                                        <option value="<?= $prodItem['id'] ?>"> <?= $prodItem['name'] ?> </option>
                            <?php
                                    }
                                } else {
                                    echo '<h5> No product found! </h5>';
                                }
                            } else {
                                echo '<h5> Something went wrong! </h5>';
                            }

                            ?>

                        </select>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" value="1" class="form-control" id="">
                    </div>

                    <div class="col-md-4 mt-4 pt-2">
                        <button type="submit" class="btn btn-primary w-100" name="saveOrder">Save Order</button>
                    </div>
                </div>
            </form>

            <!-- <?php
                    if (isset($_SESSION['productItems'])) {
                        echo "<pre>";
                        print_r($_SESSION['productItems']);
                        echo "</pre>";
                    } else {
                        echo "No items added yet.";
                    }
                    ?> -->


        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4 class="my-3">Products</h4>
        </div>
        <div class="card-body">
            <?php
            if (isset($_SESSION['productItems'])) {
                $sessionProducts = $_SESSION['productItems'];
            ?>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($sessionProducts as $key => $item) :
                            ?>

                                <tr>
                                    <td> <?= $i++; ?> </td>
                                    <td> <?= $item['name'] ?> </td>
                                    <td> <?= $item['price'] ?> </td>
                                    <td>
                                        <form action="order-code.php" method="POST" class="input-group qtyBox" style="width: 150px;">
                                            <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                            <button class="input-group-text" type="submit" name="decrement">-</button>
                                            <input type="text" name="quantity" value="<?= $item['quantity'] ?>" class="form-control text-center w-50" id="">
                                            <button class="input-group-text" type="submit" name="increment">+</button>
                                        </form>
                                    </td>
                                    <td>
                                        <?= number_format($item['price'] * $item['quantity'], 0) ?> &#2547;
                                    </td>
                                    <td>
                                        <a href="order-item-delete.php?index=<?= $key; ?>" class="btn btn-danger">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
                echo '<h5> No Item Added! </h5>';
            }
            ?>
        </div>
    </div>

    <div class="card mt-4">
        <form action="order-code.php" method="POST">
            <div class="mt-2 p-2">
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Select Payment Method</label>
                        <select name="payment_mode" id="" class="form-select">
                            <option value=""> -- Select Payment -- </option>
                            <option value="Cash Payment"> Cash Payment </option>
                            <option value="Online Payment"> Online Payment </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="">Customer Phone Number</label>
                        <input type="number" name="cphone" class="form-control" id="" placeholder="Enter Customer Number">
                    </div>
                    <div class="col-md-4">
                        <br>
                        <button class="btn btn-primary w-100" type="submit" name="proceedToPlace">Proceed to place order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php
    if (isset($_SESSION['show_add_customer_modal']) && $_SESSION['show_add_customer_modal'] == true):
    ?>
        <div class="card my-4 p-3">
            <form action="order-code.php" method="POST">
                <h5>Add new customer</h5>
                <div class="mb-2">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="">Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= $_SESSION['new_customer_phone'] ?>" readonly>
                </div>
                <button type="submit" name="saveCustomer" class="btn btn-primary">Save Customer</button>
            </form>
        </div>

    <?php
        unset($_SESSION['show_add_customer_modal']);
    endif
    ?>

</div>

<?php include('includes/footer.php'); ?>