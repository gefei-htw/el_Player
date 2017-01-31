<?php
include_once 'sql/dbconfig.php';
?>


<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>la-Upload</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href='http://fonts.googleapis.com/css?family=Pontano+Sans' rel='stylesheet' type='text/css' />

        <link href="css/upload_style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/fonts.css" rel="stylesheet" type="text/css" media="all" />

        <!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

        <script src="js/jquery.js"></script>
        <script type='text/javascript'></script>

    </head>
    <body>

        <div id="header-wrapper">
            <div id="header" class="container">
                <div id="menu">
                    <a href='#header'><img border="0" alt="back to top" src="img/backtotop.png" id="backtotop"></a>
                    <a href='#upload'><img border="0" alt="back to bottom" src="img/backtobottom.png" id="backtobottom"></a>
                    <ul>
                        <li><a href="#songbook" accesskey="1" title="" id="playerlink">Playlist</a></li>	
                        <li class="current_page_item"><a href="#upload" accesskey="2" title="" id="uploadlink">Upload</a></li>
                    </ul>
                </div>
            </div>

            <div id="banner" class="container" >
                <img class="cover">
                    <div class="heading" id="heading">
                        <div id="songinfo">	
                            <?php include 'sql\songinfo.php'; ?>
                        </div>

                        <div id="searchborder">
                            <a name="songbook"></a>
                            <input type="search" name="keyword" placeholder="Search Songs" id="searchbox">
                        </div>     
                        <div id="searchby">
                            <fieldset>
                                <input type="radio" id="asearch" name="searchtype" value="artist" checked="checked">
                                    <label for="asearch"><p1>search by Artist</p1></label> 
                                    <input type="radio" id="tsearch" name="searchtype" value="title">
                                        <label for="tsearch"><p1>search by Title</p1></label><br> 
                                            </fieldset>
                                            </div>
                                            </div>

                                            <div id="library">

                                                <div id="pl_container">
                                                    <form method="post">
                                                        <table><tr><th id='songst'>Songs 

                                                                    <?php if (isset($_POST['sortby'])) {
                                                                        $sortoby = "up";
                                                                        print_r($sortby);
                                                                    } ?></button>

                                                                </th><th id='dvotest'>DownVotes</th2><th id='uvotest'>UpVotes</th><th id='cvotest'>CurrentVoting</th></table>
                                                                    </form>
                                                                    <ul id="playlist" class="hidden">
                                                                        <?php include 'sql\upload_playlist.php'; ?>
                                                                    </ul>

                                                                    </div>
                                                                    <div id="btn_container">
                                                                        <?php include 'sql\upload_votebuttons.php'; ?>
                                                                    </div>

                                                                    <div id="wrapper2">

                                                                        <div id="upload" class="container">
                                                                            <div class="title">
                                                                                <div id="uploadheader">
                                                                                    <a name="upload"></a> 
                                                                                    <h2>Upload your Song</h2>
                                                                                    <span class="byline">Share any MP3 or OGG Audio-File</span> </div>
                                                                            </div>
                                                                            <div class="content">
                                                                                <form action="sql/upload_upload.php" method="post" enctype="multipart/form-data">
                                                                                    <label class="file-upload">
                                                                                        <div class="6u">
                                                                                            choose Song...<input type="file" class="button" name="file" accept=".mp3, .ogg" required/>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="file-upload">
                                                                                        <div class="6u">
                                                                                            choose Cover...<input type="file" class="button" name="cover" accept=".jpg, .jpeg, .png, .gif, .bmp" />
                                                                                        </div>
                                                                                    </label>
                                                                                    <div class="row half">

                                                                                        <div class="6u">
                                                                                            <input type="text" class="text" name="artist" placeholder="Artist" id="artist" required />

                                                                                        </div>
                                                                                        <div class="6u">
                                                                                            <input type="text" class="text" name="title" placeholder="Title" id="title" required />

                                                                                        </div>
                                                                                        <div class="6u">
                                                                                            <select type="text" class="text" name="genre" placeholder="Genre" id="genre" required >
                                                                                                <?php include 'sql\genre_list.php';
                                                                                                ?>


                                                                                            </select>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row half">
                                                                                        <div class="12u">
                                                                                            <textarea name="comments" placeholder="Message" id="comments"></textarea>

                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="row">
                                                                                        <div class="12u"> <button type="submit" name="btn-upload" class="button" >submit</button> </div>

                                                                                    </div>
                                                                                </form>
                                                                                <?php
                                                                                if (isset($_GET['success'])) {
                                                                                    
                                                                                } else if (isset($_GET['fail'])) {
                                                                                    ?>
                                                                                    <label>Problem While File Uploading !</label>
                                                                                    <?php
                                                                                } else {
                                                                                    
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    </div>
                                                                    <div id="line"><span></span></div>
                                                                    </div>

                                                                    </div>

                                                                    <script src="js/upload_main.js"></script>
                                                                    </body>
                                                                    </html>
