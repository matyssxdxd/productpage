<?php

include_once "./Database.php";

abstract class ProductModel extends Database {

    protected function addToDB($sql, $values) {
        $stmt = $this->connect()->prepare($sql);
        if($stmt->execute($values)) {
            return true;
        }
        return false;
    }

    protected function getProducts() {
        $stmt = $this->connect()->prepare('SELECT * FROM products');
        if (!$stmt->execute()) {
            return false;
        }
        if ($stmt->rowCount() == 0) {
            return false;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function removeFromDB($sku) {
        $stmt = $this->connect()->prepare("DELETE FROM products WHERE sku=?");
        if(!$stmt->execute([$sku])) {
            return false;
        }
        return true;
    }

    protected function skuTaken($sku) {
        $stmt = $this->connect()->prepare('SELECT SKU FROM products');
        if(!$stmt->execute()) {
            return false;
        }
        foreach($stmt->fetchAll() as $value) {
            if ($value["SKU"] == $sku) {
                return true;
            }
        }
        return false;   
    }
}

?>