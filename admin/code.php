<?php
include('../config/functions.php');

if (isset($_POST['saveAdmin'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if ($name != '' && $email != '' && $password != '') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('admin-create.php', 'Email already taken!');
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];

        $result = insert('admins', $data);

        if ($result) {
            redirect('admins.php', 'Admin created successfully!');
        } else {

            redirect('admin-create.php', 'Admin create unsuccessfully!');
        }
    } else {
        redirect('admin-create.php', 'Please fill required fields!');
    }
}


if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins', $adminId);
    if ($adminData['status'] != 200) {
        redirect('admin-edit.php?id=' . $adminId, 'Please fill up the requirements!');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']);

    $emailCheckQuery = "SELECT * FROM admins WHERE email='$email' AND id !='$adminId'";

    $checkResult = mysqli_query($conn, $emailCheckQuery);
    if ($checkResult) {
        if (mysqli_num_rows($checkResult) > 0) {
            redirect('admin-edit.php?id=' . $adminId, 'Email already used by another user!');
        }
    }


    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    if ($name != '' && $email != '') {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = update('admins', $adminId, $data);
        if ($result) {
            redirect('admin-edit.php?id=' . $adminId, 'Admin updated sucessfully!');
        } else {
            redirect('admin-edit.php?id=' . $adminId, 'Something went wrong!');
        }
    } else {
        redirect('admin-edit.php?id=' . $adminId, 'Please fill required fields!');
    }
}


if (isset($_POST['saveCategory'])) {
    $name = validate($_POST['category_name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    $result = insert('categories', $data);

    if ($result) {
        redirect('categories.php', 'Category added successfully!');
    } else {
        redirect('categorie-create.php', 'Something went wrong!');
    }
}

if (isset($_POST['updateCategory'])) {
    $categoryId = validate($_POST['categoryId']);
    $name = validate($_POST['category_name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    $result = update('categories', $categoryId, $data);

    if ($result) {
        redirect('categories.php', 'Category updated successfully!');
    } else {
        redirect('categorie-edit.php', 'Something went wrong!');
    }
}



if (isset($_POST['saveProduct'])) {
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $image = validate($_POST['image']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = time() . '.' . $image_ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $fileName);
        $finalImage = "assets/uploads/products/" . $fileName;
    } else {
        $finalImage = '';
    }
    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $fileName,
        'status' => $status
    ];

    $result = insert('products', $data);

    if ($result) {
        redirect('products.php', 'Product created successfully!');
    } else {
        redirect('product-create.php', 'Something went wrong!');
    }
}



if(isset($_POST['updateProduct'])){
    $product_id = validate($_POST['productId']);
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1 : 0;
    $productData = getById('products',$product_id);
    if(!$productData || $productData['status'] != 200){
        redirect('products.php','Product not found!');
    }

    $existeing = $productData['data'];

    $fileName = $existeing['image'];
    if(isset($_FILES['image']) && $_FILES['image']['size']>0){
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = time() . '.' . $image_ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $fileName);
        $oldImagePath = $path ."/".$existeing['image'];
        if(file_exists($oldImagePath)){
            unlink($oldImagePath);
        }
    }

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $fileName,
        'status' => $status
    ];

    $result = update('products', $product_id, $data);

    if ($result) {
        redirect('products.php', 'Product updated successfully!');
    } else {
        redirect('product-edit.php', 'Something went wrong!');
    }
}



if(isset($_POST['saveCustomer'])){
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1 : 0;

    $errors = [];
    if(empty($name)){
        $errors[] = "Name is required";
    }
    if(empty($email)){
        $errors[] = "Email is required";
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors= "Invalid email format";
    }

    if(empty($phone)){
        $errors = "Phone number is required";
    }

    $checkEmail = mysqli_query($conn,"SELECT * FROM customers WHERE email = '$email'");

    if(mysqli_num_rows($checkEmail) > 0){
        $errors[] = "Email already exists";
    }

    if(!empty($errors)){
        $errorMessage  = implode('<br>',$errors);
        redirect('customer-create.php',$errorMessage);
    }

    $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'status' => $status,
        'created_at' => date('Y-m-d H:i:s'),
    ];

    $result = insert('customers',$data);

    if($result){
        redirect('customers.php','Customer added succesfully!');
    }else{
        redirect('customer-create.php','Customer failed to add!');
    }

}

if (isset($_POST['updateCustomer'])) {
    $customerId = validate($_POST['customer_id']);
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'status' => $status
    ];

    $result = update('customers', $customerId, $data);

    if ($result) {
        redirect('customers.php', 'Customer updated successfully!');
    } else {
        redirect('customer-edit.php', 'Something went wrong!');
    }
}


