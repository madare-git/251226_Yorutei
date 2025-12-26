<?php
$owner_name =$_POST['owner_name'];
$shop_name =$_POST['shop_name'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$genre=$_POST['genre'];
$children=$_POST['children'];
$allergy=$_POST['allergy'];
$date= date('Y-m-d H:i:s');

// ファイルパスの設定（ここがチェックより先に必要です）
$file_path = 'data/data.txt';

// --- 重複チェック開始 ---
if (file_exists($file_path)) {
    $file = fopen($file_path, 'r');
    while (($line = fgets($file)) !== false) {
        $existing_data = explode('/', trim($line));
        // メールアドレス（インデックス5）が一致するかチェック
        if (isset($existing_data[5]) && $existing_data[5] === $email) {
            fclose($file);
            // 一致した場合、ポップアップを出して前の画面に戻る
            echo "<script>
                alert('このメールアドレス（{$email}）はすでに登録されています。別の画面で修正するか、別のPCから入力してください。');
                history.back();
            </script>";
            exit; // 処理をここで中断
        }
    }
    fclose($file);
}
// --- 重複チェック終了 ---

// 重複がなければ保存処理へ進む


$data = $date.'/'.$owner_name.'/'.$shop_name.'/'.$address.'/'.$phone.'/'.$email.'/'.$genre. '/'.$children. '/'.$allergy. PHP_EOL;
// var_dump($data);

file_put_contents('data/data.txt',$data,FILE_APPEND);

?>

<html lang="ja">
<head>
    <title>よる定 - 店舗基本情報登録</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <style>
        /* ベーススタイル: shop_ui.htmlと統一 */
        .container {
            max-width: 500px; /* 完了画面用に少しスリムに */
            width: 100%;
            text-align: center; /* テキストを中央寄せ */
        }


        /* 成功アイコンのスタイル */
        .success-icon {
            font-size: 60px;
            color: #4285F4; /* メインカラーの青 */
            background-color: #e8f0fe; /* 薄い青の背景 */
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            margin: 0 auto 20px;
        }

        h1 {
            color: #4285F4;
            font-size: 1.8em;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* ナビゲーションリンク・ボタンのスタイル */
        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column; /* スマホで見やすいように縦並び */
            gap: 15px;
        }

        .nav-links li {
            width: 100%;
        }

        .nav-links a {
            display: block;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        /* メインボタン: shop_ui.htmlのsaveButtonと統一 */
        .btn-list {
            background-color: #4285F4;
            color: white;
        }

        .btn-list:hover {
            background-color: #3367d6;
        }

        /* 戻るボタン: 控えめなデザイン */
        .btn-back {
            background-color: transparent;
            color: #4285F4;
            border: 2px solid #4285F4;
        }

        .btn-back:hover {
            background-color: #e8f0fe;
        }
        </style>
</head>
    

<body>
    <div class="container">
        <div class="success-icon">✓</div>
        
        <h1>申し込みが完了しました</h1>
        
        <p>
            ご登録ありがとうございます。
        </p>

        <ul class="nav-links">
            <li><a href="read.php" class="btn-list">登録情報確認</a></li>
            <li><a href="index.php" class="btn-back">入力画面に戻る</a></li>
        </ul>
        
    </div>
</body>

</html>