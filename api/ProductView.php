<?php 

include_once "./ProductModel.php";

class ProductView extends ProductModel {
    
    public function showProducts() {
        return $this->getProducts();
    }

}

?>