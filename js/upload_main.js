
var stinit;
var currentsongtemp;
var bsearching;
var currentsongindex;
var hasvoted;
var lastIDdb;


// Start Initialization
init();

// Initialization Function
function init() {
    stinit = true;
    hasvoted = [];
    getisplaying();
    if ($('#playlist li.active')) {
        currentsongtemp = $('#playlist li.active');
    } else {
        currentsongtemp = null;
    }
    updateGUI();

    // reload GUI every XX msec 20000=20sek.
    setInterval(updateGUI, 5000);
    //setInterval( newVotes(updatevotes), 500);

}

//Searchbox
$(document).ready(function () {
    $("#searchbox").on('keyup', function () {
        var key = $(this).val();
        var searchby = $('input[name="searchtype"]:checked').val();

        // Check searchby Value
        if (!searchby) {
            searchby = "artist";
        }

        if (key === "") {
            updatePlaylist();
            bsearching = false;

        }

        // actual search
        else {
            $.ajax({
                url: 'sql/upload_searchfetch.php',
                type: 'GET',
                data: {keyword: key, searchby: searchby},
                beforeSend: function () {
                    $("#playlist").slideUp('fast');
                },
                success: function (data) {
                    $("#playlist").html(data);
                    $("#playlist").slideDown('fast');
                }

            });
            // set the Votebuttons
            $.ajax({
                url: 'sql/upload_searchfetchvb.php',
                type: 'GET',
                data: {keyword: key, searchby: searchby},
                beforeSend: function () {
                    $("#btn_container").slideUp('fast');
                },
                success: function (data) {
                    $("#btn_container").html(data);
                    $("#btn_container").slideDown('fast');
                },

            });

        }
    });
});

//Update GUI
function updateGUI() {
    getisplaying();
    newVotes(updatevotes);
    checkPlaylist();

    if ($('#playlist li.active').attr('id')) {
        if (currentsongtemp === null) {
            currentsongtemp = $('#playlist li.active');
            getCover();
        }

    }
    if (songchanged()) {
        updateSonginfo();
        getCover();
    }


}

//Check if Song has changed
function songchanged() {

    if ($('#playlist li.active').attr('id') !== currentsongtemp.attr('id')) {
        currentsongtemp = $('#playlist li.active');
        return true;

    } else {
        return false;
    }
}

//Update Songinfo
function updateSonginfo() {
    document.getElementById("songinfo").innerHTML = $.ajax({
        url: "sql/songinfo.php",
        cache: false,
        success: function (data) {
            $("#songinfo").html(data);

        }
    });

}


//get & set the current Cover
function getCover() {

    $.get("sql/getcurrentcover.php", function (data) {

        var trimmed = data.toString().trim();
        $('img.cover').attr('src', 'uploads/cover/' + trimmed);

    });
}



//Update Playlist
function updatePlaylist() {
    //Playlist
    document.getElementById("playlist").innerHTML = $.ajax({
        url: "sql/upload_playlist.php",
        cache: false,
        success: function (data) {
            $("#playlist").html(data);
            //updateGUI();    
            getisplaying();
        }
    });

    //Votebuttons
    document.getElementById("btn_container").innerHTML = $.ajax({
        url: "sql/upload_votebuttons.php",
        cache: false,
        data: {hasvoted: hasvoted},
        success: function (data) {
            $("#btn_container").html(data);
            //updateGUI();    

        }
    });

}
//Check for new Playlist entry
function checkPlaylist() {
    
        getlastID();

       if (lastIDdb > $('#playlist li:last-child').attr('id') && !bsearching) {
            updatePlaylist();

        }

    /*$.get("sql/upload_playlistcheck.php", function (data) {

        var str = data;
        var idn = parseInt($('#playlist li:last-child').attr('id'));
        var strs = 'id="' + (idn + 1) + '"';
        var check = str.search(strs);

        //playorder = $('input[name="votingradio"]:checked').val();


        if (check > 0) {
            updatePlaylist();
        }
    });*/


}


