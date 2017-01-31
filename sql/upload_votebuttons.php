<?php
include_once 'dbconfig.php';
$voted = [];

if (isset($_POST['hasvoted'])) {
    $voted = $_POST['hasvoted'];
}

$sql = "SELECT * FROM tbl_uploads";

$result_set = mysql_query($sql);

while ($row = mysql_fetch_array($result_set)) {

    if (in_array($row['id'], $voted)) {
        ?>

        <div class="entry">



        </div>

        <?php
    } else {
        ?>

        <div class="entry">
            <div class='vote_buttons' id='vote_buttons<?php echo $row['id']; ?>'>
                <a href='javascript:;' class='vote_up' id='<?php echo $row['id']; ?>'></a>
                <a href='javascript:;' class='vote_down' id='<?php echo $row['id']; ?>'></a>
            </div>


        </div>

        <?php
    }
}
?>
   
