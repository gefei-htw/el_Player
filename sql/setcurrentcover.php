<?php

include_once 'dbconfig.php';

$idv = $_POST['currentcover'];

print_r($idv);

$sqll = " UPDATE state SET ccover = '$idv' WHERE ID='0' ";


mysql_query($sqll);
?>