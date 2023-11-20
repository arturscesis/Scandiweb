<?php

namespace App\src\ScandiTest;

use mysqli;

class Product {
    private $sku;
    private $name;
    private $price;
    private $productType;
    private $size;
    private $weigth;
    private $height;
    private $width;
    private $length;

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getSku() {
        return $this->sku;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setProductType($productType) {
        $this->productType = $productType;
    }

    public function getProductType() {
        return $this->productType;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getLength() {
        return $this->length;
    }

    public function saveToDatabase() {
        $conn = new \mysqli('ilzyz0heng1bygi8.chr7pe7iynqr.eu-west-1.rds.amazonaws.com', 'y3r9gakd4qsw4ihy', 'nioe769jo1js0ns7', 'kj1vvb38qpl2d0c9');
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($this->skuExists($conn, $this->sku)) {
            $conn->close();
            return;
        }
    
        $sql = '';
    
        switch ($this->productType) {
            case 'DVD':
                $sql = "INSERT INTO products (sku, name, price, productType, size) VALUES (?, ?, ?, ?, ?)";
                break;
    
            case 'Book':
                $sql = "INSERT INTO products (sku, name, price, productType, weight) VALUES (?, ?, ?, ?, ?)";
                break;
    
            case 'Furniture':
                $sql = "INSERT INTO products (sku, name, price, productType, length, width, height) VALUES (?, ?, ?, ?, ?, ?, ?)";
                break;
    
            default:
                break;
        }
    
        if ($sql === '') {
            die("Error: Invalid product type");
        }
    
        $stmt = $conn->prepare($sql);
    
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        switch ($this->productType) {
            case 'DVD':
                $stmt->bind_param("sssss", $this->sku, $this->name, $this->price, $this->productType, $this->size);
                break;
            case 'Book':
                $stmt->bind_param("sssss", $this->sku, $this->name, $this->price, $this->productType, $this->weight);
                break;
    
            case 'Furniture':
                $stmt->bind_param("sssssss", $this->sku, $this->name, $this->price, $this->productType, $this->height, $this->width, $this->length);
                break;
    
            default:
                break;
        }
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
    }
    
    private function skuExists($conn, $sku) {
        $sql = "SELECT COUNT(*) FROM products WHERE sku = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("s", $sku);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
    
        return $count > 0;
    }

    public static function getAllProducts() {
        $conn = new \mysqli('ilzyz0heng1bygi8.chr7pe7iynqr.eu-west-1.rds.amazonaws.com', 'y3r9gakd4qsw4ihy', 'nioe769jo1js0ns7', 'kj1vvb38qpl2d0c9');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        $products = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $product = new Product();
                $product->setProperties($row);
                $products[] = $product;
            }
        }

        $conn->close();
        return $products;
    }

    public function setProperties(array $data) {
        foreach ($data as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    public static function deleteProduct($sku) {
        $conn = new \mysqli('ilzyz0heng1bygi8.chr7pe7iynqr.eu-west-1.rds.amazonaws.com', 'y3r9gakd4qsw4ihy', 'nioe769jo1js0ns7', 'kj1vvb38qpl2d0c9');
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $sql = "DELETE FROM products WHERE sku = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("s", $sku);
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
    }
}

?>