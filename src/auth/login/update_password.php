<?php
require('../../dbconnect.php');

if (isset($_GET['id'])) {
  $id = htmlspecialchars($_GET['id']);
  $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
  $stmt->execute(array($id));
  $applicant = $stmt->fetch(pdo::FETCH_ASSOC);
}

if(isset($_POST['new_password'])) {
  try {
      // 送信された値を取得
      $new_password = sha1($_POST['new_password']);
      $sql = 'UPDATE users SET
      password = :new_password WHERE id = :id';
      $stmt = $db->prepare($sql);
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->bindValue(":new_password",  $new_password, PDO::PARAM_STR);
      $stmt->execute();
      echo '登録されたので再度ログイの願いします' . 'http://localhost/auth/login/';
      exit();
  } catch (PDOException $e) {
      exit('データベースに接続できませんでした。' . $e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規パスワード入力</title>
</head>

<body>
  <h1>新規パスワード登録</h1>
  <form action="./update_password.php?id=1" method="post">
    <p><?php echo $applicant['name'];?>さんが登録したいパスワードを以下に入力してください</p>
    <input name="new_password" type="text">
    <button type="submit">送信</button>
  </form>

</body>

</html>