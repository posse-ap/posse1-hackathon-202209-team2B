<?php

require('../dbconnect.php');

$stmt = $db->prepare('SELECT events.name, events.start_at, users.name 
FROM event_attendance 
left join users on event_attendance.user_id = users.id 
right join events on event_attendance.event_id = events.id 
where status = 0 order by events.name');

$stmt->execute();
$not_answers = $stmt->fetchAll(pdo::FETCH_ASSOC);

print_r($not_answers);

