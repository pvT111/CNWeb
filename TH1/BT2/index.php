<?php
// Đọc file quiz
$lines = file("Quiz.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$questions = [];
$current = [
    "question" => "",
    "options" => [],
    "answer" => []
];

foreach ($lines as $line) {

    if (strpos($line, "ANSWER:") === 0) {
        // Lấy phần sau "ANSWER:"
        $ans = trim(substr($line, 7));

        // Tách nhiều đáp án (Ví dụ: C, D)
        $current["answer"] = array_map("trim", explode(",", $ans));

        // Lưu câu hỏi vào danh sách
        $questions[] = $current;

        // Reset
        $current = ["question" => "", "options" => [], "answer" => []];
    }
    else {

        // Nếu chưa có câu hỏi thì dòng đầu tiên là câu hỏi
        if ($current["question"] === "") {
            $current["question"] = $line;
        } else {
            $current["options"][] = $line;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài Thi Trắc Nghiệm Android</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { max-width: 850px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; }
        .qbox { padding: 15px; margin: 15px 0; border: 1px solid #ccc; border-radius: 6px; }
        h3 { margin-bottom: 10px; }
        button { padding: 10px 20px; font-size: 16px; cursor: pointer; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Bài Thi Trắc Nghiệm Android</h1>

    <form method="post">
        <?php foreach ($questions as $i => $q): ?>
            <div class="qbox">
                <h3>Câu <?= $i + 1 ?>: <?= $q["question"] ?></h3>

                <?php foreach ($q["options"] as $opt): ?>
                    <?php 
                    // Lấy ký tự A/B/C/D
                    preg_match('/^([A-E])\\./', $opt, $m);
                    $letter = $m[1];
                    ?>
                    <label>
                        <input type="checkbox" name="q<?= $i ?>[]" value="<?= $letter ?>">
                        <?= $opt ?>
                    </label><br>
                <?php endforeach; ?>

                <?php if ($_POST): ?>
                    <?php
                        $user = $_POST["q".$i] ?? [];
                        sort($user);
                        $correctAns = $q["answer"];
                        sort($correctAns);
                        $isCorrect = ($user == $correctAns);
                        $color = $isCorrect ? "green" : "red";
                    ?>
                    <p style="color: green;"><b>Đáp án đúng:</b> <?= implode(", ", $q["answer"]) ?></p>
                    <p style="color: <?= $color ?>;"><b>Bạn chọn:</b> <?= empty($user) ? "Không chọn" : implode(", ", $user) ?></p>
                    
                <?php endif; ?>

            </div>
        <?php endforeach; ?>

        <?php if (!$_POST): ?>
            <button type="submit">Nộp bài</button>
        <?php endif; ?>
    </form>

    <?php if ($_POST): ?>
        <h2>Kết quả tổng:</h2>
        <?php
        $correct = 0;

        foreach ($questions as $i => $q) {
            $user = $_POST["q".$i] ?? [];
            sort($user);
            $correctAns = $q["answer"];
            sort($correctAns);
            if ($user == $correctAns) $correct++;
        }
        
        echo "<h3>Tổng điểm: $correct / " . count($questions) . "</h3>";
        ?>
    <?php endif; ?>

</div>

</body>
</html>
