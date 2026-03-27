<?php

if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}

if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        // Kiểm tra lỗi upload từ PHP
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Lỗi upload: mã lỗi ' . $file['error']);
        }

        $destDir = PATH_ASSETS_UPLOADS . $folder;

        // Tự động tạo thư mục nếu chưa tồn tại
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $filename   = time() . '-' . basename($file['name']);
        $targetFile = $folder . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $destDir . '/' . $filename)) {
            return $targetFile;
        }

        throw new Exception('Upload file không thành công!');
    }
}