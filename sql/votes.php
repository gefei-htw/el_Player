<?php

include("dbconfig.php");

function getAllVotes($id) {
    /**
      Returns an array whose first element is votes_up and the second one is votes_down
     * */
    $votes = array();
    $q = "SELECT * FROM tbl_uploads WHERE id = '$id'";
    $r = mysql_query($q);
    if (mysql_num_rows($r) == 1) {//id found in the table
        $row = mysql_fetch_assoc($r);
        $votes[0] = $row['upvotes'];
        $votes[1] = $row['downvotes'];
        $votes[2] = $row['totalupvotes'];
        $votes[3] = $row['totaldownvotes'];
    }
    return $votes;
}

function getEffectiveVotes($id) {
    /**
      Returns an integer
     * */
    $votes = getAllVotes($id);
    $effectiveVote[0] = $votes[0] - $votes[1];
    $effectiveVote[1] = $votes[2];
    $effectiveVote[1] = $votes[3];

    return $effectiveVote;
}

$id = $_POST['id'];
$action = $_POST['action'];

//get the current votes
$cur_votes = getAllVotes($id);


//ok, now update the votes

if ($action == 'vote_up') { //voting up
    $votes_up = $cur_votes[0] + 1;
    $q = "UPDATE tbl_uploads SET upvotes = $votes_up WHERE id = '$id'";
    $totalvotesup = $cur_votes[2] + 1;
    $q2 = "UPDATE tbl_uploads SET totalupvotes = $totalvotesup WHERE id = '$id'";
} elseif ($action == 'vote_down') { //voting down
    $votes_down = $cur_votes[1] + 1;
    $q = "UPDATE tbl_uploads SET downvotes = $votes_down WHERE id = '$id'";
    $totalvotesdown = $cur_votes[3] + 1;
    $q2 = "UPDATE tbl_uploads SET totaldownvotes = $totalvotesdown WHERE id = '$id'";
}

$r = mysql_query($q);
$t = mysql_query($q2);
if ($r && $t) { //voting done
    $effectiveVote = getEffectiveVotes($id);
    
    $sql25 = " UPDATE tbl_uploads SET reset ='1' WHERE id='$id'";

    mysql_query($sql25);
    
    echo $effectiveVote[0];
} elseif (!$r) { //voting failed
    echo "Failed!";
}
?>