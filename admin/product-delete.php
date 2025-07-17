<?php
require '../config/functions.php';

$paramResult = checkParamId('id');

if (is_numeric($paramResult)) {
    $productId = validate($paramResult);
    $product = getById('products', $productId);
    if ($product['status'] == 200) {
        $productData = $product['data'];
        $imagePath = "../assets/uploads/products/".$productData['image'];
        if(file_exists($imagePath)){
            unlink($imagePath);
        }
        $productDelete = delete('products', $productId);
        if ($productDelete) {
            redirect('products.php', 'Product Deleted Successfully!');
        } else {
            redirect('products.php', 'Something went wrong');
        }
    } else {

        redirect('products.php', $product['message']);
    }
} else {
    redirect('products.php', 'Something went wrong');
}
