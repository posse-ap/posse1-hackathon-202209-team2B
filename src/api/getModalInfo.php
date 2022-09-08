<?php
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');

if (isset($_GET['eventId']) && isset($_GET['userId'])) {
  $eventId = htmlspecialchars($_GET['eventId']);
  $userId = htmlspecialchars($_GET['userId']);
  try {
    $stmt = $db->prepare('SELECT events.id, events.name, events.start_at, events.end_at, event_attendance.status FROM event_attendance LEFT JOIN users ON event_attendance.user_id=users.id RIGHT JOIN events ON event_attendance.event_id=events.id WHERE users.id = ? and events.id = ?');
    $stmt->bindValue(1, $userId);
    $stmt->bindValue(2, $eventId);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt_sum = $db->prepare('SELECT count(*) as count from event_attendance left join users on event_attendance.user_id = users.id where event_attendance.event_id = :event_id AND event_attendance.status=1');
    $stmt_sum->bindValue(':event_id', $eventId);
    $stmt_sum->execute();
    $event_sum = $stmt_sum->fetch(PDO::FETCH_ASSOC);

    
    $stmt_member = $db->prepare('SELECT users.name as name, event_attendance.event_id, event_attendance.status from event_attendance left join users on event_attendance.user_id = users.id where event_attendance.event_id = :event_id AND event_attendance.status = 1');
    $stmt_member->bindValue(':event_id', $eventId);
    $stmt_member->execute();
    $event_member = $stmt_member->fetchAll(PDO::FETCH_ASSOC);
    $join = [];
    foreach ($event_member as $member) {
      array_push($join, $member['name']);
    }


    

    
    $start_date = strtotime($event['start_at']);
    $end_date = strtotime($event['end_at']);
    // 日時を表記用の形に変更している

    $eventMessage = date("Y年m月d日", $start_date) . '（' . get_day_of_week(date("w", $start_date)) . '） ' . date("H:i", $start_date) . '~' . date("H:i", $end_date) . 'に' . $event['name'] . 'を開催します。<br>ぜひ参加してください。';
    // メッセージ内容の指定
    
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
      'sum' => $event_sum['count'],
      'member' => $join,
      'deadline' => date("m月d日", strtotime('-3 day', $end_date)),
      'userId' => $userId,
    ];
    echo json_encode($array, JSON_UNESCAPED_UNICODE);
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }
}

function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}
