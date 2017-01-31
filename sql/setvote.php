<?php

include_once 'dbconfig.php';

$idv = $_POST['currentsongid'];

$sqll = " UPDATE tbl_uploads SET upvotes ='0' WHERE id='$idv'";
$sql2 = " UPDATE tbl_uploads SET downvotes ='0' WHERE id='$idv'";

mysql_query($sqll);
mysql_query($sql2);
?>