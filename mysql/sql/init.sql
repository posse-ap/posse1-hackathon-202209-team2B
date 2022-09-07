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

INSERT INTO events SET name='縦モク', start_at='2021/08/01 21:00', end_at='2021/08/01 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/02 21:00', end_at='2021/08/02 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/03 20:00', end_at='2021/08/03 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/08 21:00', end_at='2021/08/08 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/09 21:00', end_at='2021/08/09 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/10
 20:00', end_at='2021/08/10 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/15 21:00', end_at='2021/08/15 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/16 21:00', end_at='2021/08/16 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/17 20:00', end_at='2021/08/17 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/22 21:00', end_at='2021/08/22 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/23 21:00', end_at='2021/08/23 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/24 20:00', end_at='2021/08/24 22:00';
INSERT INTO events SET name='遊び', start_at='2022/10/22 18:00', end_at='2022/10/22 22:00';
INSERT INTO events SET name='ハッカソン', start_at='2022/09/13 10:00', end_at='2022/09/13 22:00';
INSERT INTO events SET name='遊び', start_at='2022/09/09 18:20', end_at='2022/09/09 23:12';

INSERT INTO event_attendance SET event_id=1, user_id=1, status=1;
INSERT INTO event_attendance SET event_id=1, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=1, user_id=3, status=2;
INSERT INTO event_attendance SET event_id=2, user_id=1, status=2;
INSERT INTO event_attendance SET event_id=2, user_id=2, status=1;
INSERT INTO event_attendance SET event_id=2, user_id=3, status=2;