<?php
include_once 'dbconfig.php';


$sql = "SELECT * FROM tbl_genre";

$result_set = mysql_query($sql);
?>
<option value="" disabled selected>Genre</option>

<?php
while ($row = mysql_fetch_array($result_set)) {
    ?>
    <option value="<?php echo $row['genre'] ?>"><?php echo $row['genre']; ?></option>


    <?php
}
?>

