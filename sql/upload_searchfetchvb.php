<?php
include_once 'dbconfig.php';
if ($_GET['keyword'] && !empty($_GET['keyword'])) {
    $bsearch = $_GET['searchby'];
    if ($bsearch == "title") {

        $searchby = "title";
    } elseif ($bsearch == "artist") {
        $searchby = "artist";
    }

    $keyword = $_GET['keyword'];
    $keyword = "%$keyword%";

    $sql = "SELECT * FROM tbl_uploads WHERE $searchby LIKE '$keyword'";



    $result_set = mysql_query($sql);

    while ($row = mysql_fetch_array($result_set)) {
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