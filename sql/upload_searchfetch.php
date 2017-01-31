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
        $net_vote = $row['upvotes'] - $row['downvotes']; //this is the net result of voting up and voting down
        ?>

        <li song="<?php echo $row['file']; ?>" 
            cover="<?php echo $row['cover']; ?>" 
            artist="<?php echo $row['artist']; ?>"
            id="<?php echo $row['id']; ?>"
            upvotes="<?php echo $row['upvotes']; ?>"
        downvotes="<?php echo $row['downvotes']; ?>"
            totalupvotes="<?php echo $row['totalupvotes']; ?>"
            totaldownvotes="<?php echo $row['totaldownvotes']; ?>"
            >

            <span class='link'>
                <span id="pl_artist"><?php echo $row['artist']; ?></span> - <span id="pl_title"> <?php echo $row['title']; ?></span>
            </span>

            <span id="votes">

                <span class='totalup' id="totalup<?php echo $row['id']; ?>"> <?php echo $row['totalupvotes']; ?></span>
                <span class='totaldown' id="totaldown<?php echo $row['id']; ?>"> <?php echo $row['totaldownvotes']; ?></span>


            </span>   

            <span id="votes">     
                <span class='votes_count' id='votes_count<?php echo $row['id']; ?>' ><?php echo $net_vote; ?></span>
            </span>

        </li>




        <?php
    }
}
?>