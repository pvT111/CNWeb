<?php
require "data.php";
// Check user role (admin or guest)
$isAdmin = isset($_GET['role']) && $_GET['role'] === 'admin';

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Hoa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .role-switch {
            text-align: right;
            margin-bottom: 20px;
        }
        .role-switch a {
            padding: 10px 15px;
            margin-left: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .role-switch a:hover {
            background-color: #0056b3;
        }
        
       /* Guest View Styles - Article Layout */
    .flowers-articles {
        display: block; /* Hiển thị liên tục dạng bài viết */
    }

        .flower-article {
        margin-bottom: 50px; /* Khoảng cách giữa các bài */
        background: #fff;
        border-radius: 0;
        box-shadow: none;
        overflow: visible;
    }

    .flower-article img {
        width: 100%;
        max-height: 450px;
        object-fit: cover;
        display: block;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0; /* Viền mỏng giống bài báo */
    }

    .flower-content {
        padding: 0;
    }

    .flower-content h3 {
        color: #cc3333;
        font-size: 24px;
        margin-bottom: 15px;
        padding-top: 10px;
        border-top: 1px dashed #ccc; /* Gạch ngang phân tách bài */
    }

    .flower-content p {
        color: #333;
        line-height: 1.7;
        text-align: justify; /* Căn đều hai bên cho nội dung */
    }

        /* Admin view styles */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .admin-table thead {
            background-color: #007bff;
            color: white;
        }
        .admin-table th, .admin-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .admin-table tbody tr:hover {
            background-color: #f9f9f9;
        }
        .admin-table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn-edit, .btn-delete, .btn-add {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-add {
            background-color: #28a745;
            color: white;
            margin-bottom: 20px;
        }
        .btn-edit {
            background-color: #ffc107;
            color: black;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-add:hover { background-color: #218838; }
        .btn-edit:hover { background-color: #e0a800; }
        .btn-delete:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌸 Danh Sách Các Loài Hoa</h1>
        
        <div class="role-switch">
            <?php if ($isAdmin): ?>
                <strong>Chế độ: Quản Trị</strong>
                <a href="index.php">Chuyển sang Guest</a>
            <?php else: ?>
                <strong>Chế độ: Khách</strong>
                <a href="index.php?role=admin">Chuyển sang Quản Trị</a>
            <?php endif; ?>
        </div>

        <?php if ($isAdmin): ?>
            <!-- Admin View - Table -->
            <button class="btn-add">+ Thêm Hoa Mới</button>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Tên Hoa</th>
                        <th>Mô Tả</th>
                        <th>Ảnh</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($flowers as $flower): ?>
                        <tr>
                            <td><?php echo $flower['Ten']; ?></td>
                            <td><?php echo $flower['Mota']; ?></td>
                            <td><img src="<?= $flower['Anh'] ?>" alt="<?= $flower['Ten'] ?>" class = "flower-image"></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-edit">Sửa</button>
                                    <button class="btn-delete">Xóa</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- Guest View - Article List -->
        <div class="flowers-articles">
        <?php foreach ($flowers as $flower): ?>
            <div class="flower-article">
                <div class="flower-content">
                    <h3><?= $flower['Ten'] ?></h3>
                    <p><?= $flower['Mota'] ?></p>
                </div>
                <img src="<?= $flower['Anh'] ?>" alt="<?= $flower['Ten'] ?>">
            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>
    </div>
</body>
</html>