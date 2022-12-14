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
    $stmt = $db->prepare('INSERT INTO events (name, start_at, end_at, event_detail) VALUES (:name, :start_at, :end_at, :event_detail)');
    $name = $_POST['name'];
    $start_at = $_POST['start_at'];
    $end_at = $_POST['end_at'];
    $event_detail = $_POST['event_detail'];

    $param = array(
      ':name' => $name,
      ':start_at' => $start_at,
      ':end_at' => $end_at,
      ':event_detail' => $event_detail,
    );

    $stmt->execute($param);
  } catch (PDOException $e) {
    echo 'データベースにアクセスできません！' . $e->getMessage();
  }

  try {
    $stmt = $db->prepare('SELECT MAX(id) FROM events');
    $stmt->execute();
    $new_event = $stmt->fetch(pdo::FETCH_ASSOC);

    // echo $new_user['MAX(id)'];

    $stmt = $db->prepare('SELECT id, name FROM users');
    $stmt->execute();
    $users = $stmt->fetchAll(pdo::FETCH_ASSOC);

    foreach ($users as $index => $user) {
      $stmt = $db->prepare('INSERT INTO event_attendance (event_id, user_id) VALUES (:event_id, :user_id)');
      $event_id = $new_event['MAX(id)'];
      $user_id = $user['id'];
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
  <link rel="stylesheet" href="../admin/css/admin.css">
  <title>イベント登録</title>
</head>

<body>
  <header>
    <div class="header_logo">
      <img src="../img/header-logo.png" alt="posseロゴ">
    </div>
    <div class="header_title">
      <!-- 後に変更！！！！！！！！！！！！！！！！！！ -->
      <p><a href="./event_registration.php">イベント登録</a></p>
    </div>
    <div class="header_title">
      <!-- 後に変更！！！！！！！！！！！！！！！！！！ -->
      <p><a href="./event_list.php">イベント一覧</a></p>
    </div>
  </header>
  <main>
    <div>
      <h1>イベント登録</h1>
    </div>
    <form action="./event_registration.php" method="post" class="registration_form">
      <div>
        <p>イベント名<br><input type="text" name="name"></p>
      </div>
      <div>
        <p>開始時間<br><input type="datetime-local" name="start_at"></p>
      </div>
      <div>
        <p>終了時間<br><input type="datetime-local" name="end_at"></p>
      </div>
      <div>
        <p>イベント内容<br><input type="text" name="event_detail"></p>
      </div>
      <div>
        <button type="submit" name="button">登録する</button>
      </div>
    </form>


  </main>
</body>

</html>