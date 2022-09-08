<?php
require('../dbconnect.php');
// マネジメントアカウントかどうかを判定
$user_id = $_POST['user_id'];

$stmt = $db->prepare('SELECT name, status from users where id = :id');
$stmt->bindValue(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(pdo::FETCH_ASSOC);

if($user['status'] != 1) {
  echo "この画面は管理者専用なので表示できません";
	exit ;
}

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
    <a href="./user_registration.php">ユーザー登録</a>
    <a href="./event_registration.php">イベント登録</a>
    <a href="./event_list.php">イベント一覧</a>
    <a href="./event_edit.php">イベント編集</a>
  </nav>
  
</body>
</html>