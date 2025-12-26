<?php
// 検索されたメールアドレスを取得
$search_email = isset($_POST['search_email']) ? trim($_POST['search_email']) : '';

$file_path = 'data/data.txt';
$match_results = [];

// ラベルの定義（index.phpの項目順に合わせる）
$labels = [
    "登録日時", "代表者氏名", "店舗名", "住所", "電話番号", 
    "メールアドレス", "ジャンル", "お子様の入店ポリシー", "アレルギー対応"
];

// 検索ボタンが押された場合のみファイルを読み込む
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($search_email)) {
    if (file_exists($file_path)) {
        $file = fopen($file_path, 'r');
        while (($line = fgets($file)) !== false) {
            $data = explode('/', trim($line));
            
            // データが正しく分割され、かつメールアドレス(Index 5)が一致する場合
            if (isset($data[5]) && $data[5] === $search_email) {
                $match_results[] = $data;
            }
        }
        fclose($file);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>店舗情報照会 - よる定</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        /* 縦型テーブル用の追加スタイル */
        .result-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 30px;
            overflow: hidden;
        }
        .vertical-table {
            width: 100%;
            border-collapse: collapse;
        }
        .vertical-table th {
            width: 30%;
            background-color: #f8f9fa;
            color: #333;
            border-bottom: 1px solid #eee;
            border-right: 1px solid #eee;
            text-align: left;
        }
        .vertical-table td {
            border-bottom: 1px solid #eee;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
            background: #fff;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>登録情報照会</h1>
        <p style="text-align: center; color: #666; margin-bottom: 20px;">
            登録したメールアドレスを入力して情報を確認してください。
        </p>

        <form method="post" action="read.php" class="search-box">
            <input type="email" name="search_email" placeholder="example@mail.com" 
                   value="<?= htmlspecialchars($search_email) ?>" required>
            <button type="submit" class="btn" style="margin-top:0;">情報を照会する</button>
        </form>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <?php if (empty($match_results)): ?>
                <div class="no-data">
                    <p>該当するメールアドレスのデータは見つかりませんでした。</p>
                </div>
            <?php else: ?>
                <?php foreach ($match_results as $entry): ?>
                    <div class="result-card">
                        <table class="vertical-table">
                            <?php foreach ($labels as $index => $label): ?>
                                <tr>
                                    <th><?= htmlspecialchars($label) ?></th>
                                    <td><?= htmlspecialchars($entry[$index] ?? '未設定') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 20px;">
            <a href="index.php" class="btn-back" style="text-decoration: none; padding: 10px 20px; display: inline-block; border: 2px solid #4285F4; border-radius: 8px;">入力画面に戻る</a>
        </div>
    </div>
</body>
</html>