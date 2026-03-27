<?php
// Dọc và xóa thông báo
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>
<div class="col-12">
    <!-- Thông báo lỗi -->
     <?php if(!empty($error)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach($error as $err): ?>
                    <li><?= $err ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>?action=product/update" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Name</label>
        <input type="text" name="name" value="<?= $product['name'] ?? '' ?>" class="form-control" id="exampleFormControlInput1" placeholder="Enter product name">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        </div>
         <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Price</label>
        <input type="number" name="price" value="<?= $product['price'] ?? '' ?>" class="form-control" id="exampleFormControlInput1" placeholder="Enter product price">
        </div>
         <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Stock</label>
        <input type="number" name="stock" value="<?= $product['stock'] ?? '' ?>" class="form-control" id="exampleFormControlInput1" placeholder="Enter product stock">
        </div>
         <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Image</label>
        <input type="file" name="image" class="form-control" id="exampleFormControlInput1">
        </div>
         <div>
        <?php if(!empty($product['image'])): ?>
            <img src="<?=BASE_ASSETS_UPLOADS. $product['image'] ?>" alt="<?= $product['name'] ?>" width="100">  
        <?php endif; ?>
        </div>
        <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Category</label>
        <select class="form-select" name="id_category" aria-label="Default select example">
        <?php foreach($categories as $category): ?>
            <option value="<?= $category['id'] ?>" 
            <?= ($product['id_category'] ?? '') == $category['id'] ? 'selected' : '' ?>>
            <?= $category['name'] ?>
        </option>
        <?php endforeach; ?>
        </select>
        </div>
        <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">
            <?= $product['description'] ?? '' ?>
        </textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
        <a href="<?= BASE_URL ?>?action=products" class="btn btn-secondary">Quay lại</a>
    </form>
</div>