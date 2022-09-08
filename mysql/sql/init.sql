DROP SCHEMA IF EXISTS posse;
CREATE SCHEMA posse;
USE posse;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(10) NOT NULL,
  email  VARCHAR(255) COLLATE utf8_bin,
  password VARCHAR(255) NOT NULL,
  status TINYINT(1) NOT NULL DEFAULT '0',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

DROP TABLE IF EXISTS events;
CREATE TABLE events (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  start_at DATETIME,
  end_at DATETIME,
  event_detail VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

DROP TABLE IF EXISTS event_attendance;
CREATE TABLE event_attendance (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  event_id INT NOT NULL,
  user_id INT NOT NULL,
  status INT NOT NULL DEFAULT '0',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

INSERT INTO users SET name='石川朝香', email='asaka@posse.com', password=SHA("eddy");
INSERT INTO users SET name='尾関なな海', email='nanami@posse.com', password=SHA("minn");
INSERT INTO users SET name='ゆやまともはる', email='tomo@posse.com', password=SHA("umeru"), status=1;

INSERT INTO events SET name='縦モク', start_at='2022/09/12 21:00', end_at='2022/09/10 23:00', event_detail='いっしょに学ぼう';
INSERT INTO events SET name='横モク', start_at='2022/09/09 21:00', end_at='2022/09/09 21:00', event_detail='いっしょに開発しよう';
INSERT INTO events SET name='スペモク', start_at='2022/09/08 20:00', end_at='2022/09/08 20:00', event_detail='Mentorさんと学ぼう';
INSERT INTO events SET name='かださぽ', start_at='2022/10/08 21:00', end_at='2022/10/08 23:00', event_detail='先輩に聞こう';
INSERT INTO events SET name='もっぎそん', start_at='2023/08/09 21:00', end_at='2023/08/09 23:00', event_detail='課題進めよう';
INSERT INTO events SET name='新人ハッカソン', start_at='2021/08/10 20:00', end_at='2021/08/10 22:00', event_detail='スーさんとお友達になろう';
INSERT INTO events SET name='ハッカソンフェス', start_at='2021/08/15 21:00', end_at='2021/08/15 23:00', event_detail='先輩と仲良くなろう';
INSERT INTO events SET name='チーム開発', start_at='2021/08/16 21:00', end_at='2021/08/16 23:00', event_detail='N予備見よう';
INSERT INTO events SET name='入学式', start_at='2021/08/17 20:00', end_at='2021/08/17 22:00', event_detail='遅れちゃだめだよ';
INSERT INTO events SET name='web-appトーナメント決勝', start_at='2021/08/22 21:00', end_at='2021/08/22 23:00', event_detail='質問用意してきてね';
INSERT INTO events SET name='はばず泊まろう', start_at='2021/08/23 21:00', end_at='2021/08/23 23:00', event_detail='課題をたくさんやろう';
INSERT INTO events SET name='養成養成', start_at='2021/08/24 20:00', end_at='2021/08/24 22:00', event_detail='毎週火曜日だよ';
INSERT INTO events SET name='MU', start_at='2021/09/22 18:00', end_at='2021/09/22 22:00', event_detail='釣り行く？笑';
INSERT INTO events SET name='ハッカソン', start_at='2021/09/03 10:00', end_at='2021/09/03 22:00', event_detail='優勝する！';
INSERT INTO events SET name='遊び', start_at='2021/09/06 18:00', end_at='2021/09/06 22:00', event_detail='中華街行く？笑';
INSERT INTO events SET name='裁判傍聴', start_at='2022/09/09 18:00', end_at='2022/09/09 22:00', event_detail='松本の願い';
INSERT INTO events SET name='サバリディズニー', start_at='2022/09/10 18:00', end_at='2022/09/10 22:00', event_detail='老若合同激アツ！';
INSERT INTO events SET name='残9スノボ', start_at='2022/09/11 18:00', end_at='2022/09/11 22:00', event_detail='参加必須だよ。';
INSERT INTO events SET name='釣り', start_at='2022/09/12 18:00', end_at='2022/09/12 22:00', event_detail='お店ちゃんとやってるか確認して';
INSERT INTO events SET name='めしもく', start_at='2022/09/13 18:00', end_at='2022/09/13 22:00', event_detail='復活！！！！';
INSERT INTO events SET name='巻き返し合宿', start_at='2022/09/14 18:00', end_at='2022/09/14 22:00', event_detail='留年阻止！';
INSERT INTO events SET name='フェーズ末試験', start_at='2022/09/15 18:00', end_at='2022/09/15 22:00', event_detail='みんな勉強してる？？';
INSERT INTO events SET name='成績開示', start_at='2022/09/16 18:00', end_at='2022/09/16 22:00', event_detail='激震必至';
INSERT INTO events SET name='ボルダリング', start_at='2022/09/17 18:00', end_at='2022/09/17 22:00', event_detail='筋トレしましょう';
INSERT INTO events SET name='もみじがり', start_at='2022/09/18 18:00', end_at='2022/09/18 22:00', event_detail='もうすぐ秋！ワクワク！';
INSERT INTO events SET name='イルミネーション', start_at='2022/09/19 18:00', end_at='2022/09/19 22:00', event_detail='中華街行く？笑';
INSERT INTO events SET name='英会話練習', start_at='2022/09/20 18:00', end_at='2022/09/20 22:00', event_detail='まなきの発音矯正会';
INSERT INTO events SET name='雨乞い', start_at='2022/09/21 18:00', end_at='2022/09/21 22:00', event_detail='石川朝香参加必須';
INSERT INTO events SET name='富士急', start_at='2022/09/22 18:00', end_at='2022/09/22 22:00', event_detail='絶望要塞いきたい';
INSERT INTO events SET name='アルティメット', start_at='2022/09/23 18:00', end_at='2022/09/23 22:00', event_detail='河川敷に6:00集合';
INSERT INTO events SET name='冬のDX', start_at='2022/09/24 18:00', end_at='2022/09/24 22:00', event_detail='彼女ができたら、ちょっと行けるか分からないです';
INSERT INTO events SET name='初日の出', start_at='2022/09/25 18:00', end_at='2022/09/25 22:00', event_detail='ゆくとしくるとし！';

INSERT INTO event_attendance SET event_id=1, user_id=1, status=1;
INSERT INTO event_attendance SET event_id=1, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=1, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=2, user_id=1, status=2;
INSERT INTO event_attendance SET event_id=2, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=2, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=3, user_id=1, status=2;
INSERT INTO event_attendance SET event_id=3, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=3, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=4, user_id=1, status=1;
INSERT INTO event_attendance SET event_id=4, user_id=2, status=0;
INSERT INTO event_attendance SET event_id=4, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=5, user_id=1, status=2;
INSERT INTO event_attendance SET event_id=5, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=5, user_id=3, status=0;
INSERT INTO event_attendance SET event_id=6, user_id=1, status=1;
INSERT INTO event_attendance SET event_id=6, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=6, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=7, user_id=1, status=0;
INSERT INTO event_attendance SET event_id=7, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=7, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=8, user_id=1, status=0;
INSERT INTO event_attendance SET event_id=8, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=8, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=9, user_id=1, status=1;
INSERT INTO event_attendance SET event_id=9, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=9, user_id=3, status=0;
INSERT INTO event_attendance SET event_id=10, user_id=1, status=1;
INSERT INTO event_attendance SET event_id=10, user_id=2, status=2;
INSERT INTO event_attendance SET event_id=10, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=11, user_id=1, status=2;
INSERT INTO event_attendance SET event_id=11, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=11, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=12, user_id=1, status=2;
INSERT INTO event_attendance SET event_id=12, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=12, user_id=3, status=1;
INSERT INTO event_attendance SET event_id=13, user_id=1, status=1;
INSERT INTO event_attendance SET event_id=13, user_id=2, status=2;
INSERT INTO event_attendance SET event_id=13, user_id=3, status=1;
INSERT INTO event_attendance SET event_id=14, user_id=1, status=0;
INSERT INTO event_attendance SET event_id=14, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=14, user_id=3, status=1;
INSERT INTO event_attendance SET event_id=15, user_id=1, status=0;
INSERT INTO event_attendance SET event_id=15, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=15, user_id=3, status=0;

