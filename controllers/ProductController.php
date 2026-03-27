<?php
    class ProductController{
        private Product $productModel;
        private Category $categoryModel;
        public function __construct()
        {
            $this->productModel = new Product();
            $this->categoryModel = new Category();
        }
        public function index(){
            $products = $this->productModel->getAll();
            $view = 'products/index';
            $title = 'Danh sách sản phẩm';
            //var_dump($products);
            require_once PATH_VIEW_MAIN;
        }
        public function delete(){
            $id = $_POST['id'] ?? null;
            $product = $this->productModel->getById($id);
            if(!$product){
                $_SESSION['error'] = "Sản phẩm không tồn tại";
                header("Location: " . BASE_URL . "?action=products");
                exit;
            }else{
                $_SESSION['success'] = "Sản phẩm đã được xóa thành công";
                $this->productModel->delete($id);
                header("Location: " . BASE_URL . "?action=products");
                exit;
            }
        }
        // Thêm
        // Hiện thị form thêm
        public function create(){
            $title = 'Thêm sản phẩm';
            $view = 'products/create';
            // Lấy danh sách category để hiển thị trong select
            $categories = $this->categoryModel->getAll();
            // var_dump($categories);
            require_once PATH_VIEW_MAIN;
        }
        // Xử lý thêm
        public function store(){
            // Xử lý lưu sản phẩm mới vào database
            // var_dump($_POST);
            $errors = $this->validate($_POST);
            $imageErrors = $this->validateImage($_FILES);
            if(!empty($errors) || !empty($imageErrors)){
                $errors = array_merge($errors, $imageErrors);
                $_SESSION['error'] = $errors;
                header("Location: " . BASE_URL . "?action=product/create");
                exit;
            }else{
                $data = [
                    'name' => $_POST['name'],
                    'price' => $_POST['price'],
                    'stock' => $_POST['stock'],
                    'description' => $_POST['description'],
                    'id_category' => $_POST['id_category'],
                    'image' => null,
                ];
                // Xử lý upload ảnh
                try {
                    $imagePath = upload_file('products', $_FILES['image']);
                    $data['image'] = $imagePath;
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: " . BASE_URL . "?action=product/create");
                    exit;
                }
                if($this->productModel->create($data)){
                    $_SESSION['success'] = "Sản phẩm đã được thêm thành công";
                    header("Location: " . BASE_URL . "?action=products");
                    exit;
                }else{
                    $_SESSION['error'] = "Thêm sản phẩm thất bại";
                    header("Location: " . BASE_URL . "?action=product/create");
                    exit;
                }

            }
        }
        // Sửa
        // Hiện thị form sửa
        public function edit(){
                $id = $_GET['id'] ?? null;
                $product = $this->productModel->getById($id);
                if(!$product){
                    $_SESSION['error'] = "Sản phẩm không tồn tại";
                    header("Location: " . BASE_URL . "?action=products");
                    exit;
                }else{
                    $title = 'Sửa sản phẩm';
                    $view = 'products/edit';
                    // Lấy danh sách category để hiển thị trong select
                    $categories = $this->categoryModel->getAll();
                    require_once PATH_VIEW_MAIN;
                }
        }
        // Xử lý sửa
        public function update(){
            // Xử lý lưu sản phẩm mới vào database
            // var_dump($_POST);
            $id = $_POST['id'] ?? null;
            $product = $this->productModel->getById($id);
            if(!$product){
                $_SESSION['error'] = "Sản phẩm không tồn tại";
                header("Location: " . BASE_URL . "?action=products");
                exit;
            }
            // validate dữ liệu
            $errors = $this->validate($_POST);
            if(!empty($errors)){
                $_SESSION['error'] = $errors;
                header("Location: " . BASE_URL . "?action=product/edit&id=$id");
                exit;
            }else{
                $data = [
                    'id'=> $id,
                    'name' => $_POST['name'],
                    'price' => $_POST['price'],
                    'stock' => $_POST['stock'],
                    'description' => $_POST['description'],
                    'id_category' => $_POST['id_category'],
                    'image' => null,
                ];
                // Xử lý upload ảnh nếu có
                if(!empty($_FILES['image']['name'])){
                    $imageErrors = $this->validateImage($_FILES);
                    if(!empty($imageErrors)){
                        $_SESSION['error'] = $imageErrors;
                        header("Location: " . BASE_URL . "?action=product/edit&id=$id");
                        exit;
                    }
                    try {
                        $imagePath = upload_file('products', $_FILES['image']);
                        $data['image'] = $imagePath;
                    } catch (Exception $e) {
                        $_SESSION['error'] = $e->getMessage();
                        header("Location: " . BASE_URL . "?action=product/edit&id=$id");
                        exit;
                    }
                }else{
                    $data['image'] = $product['image'];
                }
                if($this->productModel->update($data)){
                    $_SESSION['success'] = "Sản phẩm đã được cập nhật thành công";
                    header("Location: " . BASE_URL . "?action=products");
                    exit;
                }
                else{
                        $_SESSION['error'] = "Cập nhật sản phẩm thất bại";
                        header("Location: " . BASE_URL . "?action=product/edit&id=$id");
                        exit;
                }
            }
        }
        // Validate dữ liệu
        private function validate($data = []){
            $errors = [];
            if(empty($data['name'])){
                $errors[] = "Tên sản phẩm không được để trống";
            }
            if(empty($data['price'])){
                $errors[] = "Giá sản phẩm không được để trống";
            }elseif(!is_numeric($data['price']) || $data['price'] < 0){
                $errors[] = "Giá sản phẩm phải là số dương";
            }
            if(empty($data['stock'])){
                $errors[] = "Số lượng sản phẩm không được để trống";
            }elseif(!is_numeric($data['stock']) || $data['stock'] < 0){
                $errors[] = "Số lượng sản phẩm phải là số dương";
            }
            if(empty($data['id_category'])){
                $errors[] = "Danh mục sản phẩm không được để trống";
            }
            return $errors;
        }
        // Validate file
        private function validateImage($data = []){
                $errors = [];
                if(empty($data['image']['name'])){
                    $errors[] = "Ảnh sản phẩm không được để trống";
                }else{
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if(!in_array($data['image']['type'], $allowedTypes)){
                        $errors[] = "Ảnh sản phẩm phải là file ảnh (jpg, png, gif)";
                    }
                    $maxSize = 2 * 1024 * 1024; // 2MB
                    if($data['image']['size'] > $maxSize){
                        $errors[] = "Ảnh sản phẩm không được lớn hơn 2MB";
                    }
                }
                return $errors;
        }
    }

 ?>

