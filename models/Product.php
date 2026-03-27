<?php
class Product extends BaseModel{
    // Khai báo thuộc tính 
    protected $table = 'products';
    // Lấy tất cả sản phẩm
    public function getAll(){
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    // Lấy sản phẩm theo id
    public function getById($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    // Xóa sản phẩm theo id
    public function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
 // Thêm sản phẩm mới
    public function create($data){
        $sql = "INSERT INTO {$this->table} (name, price, stock, image, description, id_category) 
                VALUES (:name, :price, :stock, :image, :description, :id_category)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image' => $data['image'],
            'description' => $data['description'],
            'id_category' => $data['id_category']
        ]);
    }
    // Cập nhật sản phẩm
    public function update($data){
        $sql = "UPDATE {$this->table} SET name = :name, price = :price, stock = :stock, 
                image = :image, description = :description, id_category = :id_category
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $data['id'],
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image' => $data['image'],
            'description' => $data['description'],
            'id_category' => $data['id_category']
        ]);
    }
}
?>