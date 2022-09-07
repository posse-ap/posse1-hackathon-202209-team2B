<?php
session_start();

if(!empty($_POST['name'])) {
  try {

    $stmt = $db->prepare(
      'INSERT INTO events
        (name, start_at, end_at)
        VALUES
        (:name, :start_at, :end_at)'
      );
  
    $name = $_POST['name'];
    $start_at = $_POST['start_at'];
    $end_at = $_POST['end_at'];
    
    $param = array(
      ':name' => $name,
      ':start_at' => $start_at,
      ':end_at' => $end_at,
    );
  
    $stmt->execute($param);
  }catch (PDOException $e) {
    echo 'データベースにアクセスできません！'.$e->getMessage();
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
      <p><a href="event_registration.html">イベント登録</a></p>
    </div>
    <!-- <div class="header_title"> -->
    <!-- 後に変更！！！！！！！！！！！！！！！！！！ -->
    <!-- <p><a href="event_registration.html">イベント一覧</a></p>
    </div> -->
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
    <button type="submit" name="button">登録する</button>
    </div>
  </form>


</main>
</body>

</html>