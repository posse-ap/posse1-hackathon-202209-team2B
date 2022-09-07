<?php
require('../dbconnect.php');

header('Content-Type: application/json; charset=UTF-8');

$eventId = $_POST['eventId'];
$userId = $_POST['userId'];
$status = $_POST['status'];

if (isset($eventId)) {
  $sql = "UPDATE event_attendance SET status = :status WHERE event_id = :event_id and user_id = :user_id";
  if ($stmt = $db->prepare($sql)) {
    $stmt->execute(array(':status' => $status, ':event_id' => $eventId, ':user_id' => $userId));
  }
}
