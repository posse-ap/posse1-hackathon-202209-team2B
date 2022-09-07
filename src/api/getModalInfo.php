<?php
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');

// if (isset($_GET['eventId'])) {
  $eventId = htmlspecialchars($_GET['eventId']);
  try {
    $stmt = $db->prepare('SELECT events.id, events.name, events.start_at, events.end_at, count(event_attendance.id) AS total_participants FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id WHERE events.id = ? GROUP BY events.id');
    // イベント情報の取得をする時に、参加状況を内部結合して、参加人数を記録している
    // $stmt->execute(array($eventId));
    $stmt->execute(array(1));
    // ゲットしてきたイベントIDを指定
    $event = $stmt->fetch();
    // データの取得
    $start_date = strtotime($event['start_at']);
    $end_date = strtotime($event['end_at']);
    // 日時を表記用の形に変更している

    $eventMessage = date("Y年m月d日", $start_date) . '（' . get_day_of_week(date("w", $start_date)) . '） ' . date("H:i", $start_date) . '~' . date("H:i", $end_date) . 'に' . $event['name'] . 'を開催します。<br>ぜひ参加してください。';
    // メッセージ内容の指定

    if ($event['id'] % 3 === 1) $status = 0;
    elseif ($event['id'] % 3 === 2) $status = 1;
    else $status = 2;
    // イベントIDに3つのステータスをつけているけど、何に使うの？？？？？？？？？？？？？

    $array = [
      'id' => $event['id'],
      'name' => $event['name'],
      'date' => date("Y年m月d日", $start_date),
      'day_of_week' => get_day_of_week(date("w", $start_date)),
      'start_at' => date("H:i", $start_date),
      'end_at' => date("H:i", $end_date),
      'total_participants' => $event['total_participants'],
      'message' => $eventMessage,
      'status' => $status,
      'deadline' => date("m月d日", strtotime('-3 day', $end_date)),
    ];
    echo json_encode($array, JSON_UNESCAPED_UNICODE);
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }
// } else {
//   echo "yo";
// }

function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}

