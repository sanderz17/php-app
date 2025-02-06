<?php
include_once('../connect.php');
$response = [];
if (isset($_POST)) {
  $table = 'notes';
  $id = $_POST['id'];
  if ($db->delete($table, "id=$id")) {
    $response = [
      'ok' => true,
      'post' => $_POST
    ];
  } else {
    $response = [
      'ok' => false,
      'post' => $_POST
    ];
  };
}
echo json_encode($response);
