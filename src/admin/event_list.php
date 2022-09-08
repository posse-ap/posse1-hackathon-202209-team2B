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
$stmt = $db->query('SELECT events.id, events.name, events.start_at, events.end_at, count(event_attendance.id) AS total_participants FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id GROUP BY events.id');
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../admin/css/admin.css">
  <title>イベント一覧</title>
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
      <h1>イベント一覧</h1>
    </div>

    <?php foreach ($events as $event) : ?>
      <?php
      $start_date = strtotime($event['start_at']);
      $end_date = strtotime($event['end_at']);
      ?>
      <div class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-<?php echo $event['id']; ?>">
        <div>
          <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
          <p><?php echo date("Y年m月d日", $start_date); ?></p>
          <p class="text-xs text-gray-600">
            <?php echo date("H:i", $start_date) . "~" . date("H:i", $end_date); ?>
          </p>
        </div>
        <div class="flex flex-col justify-between text-right">
        </div>
      </div>
      <form action="./event_edit.php" method="POST" class="each_event_edit">
        <p><a href="./event_edit.php?id=<?php echo $event['id']; ?>">編集</a></p>
      </form>
    <?php endforeach; ?>
    <div class="each_event">
      
    </div>

  </main>
</body>

</html>