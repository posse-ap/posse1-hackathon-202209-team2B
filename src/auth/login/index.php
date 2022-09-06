<?php
require "../../dbconnect.php";

session_start();

// セッション変数 $_SESSION["loggedin"]を確認。ログイン済だったらウェルカムページへリダイレクト
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: index.php");
  exit;
}

//POSTされてきたデータを格納する変数の定義と初期化
$datas = [
  'email'  => '',
  'password'  => ''
];
$login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // POSTされてきたデータを変数に格納
  foreach ($datas as $key => $value) {
    if ($value = filter_input(INPUT_POST, $key, FILTER_DEFAULT)) {
      $datas[$key] = $value;
    }
  }

  //ユーザーネームから該当するユーザー情報を取得
  $sql = "SELECT id,name,password FROM users WHERE email = :email";
  $stmt = $db->prepare($sql);
  $stmt->bindValue('email', $datas['email']);
  $stmt->execute();

  //ユーザー情報があれば変数に格納
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //パスワードがあっているか確認
    if ($datas['password'] === $row['password']) {

      //セッション変数にログイン情報を格納
      $_SESSION["loggedin"] = true;
      $_SESSION["id"] = $row['id'];
      $_SESSION["name"] =  $row['name'];
      header("location: ../../index.php");
      exit();
    } else {
      $login_err = 'Invalid username or password.';
    }
  } else {
    $login_err = 'Invalid username or password.';
  }
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
        <img src="/img/header-logo.png" alt="" class="h-full">
      </div>
    </div>
  </header>

  <main class="bg-gray-100 h-screen">
    <div class="w-full mx-auto py-10 px-5">
      <h2 class="text-md font-bold mb-5">ログイン</h2>

      <?php
      if (!empty($login_err)) {
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
      }
      ?>

      <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
        <input type="email" name="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3">
        <input type="password" name="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3">
        <label class="inline-block mb-6">
          <!-- <input type="checkbox" checked> -->
          <!-- <span class="text-sm">ログイン状態を保持する</span> -->
        </label>
        <input type="submit" value="ログイン" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
      <div class="text-center text-xs text-gray-400 mt-6">
        <a href="/">パスワードを忘れた方はこちら</a>
      </div>
    </div>
  </main>
</body>

</html>