<?php

namespace App\controllers;

use App\Src\Scanditest\Product;

class ListController {

    public function index() {
        $products = Product::getAllProducts();

        $filePath = __DIR__ . '/../views/ProductList.html';

        if (file_exists($filePath)) {
            extract(['products' => $products]);

            include($filePath);
        } else {
            echo 'Error: ProductList.html not found';
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedProducts = json_decode($_POST['selectedProducts'], true);
    
            foreach ($selectedProducts as $sku) {
                Product::deleteProduct($sku);
            }

            header('Location: /scanditest/');
            exit();
        } else {
            echo 'Error: Form not submitted';
        }
    }
}
?>