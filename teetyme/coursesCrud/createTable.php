<?php
    include '../database.php';
    $sql = "
        CREATE TABLE `tt_courses` (
            `id`     INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name`   VARCHAR(100) NOT NULL,
            `phone`  VARCHAR(100) NOT NULL,
            `address` VARCHAR(100) NOT NULL
        )";
    Database::prepare($sql, array());
    echo "Persons Table Created";
?>