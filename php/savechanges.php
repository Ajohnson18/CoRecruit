<?php

    require("config.php");
    require("safe.php");

    $postBody = file_get_contents("php://input");
    $postBody = json_decode($postBody);

    $value = $postBody->change;

    $userid = $_GET['userid'];
    $index = $_GET['index'];

    $value = safe($value);

    $sql = "UPDATE users SET $index = '$value' WHERE id=$userid";
    $res = mysql_query($sql,$dbh);

?>