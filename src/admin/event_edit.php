<?php
require('../dbconnect.php');

if (isset($_GET['id'])) {
  $id = htmlspecialchars($_GET['id']);

  $stmt = $db->prepare('SELECT * FROM events WHERE id = ?');
  $stmt->execute(array($id));
  $event = $stmt->fetchAll(pdo::FETCH_ASSOC);
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
    <form action="./event_edit.php" method="post" class="registration_form">
      <div>
        <p>イベント名<br><input type="text" value="<?php echo $event[0]['name'] ?>"></p>
      </div>
      <div>
        <p>開始時間<br><input type="datetime-local" value="<?php echo $event[0]['start_at'] ?>"></p>
      </div>
      <div>
        <p>終了時間<br><input type="datetime-local" value="<?php echo $event[0]['end_at'] ?>"></p>
      </div>
      <div>
        <p>イベント内容<br><input type="text" value="<?php echo $event[0]['event_detail'] ?>"></p>
      </div>
      <div>
        <input type="submit" value="変更">
      </div>
      </form>


</main>
</body>

</html>