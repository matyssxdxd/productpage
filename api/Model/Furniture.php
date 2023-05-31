<?php

include_once "../ProductContr.php";

class Furniture extends ProductContr
{
    private string $height;

    private string $width;

    private string $length;

    public function getHeight(): string
    {
        return $this->height;
    }

    public function setHeight(string $height): Furniture
    {
        $this->height = $height;
        return $this;
    }

    public function getWidth(): string
    {
        return $this->width;
    }

    public function setWidth(string $width): Furniture
    {
        $this->width = $width;
        return $this;
    }

    public function getLength(): string
    {
        return $this->length;
    }

    public function setLength(string $length): Furniture
    {
        $this->length = $length;

        return $this;
    }

    public function saveProduct(): array
    {
        if (empty($this->getSku()) || empty($this->getName()) || empty($this->getPrice()) || empty($this->height) ||
            empty($this->width) || empty($this->length)) {
            return ['status' => 0, 'message' => 'Please, submit required data'];
        }
        if (!is_numeric($this->getPrice()) || !is_numeric($this->height) || !is_numeric($this->width) ||
            !is_numeric($this->length)) {
            return ['status' => 0, 'message' => 'Please, provide the data of indicated type'];
        }
        if ($this->skuTaken($this->getSku())) {
            return ['status' => 0, 'message' => 'SKU is already taken'];
        }
        $sql = "INSERT INTO products(sku, name, price, type, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $values = [$this->getSku(), $this->getName(), $this->getPrice(), $this->getType(),
            $this->height, $this->width, $this->length];
        if ($this->addToDB($sql, $values)) {
            return ['status' => 1, 'message' => 'Successfully saved product to the database'];
        } else {
            return ['status' => 0, 'message' => 'Failed to saved product to the database'];
        }
    }
}

?>