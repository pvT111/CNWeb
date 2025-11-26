<?php
// Đường dẫn file CSV (đổi theo nhu cầu)
$csvFile = "65HTTT_Danh_sach_diem_danh.csv";

// Tìm kiếm
$keyword = isset($_GET["q"]) ? strtolower(trim($_GET["q"])) : "";

// Đọc CSV
$rows = [];
$headers = [];

if (file_exists($csvFile)) {
    if (($handle = fopen($csvFile, "r")) !== FALSE) {

        // Lấy hàng đầu tiên làm header
        $headers = fgetcsv($handle);

        // Đọc dữ liệu
        while (($data = fgetcsv($handle)) !== FALSE) {
            $row = array_combine($headers, $data);
            $rows[] = $row;
        }
        fclose($handle);
    }
}

// // Lọc theo từ khóa
// if ($keyword !== "") {
//     $rows = array_filter($rows, function($row) use ($keyword) {
//         foreach ($row as $value) {
//             if (strpos(strtolower($value), $keyword) !== false) return true;
//         }
//         return false;
//     });
// }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đọc & Hiển thị CSV bằng PHP</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f3f3f3; }
        tr:nth-child(even) { background: #fafafa; }
        pre { background: #222; color: #0f0; padding: 10px; overflow: auto; }
    </style>
</head>
<body>

<!-- <form method="get">
    <input type="text" name="q" placeholder="Tìm kiếm..." value="<?= htmlspecialchars($keyword) ?>">
    <button type="submit">Lọc</button>
</form> -->

<h3>Kết quả:</h3>

<table>
    <tr>
        <?php foreach ($headers as $h): ?>
            <th><?= htmlspecialchars($h) ?></th>
        <?php endforeach; ?>
    </tr>

    <?php foreach ($rows as $r): ?>
        <tr>
            <?php foreach ($headers as $h): ?>
                <td><?= htmlspecialchars($r[$h]) ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
