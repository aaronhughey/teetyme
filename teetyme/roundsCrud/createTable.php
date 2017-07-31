<?php
    include '../database.php';
    $sql = "
        CREATE TABLE `tt_rounds` (
            `id`     INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `cou_id`   INT NOT NULL,
            `per_id`  INT NOT NULL
        )";
    Database::prepare($sql, array());
    echo "Rounds Table Created";
?>