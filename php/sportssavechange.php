<?php

    require("config.php");

    $postBody = file_get_contents("php://input");
    $postBody = json_decode($postBody);

    $value = $postBody->change;

    $sid = $_GET['sid'];
    $index = $_GET['index'];

    $sql = "UPDATE sports SET $index = '$value' WHERE id=$sid";
    $res = mysql_query($sql,$dbh);

?>