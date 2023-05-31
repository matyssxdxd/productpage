<?php 

class Database {
    private string $server = 'localhost';
    private string $dbname = 'productpage';
    private string $user = 'root';
    private string $password = 'root';

    public function connect() {
        try {
            $conn = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->dbname, $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\Exception $e) {
            echo "Database Error:" . $e->getMessage();
        }
    }

    protected function addToDB($sql, $values)
    {
        $stmt = $this->connect()->prepare($sql);
        if ($stmt->execute($values)) {
            return true;
        }
        return false;
    }

    protected function getAllFromDB()
    {
        $stmt = $this->connect()->prepare('SELECT * FROM products');
        if (!$stmt->execute()) {
            return false;
        }
        if ($stmt->rowCount() == 0) {
            return false;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function removeFromDB($sku)
    {
        $stmt = $this->connect()->prepare("DELETE FROM products WHERE sku = ?");
        if (!$stmt->execute([$sku])) {
            return false;
        } else {
            return true;
        }
    }

    protected function skuTaken($sku)
    {
        $stmt = $this->connect()->prepare('SELECT SKU FROM products');
        if (!$stmt->execute()) {
            return false;
        }
        foreach ($stmt->fetchAll() as $value) {
            if ($value["SKU"] == $sku) {
                return true;
            }
        }
        return false;
    }

    public function getProducts(): array
    {
        $data = $this->getAllFromDB();
        if(!$data) {
            return ['status' => 0, 'message' => 'Failed to retrieve products from the database'];
        }
        return $data;
    }

    public function deleteProduct($sku): array
    {
        if(!$this->removeFromDB($sku)) {
            return ['status' => 0, 'message' => 'Failed to delete product from the database'];
        } else {
            return ['status' => 1, 'message' => 'Product successfully deleted from the databse'];
        }
    }
}
