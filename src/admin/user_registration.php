<?php
session_start();
require('../dbconnect.php');

if (isset($_SESSION['user_id']) && $_SESSION['time'] + 60 * 60 * 24 > time()) {
  // SESSIONにuser_idカラムが設定されていて、SESSIONに登録されている時間から1日以内なら
  $_SESSION['time'] = time();
  // SESSIONの時間を現在時刻に更新
  $login = $_SESSION['login'];  //ログイン情報を保持
} else {
  // そうじゃないならログイン画面に飛んでね
  header('Location: ../auth/login');
  exit();
}

if (!empty($_POST['name'])) {
  try {
    $stmt = $db->prepare('INSERT INTO users (name, email, password, slack_id, status) VALUES (:name, :email, :password, :slack_id, :status)');
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $slack_id = $_POST['slack_id'];
    $radio = $_POST['status'];
    if (isset($radio)) {
      $status = 1;
    } else {
      $status = 0;
    }
    $param = array(
      ':name' => $name,
      ':email' => $email,
      ':password' => $password,
      ':slack_id' => $slack_id,
      ':status' => $status,
    );
    $stmt->execute($param);
  } catch (PDOException $e) {
    echo 'データベースにアクセスできません！' . $e->getMessage();
  }


  try {
    $stmt = $db->prepare('SELECT MAX(id) FROM users');
    $stmt->execute();
    $new_user = $stmt->fetch(pdo::FETCH_ASSOC);

    // echo $new_user['MAX(id)'];

    $stmt = $db->prepare('SELECT id, name FROM events');
    $stmt->execute();
    $events = $stmt->fetchAll(pdo::FETCH_ASSOC);

    foreach ($events as $index => $event) {
      $stmt = $db->prepare('INSERT INTO event_attendance (event_id, user_id) VALUES (:event_id, :user_id)');
      $user_id = $new_user['MAX(id)'];
      $event_id = $event['id'];
      $param = array(
        ':event_id' => $event_id,
        ':user_id' => $user_id,
      );
      $stmt->execute($param);
    }
  } catch (PDOException $e) {
    echo 'データベースにアクセスできません！' . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録</title>
</head>

<body>
  <main>
    <div>
      <h1>ユーザー新規登録</h1>
    </div>
    <form action="./user_registration.php" method="post">
      <div>
        <p>ユーザーネーム<br><input type="text" name="name"></p>
      </div>
      <div>
        <p>ログインID（e-mail）<br><input type="email" name="email"></p>
      </div>
      <div>
        <p>パスワード<br><input type="text" name="password"></p>
      </div>
      <div>
        <p>SlackのユーザーID<br><input type="text" name="slack_id"></p>
      </div>
      <div>
        <p>管理者はチェックを入れてください<br><input type="radio" name="status"></p>
      </div>
      <div>
        <button type="submit" name="button">登録する</button>
      </div>
    </form>
  </main>
</body>

</html>