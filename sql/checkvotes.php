<?php

include_once 'dbconfig.php';

$id = $_GET['currentsongid'];

$sql = "SELECT upvotes-downvotes FROM tbl_uploads where id='$id'";
$result = mysql_query($sql);
$value = mysql_fetch_object($result);
$votes = $value->{'upvotes-downvotes'};

$sql2 = "SELECT id FROM tbl_uploads where id='$id'";
$result2 = mysql_query($sql2);
$value2 = mysql_fetch_object($result2);
$idv = $value2->{'id'};


$sql3 = "SELECT totalupvotes FROM tbl_uploads where id='$id'";
$result3 = mysql_query($sql3);
$value3 = mysql_fetch_object($result3);
$tu = $value3->{'totalupvotes'};

$sql4 = "SELECT totaldownvotes FROM tbl_uploads where id='$id'";
$result4 = mysql_query($sql4);
$value4 = mysql_fetch_object($result4);
$td = $value4->{'totaldownvotes'};

$values = array();
$values['vote'] = $votes;
$values['id'] = $idv;
$values['tu'] = $tu;
$values['td'] = $td;

print json_encode( $values );



?>