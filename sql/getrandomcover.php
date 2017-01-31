<?php

include_once 'dbconfig.php';



$iterator = 0;


$sql1 = " SELECT id from tbl_uploads ORDER BY id DESC LIMIT 1 ";
$result1 = mysql_query($sql1);
$value1 = mysql_fetch_object($result1);
$max = $value1->id;

$sql2 = " SELECT id from tbl_uploads ORDER BY id ASC LIMIT 1 ";
$result2 = mysql_query($sql2);
$value2 = mysql_fetch_object($result2);
$min = $value2->id;

$random = rand($min, $max);

$sql3 = " SELECT cover from tbl_uploads WHERE id='$random' ";
$result3 = mysql_query($sql3);


while ($result3 == NULL) {
    $random = rand($min, $max);
    $sql3 = " SELECT cover from tbl_uploads WHERE id='$random' ";
    $result3 = mysql_query($sql3);

    $iterator = $iterator + 1;

    if ($iterator >= 30) {
        $sql3 = " SELECT cover from tbl_uploads WHERE id='$min' ";
        $result3 = mysql_query($sql3);
    }
}




$value3 = mysql_fetch_object($result3);
//$cover = $value3->cover;

if (!is_object($value3) || $value3 == "") {
    $sql3 = " SELECT cover from tbl_uploads WHERE id='$min' ";
    $result3 = mysql_query($sql3);
    $value3 = mysql_fetch_object($result3);
}


echo $value3->cover;
?>