<?php
require('../dbconnect.php');


  try {
    $stmt = $db->prepare('SELECT id, name, start_at, end_at from events');
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
      ];
      $event_date = substr($event['start_at'], 0, 10);
      $three_days_after = date("Y-m-d", strtotime("+3 day"));
      if ($event_date == $three_days_after) {
        $stmt = $db->prepare('SELECT name, email FROM users');
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
          $body = <<<EOT
          {$name}さん
          ${date}に${event}を開催します。
          参加／不参加の回答をお願いします。
          http://localhost/
        EOT;

          mb_send_mail($to, $subject, $body, $headers);
          echo "メールを送信しました";
        }
      }
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }

// ・全部のイベントに対してやる
