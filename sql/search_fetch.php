<?php

include_once 'dbconfig.php';

if ($_GET['keyword'] && !empty($_GET['keyword'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'dbradio'); //Connection to my database

    $bsearch = $_GET['searchby'];

    if ($bsearch == "title") {

        $searchby = "title";
    } elseif ($bsearch == "artist") {
        $searchby = "artist";
    }

    $keyword = $_GET['keyword'];
    $keyword = "%$keyword%";
    $query = "SELECT artist, title FROM tbl_uploads WHERE $searchby LIKE ?";
    $statement = $conn->prepare($query);
    $statement->bind_param('s', $keyword);
    $statement->execute();
    $statement->store_result();
    if ($statement->num_rows() == 0) { // so if we have 0 records acc. to keyword display no records found
        //echo '<div id="item">Ah snap...! No results found :/</div>';
        $statement->close();
        $conn->close();
    } else {
        $statement->bind_result($artist, $title);
        while ($statement->fetch()) { //outputs the records
            echo "<div id='item'>$artist - $title</div>";
        };
        $statement->close();
        $conn->close();
    };
};
?>