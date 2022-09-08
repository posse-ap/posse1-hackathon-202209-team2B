<?php
$url = "https://hooks.slack.com/services/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";
$message = [
  "channel" => "はっかそんだあ",
  "text" => "イ"
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