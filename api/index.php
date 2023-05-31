<?php

use Factory\ProductFactory;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

include_once "./Factory/ProductFactory.php";
include_once "./ProductContr.php";

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case "POST":
        $productType = $_POST['product'];

        $name = $_POST['name'];
        $sku = $_POST['sku'];
        $price = (int)$_POST['price'];
        $attribute = $_POST['attribute'];
        $weight = $_POST['weight'] ?? null;
        $size = $_POST['size'] ?? null;
        $height = $_POST['height'] ?? null;
        $width = $_POST['width'] ?? null;
        $length = $_POST['length'] ?? null;

        match ($productType) {
            'book' => $productClass = (new Book()),
            'dvd' => $productClass = (new DVD()),
            'furniture' => $productClass = (new Furniture()),
        };

        $product = (new ProductFactory())->create(
            $productClass,
            $name,
            $sku,
            $price,
            $productType,
            weight: $weight,
            size: $size,
            width: $width,
            height: $height,
            length: $length
        );

        $response = $product->saveProduct();

        echo json_encode($response);
        break;
    case "GET":
        $products = new Database();

        $response = $products->getProducts();

        echo json_encode($response);
        break;
    case "DELETE":
        $sku = explode("/", $_SERVER["REQUEST_URI"])[4];

        $product = new Database();

        $response = $product->deleteProduct($sku);

        echo json_encode($response);
        break;
}
