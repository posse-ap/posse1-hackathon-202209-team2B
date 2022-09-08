<?php
require('../dbconnect.php');
try {
  $stmt = $db->prepare('SELECT id, name, start_at, end_at, event_detail from events');
  $stmt->execute();
  $events = $stmt->fetchAll(pdo::FETCH_ASSOC);

  foreach ($events as $index => $event) {
    $array = [
      'id' => $event['id'],
      'name' => $event['name'],
      'date' => date("Y年m月d日", $start_date),
      'start_at' => date("H:i", $start_date),
      'end_at' => date("H:i", $end_date),
      'event_detail' => $event['event_detail'],
    ];

    $event_date = substr($event['start_at'], 0, 10);

    $three_days_after = date("Y-m-d", strtotime("+3 day"));
    if ($event_date == $three_days_after) {
      $stmt = $db->prepare('SELECT users.name, users.email, event_attendance.status FROM event_attendance left join users on event_attendance.user_id = users.id right join events on event_attendance.event_id = events.id where event_attendance.status = 0 AND events.id = :event_id');
      $stmt->bindValue(':event_id', $array['id']);
      $stmt->execute();
      $participants = $stmt->fetchAll(pdo::FETCH_ASSOC); 

      foreach ($participants as $index => $participant) {
        $to = $participant['email'];
        $subject = "イベントリマインド";
        $body = "本文";
        $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];

        $name = $participant['name'];
        $date = $event_date;
        $event = $array['name'];
        $event_detail = $array['event_detail'];
        $slack_id = 'U041JKK755Y';

        $url = "https://hooks.slack.com/services/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";
        $message = [
          "channel" => "はっかそんだあ",
          "text" => "<@${slack_id}>さん
          ${date}に${event}を開催します。
          説明：${event_detail}
          参加／不参加の回答をお願いします。
          http://localhost/"
        ];

        $ch = curl_init();

        $options = [
          CURLOPT_URL => $url,
          // 返り値を文字列で返す
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYPEER => false,
          // POST
          CURLOPT_POST => true,
          CURLOPT_POSTFIELDS => http_build_query([
            'payload' => json_encode($message)
          ])
        ];

        curl_setopt_array($ch, $options);
        curl_exec($ch);

        // echo $ch;
        curl_close($ch);
      }
    }
  }
} catch (PDOException $e) {
  echo $e->getMessage();
  exit();
}
