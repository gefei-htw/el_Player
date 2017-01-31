<?php

include_once 'dbconfig.php';
if (isset($_POST['btn-upload'])) {

    $file = rand(1000, 100000) . "-" . $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $file_artist = $_POST['artist'];
    $file_title = $_POST['title'];
    $file_uploaddate = isset($_SESSION['file']['uploaddate']);
    $file_comments = $_POST['comments'];
    $folder = "../uploads/";
    $genre = $_POST['genre'];
    $upvotes = 0;
    $downvotes = 0;
    $totalupvotes = 0;
    $totaldownvotes = 0;

    $cover = rand(1000, 100000) . "-" . $_FILES['cover']['name'];
    $cover_loc = $_FILES['cover']['tmp_name'];
    $folderc = "../uploads/cover/";

    $new_artist = $file_artist;
    $new_title = $file_title;
    $new_uploaddate = date("Y-m-d");
    $new_comments = $file_comments;
    $new_cover = $cover;
    $new_genre = $genre;

    // new file size in KB
    $new_size = $file_size / 16384;
    // new file size in KB
    // make file name in lower case
    $new_file_name = strtolower($file);
    $new_cover_name = strtolower($cover);
    // make file name in lower case

    $final_file = str_replace(' ', '-', $new_file_name);
    $final_cover = str_replace(' ', '-', $new_cover_name);

    move_uploaded_file($cover_loc, $folderc . $final_cover);
    if (move_uploaded_file($file_loc, $folder . $final_file)) {

        $sql = "INSERT INTO tbl_uploads(file,type,size,artist,title, genre, uploaddate, comments, cover, upvotes, downvotes, totalupvotes, totaldownvotes) VALUES('$final_file','$file_type','$new_size','$new_artist','$new_title','$new_genre', '$new_uploaddate', '$new_comments', '$new_cover', '$upvotes', '$downvotes', '$totalupvotes', '$totaldownvotes' )";
        mysql_query($sql);
        
        $sql2 = "ALTER TABLE tbl_uploads ORDER BY id ASC";
        mysql_query($sql2);
        ?>
        <script>
            alert('successfully uploaded');
            window.location.href = '../upload_index.php?success';
        </script>
        <?php

    } else {
        ?>
        <script>
            alert('error while uploading file');
            window.location.href = 'index.php?fail';
        </script>
        <?php

    }
}
?>