<?php

namespace App\controllers;

use App\Src\ScandiTest\Product;

class AddController {

    public function index() {
        $filePath = __DIR__ . '/../views/AddProduct.html';
    
        if (file_exists($filePath)) {
            include($filePath);
        } else {
            echo 'Error: AddProduct.html not found';
        }
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sku = $_POST['sku'] ?? '';
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $type = $_POST['type'] ?? '';
    
            $product = new Product();
    
            $product->setSku($sku);
            $product->setName($name);
            $product->setPrice($price);
            $product->setProductType($type);
    
            switch ($type) {
                case 'DVD':
                    $size = $_POST['size'] ?? '';
                    $product->setSize($size);
                    break;
    
                case 'Book':
                    $weight = $_POST['weight'] ?? '';
                    $product->setWeight($weight);
                    break;
    
                case 'Furniture':
                    $length = $_POST['length'] ?? '';
                    $width = $_POST['width'] ?? '';
                    $height = $_POST['height'] ?? '';
                    $product->setLength($length);
                    $product->setWidth($width);
                    $product->setHeight($height);
                    break;
    
                default:
                    break;
            }

            $product->saveToDatabase();
    
            header('Location: /scanditest/');
            exit();
        } else {
            echo 'Error: Form not submitted';
        }
    }
}

?>