<?php
// Dọc và xóa thông báo
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>
<!-- Hiển thị thông báo -->
<?php if($success): ?>
    <div class="alert alert-success"><?= $success ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
    
<?php endif; ?>
<?php if($error): ?>
    <div class="alert alert-danger"><?= $error ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<div class="col-12">
    <div>
        <a href="<?= BASE_URL ?>?action=product/create" class="btn btn-primary">Thêm sản phẩm</a>
    </div>
    <!-- Danh sách sản phẩm -->
     <div class="table-responsive">
         <h2>Danh sách sản phẩm</h2>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($products)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Không có sản phẩm nào</td>
                    </tr>   
                <?php else: ?>
                <?php foreach($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><?= $product['stock'] ?></td>
                    <td>
                    <img src="<?= BASE_ASSETS_UPLOADS.$product['image'] ?>" 
                    alt="<?= $product['name'] ?>"
                    width="100">
                    </td>
                    <td><?= $product['description'] ?></td>
                    <!-- BT: Hãy hiển thị tên danh mục -->
                    <td><?= $product['id_category'] ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>?action=product/edit&id=<?= $product['id'] ?>" 
                        class="btn btn-warning">Sửa</a>
                        <form method="POST"
                        action="<?= BASE_URL ?>?action=product/delete" class="d-inline">
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                             <button type="submit" 
                             class="btn btn-danger" 
                             onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm <?= $product['name'] ?>?')">Xóa</button>
                        </form>
                       
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
     </div>
</div>