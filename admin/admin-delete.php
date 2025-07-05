<?php
require '../config/functions.php';

$paramResult = checkParamId('id');

if (is_numeric($paramResult)) {
    $adminId = validate($paramResult);
    $admin = getById('admins', $adminId);
    if ($admin['status'] == 200) {
        $adminDelete = delete('admins', $adminId);
        if ($adminDelete) {
            redirect('admins.php', 'Admin Deleted Successfully!');
        } else {
            redirect('admins.php', 'Something went wrong');
        }
    } else {

        redirect('admins.php', $admin['message']);
    }
} else {
    redirect('admins.php', 'Something went wrong');
}
