<?php
include_once 'dbconfig.php';



$sql = "SELECT * FROM tbl_uploads";

$result_set = mysql_query($sql);

while ($row = mysql_fetch_array($result_set)) {
    $net_vote = $row['upvotes'] - $row['downvotes']; //this is the net result of voting up and voting down
    $total_upvotes = $row['totalupvotes'];
    $total_downvotes = $row['totaldownvotes'];
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

            <span class='totalup' id='totalup<?php echo $row['id']; ?> '> <?php echo $row['totalupvotes']; ?></span>
            <span class='totaldown' id='totaldown<?php echo $row['id']; ?> '> <?php echo $row['totaldownvotes']; ?></span>


        </span>   

        <span id="votes">     
            <span class='votes_count' id='votes_count<?php echo $row['id']; ?>' ><?php echo $net_vote; ?></span>
        </span>

    </li>

    <!-- <div class='vote_buttons' id='vote_buttons<?php echo $row['id']; ?>'>
            <a href='javascript:;' class='vote_up' id='<?php echo $row['id']; ?>'></a>
            <a href='javascript:;' class='vote_down' id='<?php echo $row['id']; ?>'></a>
    </div> -->





    <?php
}
?>
   
