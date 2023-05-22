<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

include_once "./DVD.php";
include_once "./Book.php";
include_once "./Furniture.php";
include_once "./ProductContr.php";
include_once "./ProductView.php";

$request = explode("/", $_SERVER["REQUEST_URI"])[3];
$method = $_SERVER["REQUEST_METHOD"];

switch($method) {
    case "POST":
        $product = json_decode(file_get_contents("php://input"));
        $type = $product->type;
        switch($type) {
            case "dvd":
                $newProduct = new DVD();
                $newProduct->setSku($product->sku);
                $newProduct->setName($product->name);
                $newProduct->setPrice($product->price);
                $newProduct->setType($product->type);
                $newProduct->setSize($product->size);
                break;
            case "book":
                $newProduct = new Book();
                $newProduct->setSku($product->sku);
                $newProduct->setName($product->name);
                $newProduct->setPrice($product->price);
                $newProduct->setType($product->type);
                $newProduct->setWeight($product->weight);
                break;
            case "furniture":
                $newProduct = new Furniture();
                $newProduct->setSku($product->sku);
                $newProduct->setName($product->name);
                $newProduct->setPrice($product->price);
                $newProduct->setType($product->type);
                $newProduct->setHeight($product->height);
                $newProduct->setWidth($product->width);
                $newProduct->setLength($product->length);
                break;
            default:
                $response = ['status' => 0, 'message' => 'Please select a type'];
                echo json_encode($response);
                exit();
        }
        $response = $newProduct->saveProduct();
        return $response;
        break;
    case "GET":
        $allProducts = new ProductView();
        $response = $allProducts->showProducts();
        echo json_encode($response);
        break;
    case "DELETE":
        $sku = explode("/", $_SERVER["REQUEST_URI"])[4];
        $product = new ProductContr();
        $response = $product->deleteProduct($sku);
        echo json_encode($response);
        break;

}

?>