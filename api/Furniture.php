<?php 

include_once "./ProductContr.php";

class Furniture extends ProductContr {

    private $height;
    private $width;
    private $length;

    public function setHeight($height) {
        $this->height = $height;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getLength() {
        return $this->length;
    }

    public function saveProduct() {
        if (empty($this->getSku()) || empty($this->getName()) || empty($this->getPrice()) || empty($this->getHeight()) || empty($this->getWidth()) || empty($this->getLength())) {
            return ['status' => 0, 'message' => 'Please, submit required data'];
        }
        if (!is_numeric($this->getPrice()) || !is_numeric($this->getHeight()) || !is_numeric($this->getWidth()) || !is_numeric($this->getLength())) {
            return ['status' => 0, 'message' => 'Please, provide the data of indicated type'];
        }
        if ($this->skuTaken($this->getSku())) {
            return ['status' => 0, 'message' => 'SKU is already taken'];
        }
        $sql = "INSERT INTO products (sku, name, price, type, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $values = [$this->getSku(), $this->getName(), $this->getPrice(), $this->getType(), $this->getHeight(), $this->getWidth(), $this->getLength()];
        $this->addToDB($sql, $values);
        return ['status' => 1, 'message' => 'Successfully saved product to the database'];
    }
}

?>