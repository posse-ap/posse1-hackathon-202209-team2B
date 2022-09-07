<?php
require('../../dbconnect.php');

$inputted_email = $_POST['inputted_email'];

$stmt = $db->prepare('SELECT name, email FROM users WHERE email = :inputted_email');
$stmt->bindValue(':inputted_email', $inputted_email);
$stmt->execute();
$address = $stmt->fetch(pdo::FETCH_ASSOC);

if(isset($_POST['inputted_email'])) {
  if (!empty($address)) {
    // 【メール送信】
    mb_language('ja');
    mb_internal_encoding('UTF-8');
 
    $to = $address['email'];
    $subject = "パスワードリセット";
    $body = "本文";
    $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];
 
    $name = $address['name'];
    $body = <<<EOT
    {$name}さん
    以下のリンクからパスワードリセットを行ってください。
    http://localhost/auth/login/update_password.php
  EOT;
 
    mb_send_mail($to, $subject, $body, $headers);
   echo 'そのアドレス宛にメールを送信しました';
 
 } else {
   echo 'そのアドレスは未登録です';
 } 

}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>パスワードリセット手続き</title>
</head>

<body>

  <h1>パスワードの再設定</h1>
  <form action="./forget_password.php" method="post">
    <p>登録しているメールアドレスを入力してください</p>
    <input name="inputted_email" type="text">
    <button type="submit">送信</button>
  </form>

</body>

</html>