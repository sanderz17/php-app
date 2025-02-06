<?php
if (!empty($_GET['token']) && isset($_GET['token'])) {
  if ($_GET['token'] == 'eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiQWRtaW4iLCJJc3N1ZXIiOiJJc3N1ZXIiLCJVc2VybmFtZSI6IkphdmFJblVzZSIsImV4cCI6MTcwNTM3MzU2NSwiaWF0IjoxNzA1MzczNTY1fQ.vOuw472m-KM90bSUe4HfuPpJIaEaNRlp8vaiogi7S3w') {
    try {
      $secretsPath = '../config/secrets.json';
      $jsonString = file_get_contents($secretsPath);
      echo $jsonString;
    } catch (\Throwable $th) {
      cb_logger(`Error getting secrets! : $th`);
      throw $th;
    }
  }
} else {
  echo "Bad Request!";
}
