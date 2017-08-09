<?php
  include "../crud2/database.php";
  echo json_encode(
    Database::prepare(
      'SELECT * FROM `tt_courses`',
       array()
    )->fetchAll(PDO::FETCH_ASSOC)
  );
?>

