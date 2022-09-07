<?php
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');


if (isset($_GET['eventId']) && isset($_GET['userId'])) {
  $eventId = htmlspecialchars($_GET['eventId']);
  $userId = htmlspecialchars($_GET['userId']);
  try {
    $stmt = $db->prepare('SELECT events.id, events.name, events.start_at, events.end_at, status FROM event_attendance LEFT JOIN users ON event_attendance.user_id=users.id RIGHT JOIN events ON event_attendance.event_id=events.id WHERE users.id = ? and events.id = ?');
    $stmt->bindValue(1, $userId);
    $stmt->bindValue(2, $eventId);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $start_date = strtotime($event['start_at']);
    $end_date = strtotime($event['end_at']);

    $eventMessage = date("Y年m月d日", $start_date) . '（' . get_day_of_week(date("w", $start_date)) . '） ' . date("H:i", $start_date) . '~' . date("H:i", $end_date) . 'に' . $event['name'] . 'を開催します。<br>ぜひ参加してください。';

    $array = [
      'id' => $event['id'],
      'name' => $event['name'],
      'date' => date("Y年m月d日", $start_date),
      'day_of_week' => get_day_of_week(date("w", $start_date)),
      'start_at' => date("H:i", $start_date),
      'end_at' => date("H:i", $end_date),
      'total_participants' => $event['total_participants'],
      'message' => $eventMessage,
      'status' => $event['status'],
      'deadline' => date("m月d日", strtotime('-3 day', $end_date)),
      'userId' => $userId,
    ];
    
    echo json_encode($array, JSON_UNESCAPED_UNICODE);
  } catch(PDOException $e) {
    echo $e->getMessage();
    exit();
  }
}

function get_day_of_week ($w) {
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}