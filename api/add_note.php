<?php
include_once('../connect.php');
$response = [];
if (isset($_POST)) {
  $table = 'notes';
  $cart_id = $_POST['cart_id'];
  $note_title = $_POST['note_title'];
  $note_description = $_POST['note_description'];
  $rows = array(
    'cart_id' => $cart_id,
    'title' => $note_title,
    'description' => $note_description,
  );
  $db->insert($table, $rows);

  $response = [
    'ok' => true,
    'data' => $rows
  ];
}
echo json_encode($response);