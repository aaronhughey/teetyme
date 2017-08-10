<?php
  include "../crud2/database.php";
  
  if(isset($_GET['id'])){
	  
	echo json_encode(
		Database::prepare(
			'SELECT * FROM `tt_courses` WHERE id=' . $_GET['id'],
			array()
		)->fetchAll(PDO::FETCH_ASSOC)
	);
  }
  else
	echo json_encode(
		Database::prepare(
			'SELECT * FROM `tt_courses`',
			array()
		)->fetchAll(PDO::FETCH_ASSOC)
	);	  
?>

