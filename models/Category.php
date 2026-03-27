<?php
class Category extends BaseModel{
    protected $table = 'categorys';
    // Lấy tất cả danh mục
    public function getAll(){
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
}
?>