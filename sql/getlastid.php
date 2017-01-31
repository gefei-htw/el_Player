<?php

include_once 'dbconfig.php';

$sql = " SELECT id from tbl_uploads ORDER BY id DESC LIMIT 1 ";
$result = mysql_query($sql);
$value = mysql_fetch_object($result);
$id = $value->id;


echo $value->id;
?>