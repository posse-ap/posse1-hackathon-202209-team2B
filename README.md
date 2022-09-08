# posse1-hackathon-202209-team2B

## ハッカソン202109

### ビルド

ディレクトリに移動して以下のコマンドを実行してください

```bash
docker-compose build --no-cache
docker-compose up -d
```

### 動作確認

ブラウザで `http://localhost` にアクセスして、正しく画面が表示されているか確認してください

➀ログインについて
管理画面から入る場合
メールアドレス：tomo@posse.com
パスワード：umeru
名前：平野隆二

ユーザから入る場合
メールアドレス：asaka@posse.com
パスワード：eddy
名前：石川朝香


➁管理画面からイベント登録
管理画面に入るためには、上記の「管理画面から入る場合」でログインしてください。
ユーザー側から入った場合、管理画面のボタンはありますが、押しても遷移ができません。

ログイン後、右上の「管理者画面」ボタンを押していただき、イベント登録をお選びください。


➂ユーザ画面でイベント参加登録
イベントをクリックして、モーダル画面から参加・不参加をお選びください。

### メール送信サンプルについて

メール送信
ブラウザで `http://localhost/api/sendMailToTarget` にアクセスしてください、テストメールが送信されます

メール受信
ブラウザで `http://localhost:8025/` にアクセスしてください、メールボックスが表示されます
>>>>>>> 0ce17117fe90986b8b1a8987257f8f08f8140379
# slack-test