//Voting System
$(function () {
    $("a.vote_up").click(function () {
        //get the id
        the_id = $(this).attr('id');

        hasvoted.push(the_id);

        // show the spinner
        $(this).parent().html("<img src='img/thumb_green.png' class= 'spinner'>");

        //fadeout the vote-count 
        $("span#votes_count" + the_id).fadeOut("fast");

        //the main ajax request
        $.ajax({
            type: "POST",
            data: "action=vote_up&id=" + $(this).attr("id"),
            url: "sql/votes.php",
            success: function (msg)
            {
                $("span#votes_count" + the_id).fadeOut();
                $("span#votes_count" + the_id).html(msg);
                //fadein the vote count
                $("span#votes_count" + the_id).fadeIn();
            }
        });
    });

    $("a.vote_down").click(function () {
        //get the id
        the_id = $(this).attr('id');

        // show the spinner
        $(this).parent().html("<img src='img/thumb_red.png' class='spinner'/>");

        //the main ajax request
        $.ajax({
            type: "POST",
            data: "action=vote_down&id=" + $(this).attr("id"),
            url: "sql/votes.php",
            success: function (msg)
            {
                $("span#votes_count" + the_id).fadeOut();
                $("span#votes_count" + the_id).html(msg);
                $("span#votes_count" + the_id).fadeIn();

            }
        });
    });
});


//Get & set curernt Song
function getisplaying() {


    $.get("sql/getisplaying.php", function (data) {

        if (parseInt(data) >= 0) {
            for (var i = 0; i < $('#playlist li').length; i++) {

                if (parseInt(data) === parseInt($("#playlist li:eq(" + (i) + ")").attr('id'))) {

                    $('#playlist li').removeClass('active');
                    $("#playlist li:eq(" + (i) + ")").addClass('active');


                    break;
                }

            }
        }

        if (!parseInt(data) || parseInt(data) === -1) {
            $('#playlist li').removeClass('active');

        }

    });
}

function newVotes(callbackfkn) {
    for (var i = 0; i < $('#playlist li').length; i++) {
        $.ajax({
            url: 'sql/checkvotes.php',
            type: 'GET',
            //async: false,
            dataType: 'json',
            data: {currentsongid: parseInt($("#playlist li:eq(" + (i) + ")").attr('id'))},

            success: function (data) {

                callbackfkn(data.vote, data.id, data.tu, data.td);
            }
        });


    }
}

function updatevotes(vote, id, tu, td) {

    var up;
    var down;
    var curr;

    for (var i = 0; i < $('#playlist li').length; i++) {

        if ($("#playlist li:eq(" + (i) + ")").attr('id') === id) {
            up = $("#playlist li:eq(" + (i) + ")").attr('upvotes');
            down = $("#playlist li:eq(" + (i) + ")").attr('downvotes');
            curr = up - down;

            if (vote !== curr) {

                //Fade-out current Votes
                $("span#votes_count" + $("#playlist li:eq(" + (i) + ")").attr('id')).fadeOut("fast");
                $("span#votes_count" + ($("#playlist li:eq(" + (i) + ")").attr('id'))).html(vote);
                //fadein the vote count
                $("span#votes_count" + ($("#playlist li:eq(" + (i) + ")").attr('id'))).fadeIn();

                //Fade-out total upVotes
                $("span#totalup" + $("#playlist li:eq(" + (i) + ")").attr('id')).fadeOut("fast");
                $("span#totalup" + ($("#playlist li:eq(" + (i) + ")").attr('id'))).html(tu);
                //fadein the vote count
                $("span#totalup" + ($("#playlist li:eq(" + (i) + ")").attr('id'))).fadeIn();

                //Fade-out total downVotes
                $("span#totaldown" + $("#playlist li:eq(" + (i) + ")").attr('id')).fadeOut("fast");
                $("span#totaldown" + ($("#playlist li:eq(" + (i) + ")").attr('id'))).html(td);
                //fadein the vote count
                $("span#totaldown" + ($("#playlist li:eq(" + (i) + ")").attr('id'))).fadeIn();
            }
        }
    }

}

function getlastID() {

    $.ajax({
        type: "GET",
        url: 'sql/getlastid.php',
        success: function (data) {

            lastIDdb = parseInt(data);
            //alert(data);

        }

    });


}
