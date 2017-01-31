<?php

include_once 'dbconfig.php';

//$sql = " SELECT id FROM tbl_uploads WHERE (upvotes-downvotes) = (SELECT MAX(upvotes-downvotes) FROM tbl_uploads) ORDER by (upvotes-downvotes) DESC LIMIT 1 ";
$sql = "SELECT * FROM tbl_uploads";
$result = mysql_query($sql);
//$value = mysql_fetch_object($result);
//$id = $value->id;


$temp = PHP_INT_MAX*-1;
$idvalue = 1;
while($row = mysql_fetch_assoc($result))
{
    $playing = $row['isplaying'] == "yes";
    $reset = $row['reset'] == 1;
    if(!$playing){
        $upvalue = $row['upvotes'];
        $downvalue = $row['downvotes'];
        $sumvalue = $upvalue - $downvalue;  
        if($temp<$sumvalue && $reset){
            $idvalue = $row['id'];
            $temp = $sumvalue;
        }
    }
}       
if(  $idvalue != -1 ){
    $id = $idvalue;
} else {
   //database emtpy
    //only one track
    //etc...
}



$sql2 = " SELECT upvotes from tbl_uploads WHERE id='$id' ";
$result2 = mysql_query($sql2);
$value2 = mysql_fetch_object($result2);
$upvotes = $value2->upvotes;


$sql3 = " select count(distinct upvotes) FROM tbl_uploads";
$result3 = mysql_query($sql3);
$value3 = mysql_fetch_object($result3);
$distupvotes = $value3->{'count(distinct upvotes)'};


$sql4 = " select count(distinct downvotes) FROM tbl_uploads ";
$result4 = mysql_query($sql4);
$value4 = mysql_fetch_object($result4);
$distdownvotes = $value4->{'count(distinct downvotes)'};

if ($distupvotes == 1 && $distdownvotes == 1) {
    $idvalue = -1;
}

echo $idvalue;
?>