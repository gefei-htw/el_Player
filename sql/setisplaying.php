<?php

include_once 'dbconfig.php';

$idv = $_POST['currentsongid'];

$sqll = " UPDATE tbl_uploads SET isplaying ='yes' WHERE id='$idv'";
$sql2 = " UPDATE tbl_uploads SET isplaying ='no' WHERE id!='$idv'";

mysql_query($sqll);
mysql_query($sql2);


if ('currentsongid' == -1) {
    $sql = "UPDATE tbl_uploads SET isplaying ='no'";
    mysql_query($sql);
}
?>