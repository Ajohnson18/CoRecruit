<?php

$conf['server'] = 'localhost';
$conf['db'] = 'CoRecruit';
$conf['user'] = 'gayrobin';
$conf['pass'] = 'Hancock10';

//Connect To Server
$dbh = mysql_connect($conf['server'],$conf['user'],$conf['pass']);
if(!$dbh) {
	header("location: index.php?err=2");
}

$db=mysql_select_db($conf['db'],$dbh);
if(!$db) {
	header("location: index.php?err=3");
}

?>