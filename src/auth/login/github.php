<?php
define('CLIENT_ID', '1a1e4aa634e0d0d5d3c1');
define('CLIENT_SECRET', 'd02ab540e2fb28a783b6fbc1e77828eeb62ed1ab');

if (empty($_GET['code'])) {
  // Authrize URLの構築
  $params = array(
    'client_id' => CLIENT_ID,
  );
  $authorizeUrl = 'https://github.com/login/oauth/authorize?' . http_build_query($params);
  // header('Location: ' . $authorizeUrl);
} else {
  // アクセストークン取得
  $accessTokenUrl = 'https://github.com/login/oauth/access_token';

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $accessTokenUrl);
  curl_setopt($curl, CURLOPT_POST, 1);
  $params = array(
    'client_id' => CLIENT_ID,
    'client_secret' => CLIENT_SECRET,
    'code' => $_GET['code'],
  );
  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $res = curl_exec($curl);
  curl_close($curl);
  // echo $res;

  $start =  strpos($res, '=');
  $finish =  strpos($res, '&');

  $accessToken = substr($res, $start + 1, ($finish - $start - 1));


  $url = 'https://api.github.com/user?access_token=' . $accessToken;
}
