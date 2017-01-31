<?php

include_once 'dbconfig.php';


$idv = $_POST['currentsongid'];
$flag = $_POST['value'];

$sql = " UPDATE tbl_uploads SET reset ='0' WHERE id='$idv'";

mysql_query($sql);

?>