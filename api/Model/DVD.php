<?php

include_once "../ProductContr.php";

class DVD extends Product
{
    private string $size;

    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): DVD
    {
        $this->size = $size;

        return $this;
    }

    public function saveProduct(): array
    {
        if (empty($this->getSku()) || empty($this->getName()) || empty($this->getPrice()) || empty($this->size)) {
            return ['status' => 0, 'message' => 'Please, submit required data'];
        }
        if (!is_numeric($this->getPrice()) || !is_numeric($this->size)) {
            return ['status' => 0, 'message' => 'Please, provide the data of indicated type'];
        }
        if ($this->skuTaken($this->getSku())) {
            return ['status' => 0, 'message' => 'SKU is already taken'];
        }
        $sql = "INSERT INTO products(sku, name, price, type, size) VALUES (?, ?, ?, ?, ?)";
        $values = [$this->getSku(), $this->getName(), $this->getPrice(), $this->getType(), $this->size];
        if ($this->addToDB($sql, $values)) {
            return ['status' => 1, 'message' => 'Successfully saved product to the database'];
        } else {
            return ['status' => 0, 'message' => 'Failed to saved product to the database'];
        }
    }

}

?>