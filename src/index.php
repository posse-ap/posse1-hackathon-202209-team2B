<?php
require('dbconnect.php');


session_start();
if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 10)) {
  session_unset();
  session_destroy();
  header("location: auth/login");
}
$_SESSION['start'] = time();

// $stmt = $db->query('SELECT events.id, events.name, events.start_at, events.end_at, count(event_attendance.id) AS total_participants FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id where end_at >= now()  GROUP BY events.id');
// $stmt = $db->query('SELECT events.id, events.name, events.start_at, events.end_at, status FROM event_attendance LEFT JOIN users ON event_attendance.user_id=users.id RIGHT JOIN events ON event_attendance.event_id=events.id WHERE users.id = ?');
// $events = $stmt->fetchAll();


function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>Schedule | POSSE</title>
</head>

<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="img/header-logo.png" alt="" class="h-full">
      </div>
      <div>
        <form action="./admin/index.php" method="POST">
          <button type="submit" value="<?php echo $_SESSION["id"]; ?>" name="user_id" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">管理者画面</button>
        </form>
      </div>
    </div>
  </header>

  <main class="bg-gray-100">
    <div class="w-full mx-auto p-5">

      <div id="filter" class="mb-8">
        <h2 class="text-sm font-bold mb-3">フィルター</h2>
        <div class="flex">
          <form action="" method="post">
            <!-- <a href="" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-blue-600 text-white">全て</a> -->
            <input type="submit" value="全て" name="all" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-blue-600 text-white">
            <!-- <a href="" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">参加</a> -->
            <input type="submit" value="参加" name="entry" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">
            <!-- <a href="" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">不参加</a> -->
            <input type="submit" value="不参加" name="not_entry" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">
            <!-- <a href="" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">未回答</a> -->
            <input type="submit" value="未回答" name="unanswered" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">
        </div>
        </form>
      </div>

      <div id="events-list">
        <div class="flex justify-between items-center mb-3">
          <h2 class="text-sm font-bold">一覧</h2>
        </div>
        <?php



        // とりあえず１０ではなく２にしておく
        define('MAX', '10');

        // $count = $db->prepare('select count(id) as count from event_attendance where user_id = 1 AND status=1');
        $count = $db->prepare('select count(user_id) as count from event_attendance where user_id= :user_id');
        $user_id = $_SESSION["id"];
        // print_r($user_id);
        $count->bindValue(':user_id', $user_id);
        $count->execute();
        // print_r($count);
        // fetchallとfetchの違い
        $total_count = $count->fetch(PDO::FETCH_ASSOC);
        // print_r($total_count);
        // print_r($total_count['count']);

        $pages = ceil($total_count['count'] / MAX);
        // print_r($pages);


        if (!isset($_GET['page_id'])) {
          $now = 1;
        } else {
          $now = $_GET['page_id'];
        }
        // ページングのselect
        $stmt = $db->prepare('SELECT events.id, events.name, events.start_at, events.end_at, users.id, event_attendance.status FROM event_attendance LEFT JOIN users ON event_attendance.user_id=users.id RIGHT JOIN events ON event_attendance.event_id=events.id WHERE users.id = :user_id ORDER BY events.start_at ASC LIMIT :start, :max');

        $user_id = $_SESSION["id"];
        $stmt->bindValue(':user_id', $user_id);
        if ($now == 1) {
          $stmt->bindValue(":start", $now - 1, PDO::PARAM_INT);
          $stmt->bindValue(":max", MAX, PDO::PARAM_INT);
        } else {
          $stmt->bindValue(":start", ($now - 1) * MAX, PDO::PARAM_INT);
          $stmt->bindValue(":max", MAX, PDO::PARAM_INT);
        }
        $stmt->execute();
        $events = $stmt->fetchAll();
        // print_r($events);




        if (isset($_POST["all"])) {

          // 全てを押した場合のselect分（人だけで絞る）
          $stmt = $db->prepare('SELECT events.id, events.name, events.start_at, events.end_at, users.id, event_attendance.status FROM event_attendance LEFT JOIN users ON event_attendance.user_id=users.id RIGHT JOIN events ON event_attendance.event_id=events.id WHERE users.id = :user_id ORDER BY events.start_at ASC LIMIT :start, :max');

          $user_id = $_SESSION["id"];
          $stmt->bindValue(':user_id', $user_id);
          if ($now == 1) {
            $stmt->bindValue(":start", $now - 1, PDO::PARAM_INT);
            $stmt->bindValue(":max", MAX, PDO::PARAM_INT);
          } else {
            $stmt->bindValue(":start", ($now - 1) * MAX, PDO::PARAM_INT);
            $stmt->bindValue(":max", MAX, PDO::PARAM_INT);
          }
          $stmt->execute();
          $events = $stmt->fetchAll();
          // print_r($events);


          // $stmt = $db->prepare('SELECT events.id, events.name, events.start_at, events.end_at, users.id, event_attendance.status FROM event_attendance LEFT JOIN users ON event_attendance.user_id=users.id RIGHT JOIN events ON event_attendance.event_id=events.id WHERE users.id = :user_id ');
          // // $stmt->execute();
          // // $events = $stmt->fetchAll();
          // // print_r($events);
          // $user_id = $_SESSION["id"];
          // // echo "userのID:";
          // // print_r($user_id);
          // $stmt->bindValue(':user_id', $user_id);
          // $stmt->execute();
          // $events = $stmt->fetchAll();
          // $stmt->bindValue(":start", $now - 1, PDO::PARAM_INT);
          // $stmt->bindValue(":max", MAX, PDO::PARAM_INT);

          // if ($now == 1) {
          //   $stmt->bindValue(":start", $now - 1, PDO::PARAM_INT);
          //   $stmt->bindValue(":max", MAX, PDO::PARAM_INT);
          // } else {
          //   $stmt->bindValue(":start", ($now - 1) * MAX, PDO::PARAM_INT);
          //   $stmt->bindValue(":max", MAX, PDO::PARAM_INT);
          // }
        } else {
          // その他のボタンを押したときのselect分（人と参加状況で絞り込み）
          $stmt = $db->prepare('SELECT events.id, events.name, events.start_at, events.end_at, users.id, event_attendance.status FROM event_attendance LEFT JOIN users ON event_attendance.user_id=users.id RIGHT JOIN events ON event_attendance.event_id=events.id WHERE users.id = :user_id AND event_attendance.status = :status ORDER BY events.start_at ASC');

          $user_id = $_SESSION["id"];
          $stmt->bindValue(':user_id', $user_id);
          if (isset($_POST["entry"])) {
            $status = 1;
            $stmt->bindValue(':status', $status);
            $stmt->execute();
            $events = $stmt->fetchAll();
          } elseif (isset($_POST["not_entry"])) {
            $status = 2;
            $stmt->bindValue(':status', $status);
            $stmt->execute();
            $events = $stmt->fetchAll();
          } elseif (isset($_POST["unanswered"])) {
            $status = 0;
            $stmt->bindValue(':status', $status);
            $stmt->execute();
            $events = $stmt->fetchAll();
          } else {
          }
        }


        ?>
        <?php foreach ($events as $event) : ?>
          <?php
          $start_date = strtotime($event['start_at']);
          $end_date = strtotime($event['end_at']);
          $day_of_week = get_day_of_week(date("w", $start_date));
          ?>
          <div class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="<?php echo $event['id']; ?>+<?php echo $_SESSION['id']; ?>">
            <div>
              <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
              <p><?php echo date("Y年m月d日（${day_of_week}）", $start_date); ?></p>
              <p class="text-xs text-gray-600">
                <?php echo date("H:i", $start_date) . "~" . date("H:i", $end_date); ?>
              </p>
            </div>
            <div class="flex flex-col justify-between text-right">
              <div>
                <?php if ($event['status'] == 1) : ?>
          

                  <p class="text-sm font-bold text-green-400">参加</p>
                  
                  <?php elseif ($event['status'] == 2) : ?>
                    
                    <p class="text-sm font-bold text-gray-300">不参加</p>

                <?php elseif ($event['status'] == 0) : ?>

                  <p class="text-sm font-bold text-yellow-400">未回答</p>
                  <p class="text-xs text-yellow-400">期限 <?php echo date("m月d日", strtotime('-3 day', $end_date)); ?></p>

                <?php endif; ?>
              </div>
              <p class="text-sm"><span class="text-xl"><?php echo $event['total_participants']; ?></span>人参加 ></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>

  <?php
  // とりあえず１０ではなく２にしておく
  // define('MAX', '2');

  // $count = $db->prepare('select count(id) as count from event_attendance where user_id = 1 AND status=1');
  // $count = $db->prepare('select count(id) as count from event_attendance ');
  // $count->execute();
  // // fetchallとfetchの違い
  // $total_count = $count->fetch(PDO::FETCH_ASSOC);
  // // print_r($total_count);
  // // print_r($total_count['count']);

  //   $pages = ceil($total_count['count'] / MAX);
  //   // print_r($pages);

  //   if (!isset($_GET['page_id'])) {
  //     $now = 1;
  //   } else {
  //     $now = $_GET['page_id'];
  //   }




  ?>

  <div>
    <?php


    for ($n = 1; $n <= $pages; $n++) {
      if ($n == $now) {
        echo "<span style='padding: 5px;'>$now</span>";
      } else {
        echo "<a href='./index.php?page_id=$n' style='padding: 5px;'>$n</a>";
      }
    }
    ?>
  </div>



  <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-black opacity-80"></div>

    <div class="modal-container absolute bottom-0 bg-white w-screen h-4/5 rounded-t-3xl shadow-lg z-50">
      <div class="modal-content text-left py-6 pl-10 pr-6">
        <div class="z-50 text-right mb-5">
          <svg class="modal-close cursor-pointer inline bg-gray-100 p-1 rounded-full" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
          </svg>
        </div>

        <div id="modalInner"></div>

      </div>
    </div>
  </div>

  <script src="/js/main.js"></script>
</body>

</html>