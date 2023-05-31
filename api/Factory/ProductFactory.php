<?php

namespace Factory;

use Book;
use Furniture;
use Product;

class ProductFactory
{
    public function create(
        Product $product,
        string $name,
        string $sku,
        int $price,
        string $type,
        ?string $weight = null,
        ?string $size = null,
        ?string $width = null,
        ?string $height = null,
        ?string $length = null
    ): Product
    {
        $product = (new $product)
            ->setName($name)
            ->setSku($sku)
            ->setPrice($price)
            ->setType($type);

        if ($product instanceof Book) {
            $product->setWeight($weight);
        }

        if ($product instanceof \DVD) {
            $product->setSize($size);
        }

        if ($product instanceof Furniture) {
            $product->setWidth($width)
                ->setHeight($height)
                ->setLength($length);
        }

        return $product;
    }
}