<?php
include_once 'dbconfig.php';


$sql = "SELECT * FROM tbl_uploads";

$result_set = mysql_query($sql);

while ($row = mysql_fetch_array($result_set)) {
    ?>

    <li song="<?php echo $row['file']; ?>" 
        cover="<?php echo $row['cover']; ?>" 
        artist="<?php echo $row['artist']; ?>"
        id="<?php echo $row['id']; ?>">

    <?php echo $row['artist']; ?> - <?php echo $row['title']; ?></li>




    <?php
}
?>

