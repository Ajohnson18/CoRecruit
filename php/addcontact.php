<?php
require("config.php");

$name = $_GET['name'];
$title = $_GET['title'];
$phone = $_GET['phone'];
$email = $_GET['email'];

$uid = $_GET['userid'];
$sql = "SELECT * FROM users WHERE id=$uid";
$res = mysql_query($sql, $dbh);

if($res != FALSE) {
    $user = mysql_fetch_array($res);

    $collegename = $user['college'];
    if($collegename != "") {

        $sql = "SELECT * FROM colleges WHERE name = \"$collegename\"";
        $res = mysql_query($sql, $dbh);

        if($res != FALSE) {
            $college = mysql_fetch_array($res);

            $name = $college['administration'] . "" .$name . "<br>";
            $title = $college['titles'] . $title . "<br>";
            $phone = $college['phone'] . $phone . "<br>";
            $email = $college['email'] . $email . "<br>";

            $sql = "UPDATE colleges SET `administration` = \"$name\", `titles` = \"$title\", `phone` = \"$phone\", `email` = \"$email\" WHERE name = \"$collegename\"";
            $res = mysql_query($sql, $dbh);

            echo 'Success';

        }

    }
}

?>