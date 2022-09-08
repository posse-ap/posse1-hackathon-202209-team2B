<?php
require('../dbconnect.php');
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録</title>
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
<header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <h1 class="h-full">ユーザー登録</h1>
      </div>
    </div>
  </header>
  <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
    <input type="email" name="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3">
    <input type="password" name="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3">
    <label class="inline-block mb-6">
      <!-- <input type="checkbox" checked> -->
      <!-- <span class="text-sm">ログイン状態を保持する</span> -->
    </label>
    <input type="submit" value="ログイン" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
  </form>
</body>

</html>