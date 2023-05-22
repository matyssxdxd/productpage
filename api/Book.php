<?php 

include_once "./ProductContr.php";

class Book extends ProductContr {

    private $weight;

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function saveProduct() {
        if (empty($this->getSku()) || empty($this->getName()) || empty($this->getPrice()) || empty($this->getWeight())) {
            return ['status' => 0, 'message' => 'Please, submit required data'];
        }
        if (!is_numeric($this->getPrice()) || !is_numeric($this->getWeight())) {
            return ['status' => 0, 'message' => 'Please, provide the data of indicated type'];
        }
        if ($this->skuTaken($this->getSku())) {
            return ['status' => 0, 'message' => 'SKU is already taken'];
        }
        $sql = "INSERT INTO products (sku, name, price, type, weight) VALUES (?, ?, ?, ?, ?)";
        $values = [$this->getSku(), $this->getName(), $this->getPrice(), $this->getType(), $this->getWeight()];
        $this->addToDB($sql, $values);
        return ['status' => 1, 'message' => 'Successfully saved product to the database'];
    }

}

?>