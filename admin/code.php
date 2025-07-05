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


if(isset($_POST['updateAdmin'])){
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins',$adminId);
    if($adminData['status'] != 200){
        redirect('admin-edit.php?id='.$adminId,'Please fill up the requirements!');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']);

    if($password != ''){
        $hashedPassword = password_hash($password,PASSWORD_BCRYPT);
    }else{
        $hashedPassword = $adminData['data']['password'];
    }

    if($name != '' && $email != '' ){
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = update('admins',$adminId,$data);
        if($result){
            redirect('admin-edit.php?id='.$adminId, 'Admin updated sucessfully!');
        }else{
             redirect('admin-edit.php?id='.$adminId, 'Something went wrong!');
        }
    }else{
         redirect('admin-edit.php?id='.$adminId, 'Please fill required fields!');
    }
}