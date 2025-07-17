<?php
require '../config/functions.php';

$paramResult = checkParamId('id');

if (is_numeric($paramResult)) {
    $categoryId = validate($paramResult);
    $category = getById('categories', $categoryId);
    if ($category['status'] == 200) {
        $categoryDelete = delete('categories', $categoryId);
        if ($categoryDelete) {
            redirect('categories.php', 'Category Deleted Successfully!');
        } else {
            redirect('categories.php', 'Something went wrong');
        }
    } else {

        redirect('categories.php', $category['message']);
    }
} else {
    redirect('categories.php', 'Something went wrong');
}
