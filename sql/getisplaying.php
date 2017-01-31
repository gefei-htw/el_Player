<?php

include_once 'dbconfig.php';


$sql = " SELECT id from tbl_uploads WHERE isplaying = 'yes' ";
$result = mysql_query($sql);
$value = mysql_fetch_object($result);
$id = $value->id;

if (!$id) {
    $value->id = -1;
}

echo $value->id;
?>