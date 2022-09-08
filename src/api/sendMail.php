<?php
require('../dbconnect.php');
  try {
    $stmt = $db->prepare('SELECT id, name, start_at, end_at, event_detail from events');
    $stmt->execute();
    $events = $stmt->fetchAll(pdo::FETCH_ASSOC);
    // print_r($events);

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
        $stmt = $db->prepare('SELECT users.name, users.email, event_attendance.status FROM event_attendance left join users on event_attendance.user_id = users.id right join events on event_attendance.event_id = events.id where events.id = :event_id');
        $stmt->bindValue(':event_id', $array['id']);
        // 特定のイベントに対して、ユーザーを取得している
        $stmt->execute();
        // ゲットしてきたイベントIDを指定
        $participants = $stmt->fetchAll(pdo::FETCH_ASSOC);
        // データの取得 

        foreach ($participants as $index => $participant) {
          // 【メール送信】
          mb_language('ja');
          mb_internal_encoding('UTF-8');

          $to = $participant['email'];
          $subject = "イベントリマインド";
          $body = "本文";
          $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];

          $name = $participant['name'];
          $date = $event_date;
          $event = $array['name'];
          $event_detail = $array['event_detail'];
          $body = <<<EOT
          {$name}さん
          ${date}に${event}を開催します。
          説明：${event_detail}
          参加／不参加の回答をお願いします。
          http://localhost/
        EOT;

          mb_send_mail($to, $subject, $body, $headers);
          echo "全メンバーに3日前リマインドメールを送信しました";
        }
      }
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }

  try {
    $stmt = $db->prepare('SELECT id, name, start_at, end_at, event_detail from events');
    $stmt->execute();
    $events = $stmt->fetchAll(pdo::FETCH_ASSOC);
    // print_r($events);

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
      
      $three_days_after = date("Y-m-d", strtotime("+1 day"));
      if ($event_date == $three_days_after) {
        $stmt = $db->prepare('SELECT users.name, users.email, event_attendance.status FROM event_attendance left join users on event_attendance.user_id = users.id right join events on event_attendance.event_id = events.id where events.id = :event_id');
        $stmt->bindValue(':event_id', $array['id']);
        // 特定のイベントに対して、ユーザーを取得している
        $stmt->execute();
        // ゲットしてきたイベントIDを指定
        $participants = $stmt->fetchAll(pdo::FETCH_ASSOC);
        // データの取得 

        foreach ($participants as $index => $participant) {
          // 【メール送信】
          mb_language('ja');
          mb_internal_encoding('UTF-8');

          $to = $participant['email'];
          $subject = "イベントリマインド";
          $body = "本文";
          $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];

          $name = $participant['name'];
          $date = $event_date;
          $event = $array['name'];
          $event_detail = $array['event_detail'];
          $body = <<<EOT
          {$name}さん
          ${date}に${event}を開催します。
          説明：${event_detail}
          ついに明日だね！たのしみ！
        EOT;

          mb_send_mail($to, $subject, $body, $headers);
          echo "全メンバーに前日リマインドメールを送信しました";
        }
      }
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }

  