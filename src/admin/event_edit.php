<?php
require('../dbconnect.php');

if (isset($_GET['id'])) {
  $id = htmlspecialchars($_GET['id']);
  $stmt = $db->prepare('SELECT * FROM events WHERE id = ?');
  $stmt->execute(array($id));
  $event = $stmt->fetchAll(pdo::FETCH_ASSOC);
}

if (isset($_POST['name'])) {
  try {
      $id = $_POST['id'];
      // 送信された値を取得
      $name = $_POST['name'];
      $start_at = str_replace("T", " ", $_POST['start_at']) .":00";
      $end_at = str_replace("T", " ", $_POST['end_at']) .":00";
      $event_detail = $_POST['event_detail'];

      echo $event_detail;

      $sql = 'UPDATE events SET name = :name, start_at = :start_at, end_at = :end_at, event_detail = :event_detail WHERE id = :id';
      $stmt = $db->prepare($sql);
      $stmt->bindValue(":id", $id);

      $stmt->bindValue(":name", $name);
      // 
      $stmt->bindValue(":start_at",  $start_at);
      // 
      $stmt->bindValue(":end_at",  $end_at);
      // 
      $stmt->bindValue(":event_detail",  $event_detail);
      $stmt->execute();

      echo '更新しました';
      exit();
  } catch (PDOException $e) {
      exit('データベースに接続できませんでした。' . $e->getMessage());
  }
}

// if (isset($_POST['name'])) {
//   $db->beginTransaction();
//   $name = $_POST['name'];
//     try {
//       $stmt = $db->prepare('UPDATE events SET name = :name, start_at = :start_at, end_at = :end_at, event_detail = :event_detail WHERE id = :id');
      
//       $id = $event[0]['id'];
//       $name = $_POST['name'];
//       $start_at = $_POST['start_at'];
//       $end_at = $_POST['end_at'];
//       $event_detail = $_POST['event_detail'];

//       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//       $stmt->bindParam(':name', $name, PDO::PARAM_STR);
//       $stmt->bindParam(':start_at', $start_at);
//       $stmt->bindParam(':end_at', $end_at);
//       $stmt->bindParam(':event_detail', $event_detail, PDO::PARAM_STR);

//       $db->commit();
//       echo '更新しました';
//     } catch (PDOException $e) {
//       echo 'データベースにアクセスできません！'.$e->getMessage();
//     }
//   }

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
      <p><a href="./event_registration.php">イベント登録</a></p>
    </div>
    <div class="header_title">
      <p><a href="./event_list.php">イベント一覧</a></p>
    </div>
  </header>
  <main>
    <div>
      <h1>イベント変更</h1>
    </div>
    <form action="./event_edit.php" method="POST" class="registration_form">
      <div>
        <p>イベント名<br><input name="name" type="text" value="<?php echo $event[0]['name'] ?>"></p>
      </div>
      <div>
        <p>開始時間<br><input name="start_at" type="datetime-local" value="<?php echo $event[0]['start_at'] ?>"></p>
      </div>
      <div>
        <p>終了時間<br><input name="end_at" type="datetime-local" value="<?php echo $event[0]['end_at'] ?>"></p>
      </div>
      <div>
        <p>イベント内容<br><input name="event_detail" type="text" value="<?php echo $event[0]['event_detail'] ?>"></p>
      </div>
      <div>
        <button name="update" type="submit">変更</button>
      </div>
      <input name="id" type="hidden" value="<?php echo $event[0]['id'] ?>">
      </form>
</main>
</body>
</html>