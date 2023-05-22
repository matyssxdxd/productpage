<?php 

include_once "./ProductContr.php";

class DVD extends ProductContr {

    private $size;

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function saveProduct() {
        if (empty($this->getSku()) || empty($this->getName()) || empty($this->getPrice()) || empty($this->getSize())) {
            return ['status' => 0, 'message' => 'Please, submit required data'];
        }
        if (!is_numeric($this->getPrice()) || !is_numeric($this->getSize())) {
            return ['status' => 0, 'message' => 'Please, provide the data of indicated type'];
        }
        if ($this->skuTaken($this->getSku())) {
            return ['status' => 0, 'message' => 'SKU is already taken'];
        }
        $sql = "INSERT INTO products (sku, name, price, type, size) VALUES (?, ?, ?, ?, ?)";
        $values = [$this->getSku(), $this->getName(), $this->getPrice(), $this->getType(), $this->getSize()];
        $this->addToDB($sql, $values);
        return ['status' => 1, 'message' => 'Successfully saved product to the database'];
    }
    
}

?>