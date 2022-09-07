<?php
// マネジメントアカウントかどうかを判定
echo $_POST['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理画面トップページ</title>
</head>
<body>
  <nav>
    <a href="./user_regitation.php">ユーザー登録</a>
    <a href="./event_registration.php">イベント登録</a>
    <a href="./event_list.php">イベント一覧</a>
    <a href="./event_edit.php">イベント編集</a>
  </nav>
  
</body>
</html>