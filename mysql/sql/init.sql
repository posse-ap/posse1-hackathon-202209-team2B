DROP SCHEMA IF EXISTS posse;
CREATE SCHEMA posse;
USE posse;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(10) NOT NULL,
  email  VARCHAR(16) COLLATE utf8_bin,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

DROP TABLE IF EXISTS events;
CREATE TABLE events (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(10) NOT NULL,
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
  status INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);


INSERT INTO users SET name='石川朝香', email='asaka@posse.com', password=SHA("eddy");
INSERT INTO users SET name='尾関なな海', email='nanami@posse.com', password=SHA("minn");


INSERT INTO events SET name='縦モク', start_at='2022/09/12 21:00', end_at='2022/09/10 23:00', event_detail='いっしょに学ぼう';
INSERT INTO events SET name='横モク', start_at='2022/09/09 21:00', end_at='2022/09/09 21:00', event_detail='いっしょに開発しよう';
INSERT INTO events SET name='スペモク', start_at='2022/09/10 20:00', end_at='2022/09/10 20:00', event_detail='Mentorさんと学ぼう';
INSERT INTO events SET name='縦モク', start_at='2021/08/08 21:00', end_at='2021/08/08 23:00', event_detail='先輩に聞こう';
INSERT INTO events SET name='横モク', start_at='2021/08/09 21:00', end_at='2021/08/09 23:00', event_detail='課題進めよう';
INSERT INTO events SET name='スペモク', start_at='2021/08/10 20:00', end_at='2021/08/10 22:00', event_detail='スーさんとお友達になろう';
INSERT INTO events SET name='縦モク', start_at='2021/08/15 21:00', end_at='2021/08/15 23:00', event_detail='先輩と仲良くなろう';
INSERT INTO events SET name='横モク', start_at='2021/08/16 21:00', end_at='2021/08/16 23:00', event_detail='N予備見よう';
INSERT INTO events SET name='スペモク', start_at='2021/08/17 20:00', end_at='2021/08/17 22:00', event_detail='遅れちゃだめだよ';
INSERT INTO events SET name='縦モク', start_at='2021/08/22 21:00', end_at='2021/08/22 23:00', event_detail='質問用意してきてね';
INSERT INTO events SET name='横モク', start_at='2021/08/23 21:00', end_at='2021/08/23 23:00', event_detail='課題をたくさんやろう';
INSERT INTO events SET name='スペモク', start_at='2021/08/24 20:00', end_at='2021/08/24 22:00', event_detail='毎週火曜日だよ';
INSERT INTO events SET name='遊び', start_at='2021/09/22 18:00', end_at='2021/09/22 22:00', event_detail='釣り行く？笑';
INSERT INTO events SET name='ハッカソン', start_at='2021/09/03 10:00', end_at='2021/09/03 22:00', event_detail='優勝する！';
INSERT INTO events SET name='遊び', start_at='2021/09/06 18:00', end_at='2021/09/06 22:00', event_detail='中華街行く？笑';


INSERT INTO event_attendance SET event_id=1, user_id=1, status=1;
INSERT INTO event_attendance SET event_id=1, user_id=2, status=2;
INSERT INTO event_attendance SET event_id=4, user_id=1, status=1;
INSERT INTO event_attendance SET event_id=2, user_id=1, status=0;
INSERT INTO event_attendance SET event_id=3, user_id=2, status=0;
INSERT INTO event_attendance SET event_id=2, user_id=2, status=0;
INSERT INTO event_attendance SET event_id=2, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=3, user_id=1, status=0;
INSERT INTO event_attendance SET event_id=3, user_id=2, status=0;
