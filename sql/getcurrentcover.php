<?php

include_once 'dbconfig.php';

$sql = " SELECT ccover from state WHERE ID='0'";
$result = mysql_query($sql);
$value = mysql_fetch_object($result);
$id = $value->ccover;

if (!$id) {
    $value->ccover = -1;
}


echo $value->ccover;
?>