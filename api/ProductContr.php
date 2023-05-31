<?php 

include_once "./ProductModel.php";

class ProductContr extends ProductModel {
    
    private $sku;
    private $name;
    private $price;
    private $type;

    public function setSku($sku) {
        $this->sku = $sku;

    }
    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getSku() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getType() {
        return $this->type;
    }

    public function deleteProduct($sku) {
        if(!$this->removeFromDB($sku)) {
            return ['status' => 0, 'message' => 'Failed to delete product'];
        }
        return ['status' => 1, 'message' => 'Product deleted successfully'];
    }

}

?>