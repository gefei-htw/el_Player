<?php
include_once 'dbconfig.php';
?>
<h2> 
    <?php
    $sql = " SELECT artist, title, comments from tbl_uploads WHERE isplaying = 'yes' ";
    $result = mysql_query($sql);
    $value = mysql_fetch_object($result);

    if ($value) {
        $artist = $value->artist;
        $title = $value->title;
        $comments = $value->comments;

        echo $artist;
        ?> - <?php
        echo $title;
    } else {
        $artist = "We are";
        $title = "sorry";
        $comments = "There is no Song playing right now";
        echo $artist;
        ?>&nbsp;<?php
        echo $title;
    }
    ?>
</h2>
<p><?php echo $comments; ?></p>