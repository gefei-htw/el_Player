var audio;
var volume;
var currentsong;
var currentsongindex;
var nextsong;
var nextsongindex;
var playorder;
var stinit;
var bsearching;
var lastIDdb;
var currentcover;
var currentvoting = [];
var currentvotingtemp = [];



// Start Initialization
Init();

//Searchbox
$(document).ready(function () {
    $("#searchbox").on('keyup', function () {
        bsearching = true;
        var key = $(this).val();
        var searchby = $('input[name="searchtype"]:checked').val();

        //check searchby Value
        if (!searchby) {
            searchby = "artist";
        }

        if (key === "") {
            updatePlaylist();
            bsearching = false;

        } else {
            //actual search
            $.ajax({
                url: 'sql/player_searchfetch.php',
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
        }
    });
});


// Initialization Function
function Init() {

    //Hide Pause Button
    $('#pause').hide();

    //Start Decleration
    playorder = $('input[name="votingradio"]:checked').val();
    currentsong = $("#playlist li").eq(0);
    getVotes();
    volume = 1.00;
    initAudio(currentsong);
    stinit = true;
    bsearching = false;

// reload Playlist every XX msec 20000=20sek.
    setInterval(checkPlaylist, 2000);


}

// InitAudio-Function
function initAudio(element) {

    var song = element.attr('song');
    var title = element.text();
    var cover = element.attr('cover');
    var artist = element.attr('artist');

    //Create Audio Object
    audio = new Audio('uploads/' + song);

    if (!audio.currentTime) {
        $('#duration').html('0.00');
    }

    $('#audio-info.title').text(title);
    $('#audio-info.artist').text(artist);

    //insert Cover
    if (!cover) {
        getrandomCover();
    } else {

        currentcover = cover;
    }

    setcurrentcover(currentcover);
    $('img.cover').attr('src', 'uploads/cover/' + currentcover);

    $('#playlist li').removeClass('active');
    element.addClass('active');

    //set Volume
    audio.volume = volume;

    currentsongindex = $('#playlist li.active').index();
    currentsong = $('#playlist li.active');
    setisplaying($('#playlist li.active').attr('id'));
    updateSonginfo();
    onsongended();

    if (playorder === "By Voting" && stinit === false) {
        setreset($('#playlist li.active').attr('id'), 0);

    }


}

//Play Button
$('#play').click(function () {

    if (playorder === "By Voting") {
        if (stinit === true) {
            stinit = false;
            initAudio(nextsong);


        }

    }
    audio.play();
    $('#play').hide();
    $('#pause').show();
    $('#duration').fadeIn(400);
    showDuration;
    //setisplaying($('#playlist li.active').attr('id'));

    //Set current song Votes to 0; Get next song
    if (playorder === "By Voting") {
        setVotes($('#playlist li.active').attr('id'));
        getVotes();
    }

});

//Pause Button
$('#pause').click(function () {
    audio.pause();
    $('#pause').hide();
    $('#play').show();
});

//Stop Button
$('#stop').click(function () {
    audio.pause();
    audio.currentTime = 0;
    $('#pause').hide();
    $('#play').show();
    $('#duration').fadeOut(400);
    setisplaying(-1);
    updateSonginfo();


});

//Next Button
$('#next').click(function () {

    audio.pause();

    //Check if by Voting
    if (playorder === "By Voting") {

        if (stinit === true) {
            stinit = false;

        }



        //Check if next song is avaliable
        if (nextsong.length === 0) {
            getVotes();

            if (nextsong.length === 0) {
                nextsong = $('#playlist li').eq(0);
            }


        }
    } else {

        nextsong = (currentsong.next());

        if (nextsong.length === 0) {
            nextsong = $('#playlist li').eq(0);

        }
    }

    initAudio(nextsong);
    audio.play();
    showDuration();
    $('#play').hide();
    $('#pause').show();

    //set next song
    if (playorder === "By Voting") {
        setVotes($('#playlist li.active').attr('id'));
        getVotes();
    }

});



//Prev Button
$('#prev').click(function () {
    audio.pause();
    var prev = currentsong.prev();
    //prev = prev.next();
    if (prev.length === 0) {
        prev = $('#playlist li:last-child');

    }
    initAudio(prev);
    audio.play();
    showDuration();
    $('#play').hide();
    $('#pause').show();

});


//Click Playlist
$("#playlist").delegate("li", "click", function () {
    audio.pause();
    //Chech which Item is clicked
    for (var i = 0; i < $('#playlist li').length; i++) {
        if (this.id === $("#playlist li:eq(" + (i) + ")").attr('id')) {

            initAudio($("#playlist li:eq(" + (i) + ")"));
            audio.play();
            showDuration();
            $('#play').hide();
            $('#pause').show();

            break;
        }

    }


});

//Volume Control
$('#volume').change(function () {
    volume = parseFloat(this.value / 100);
    audio.volume = volume;
});

//Jump to Time
$('#progressbar').mouseup(function (e) {
    var leftOffset = e.pageX - $(this).offset().left;
    var songPercents = leftOffset / $('#progressBar').width();
    audio.currentTime = songPercents * audio.duration;
});


// Next song after end of Current
function onsongended() {

    audio.addEventListener('ended', function () {
        audio.pause();
//Check if by Voting
        if (playorder === "By Voting") {

            setreset(($('#playlist li.active').attr('id')), 0);
            //Check if next song is avaliable
            if (nextsong.length === 0) {
                getVotes();

                if (nextsong.length === 0) {
                    nextsong = $('#playlist li:first-child');
                }
            }
        } else {
            nextsong = $('#playlist li.active').next();

            if (nextsong.length === 0) {
                nextsong = $('#playlist li:first-child');

            }
        }

        initAudio(nextsong);
        audio.play();
        showDuration();
        $('#play').hide();
        $('#pause').show();

        //set next song
        if (playorder === "By Voting") {
            setVotes($('#playlist li.active').attr('id'));
            getVotes();
            //setisplaying();

        }

    });
}

//Time Duration
function showDuration() {
    $(audio).bind('timeupdate', function () {
        //Get Hours & Minutes
        var s = parseInt(audio.currentTime % 60);
        var m = parseInt((audio.currentTime) / 60) % 60;
        //Add 0 if less than 10
        if (s < 10) {
            s = '0' + s;
        }
        $('#duration').html(m + '.' + s);
        var value = 0;
        if (audio.currentTime > 0) {
            value = Math.floor((audio.currentTime / audio.duration) * 100);
        }
        $('#progress').css('width', value + '%');
    });
    console.log("Show Duration: ");
}

//Update GUI
function updateGUI() {
    $('#playlist li').removeClass('active');
    $("#playlist li:eq(" + currentsongindex + ")").addClass('active');

}

//Update Playlist
function updatePlaylist() {
    document.getElementById("playlist").innerHTML = $.ajax({
        url: "sql/player_playlist.php",
        cache: false,
        success: function (data) {
            $("#playlist").html(data);
            updateGUI();

        }
    });

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

//Check for new Playlist entry
function checkPlaylist() {
    getlastID();
    playorder = $('input[name="votingradio"]:checked').val();
        
    if (lastIDdb > $('#playlist li:last-child').attr('id') && !bsearching) {
            
        updatePlaylist();

        }
  

    newVotes(updatevotes);
}

//Get last ID
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

//Check for new Votes
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

            console.log("Up: " + up + " | Down: " + down + " | ID: " + id + " | Vote: " + vote + " | Up-Down: " + (up - down) + " | TotalUp: " + tu + " | TotalDown: " + td);


            if (vote !== curr) {

                console.log("IF IF: " + vote + " " + curr);
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


//Get nextsong based on votes
function getVotes() {

    $.get("sql/getvote.php", function (data) {

        if (parseInt(data) >= 0) {

            for (var i = 0; i < $('#playlist li').length; i++) {

                if (parseInt(data) === parseInt($("#playlist li:eq(" + (i) + ")").attr('id'))) {

                    nextsong = ($("#playlist li:eq(" + (i) + ")"));

                    nextsongindex = ($("#playlist li:eq(" + (i) + ")").index());
                    break;
                }

            }
        }

        if (parseInt(data) === -1) {
            nextsong = $('#playlist li.active').next();
            nextsongindex = nextsong.index();

        }
    });
}

//set votes of current song to 0
function setVotes(currentsongid) {


    $.ajax({
        url: 'sql/setvote.php',
        type: 'POST',
        data: {currentsongid: currentsongid}//, 
    });
}

//set is playing
function setisplaying(currentsongid) {

    $.ajax({
        url: 'sql/setisplaying.php',
        type: 'POST',
        data: {currentsongid: currentsongid}//, 
    });
}

//set reset flag
function setreset(currentsongid, value) {
    console.log("reset: " + value);
    console.log(currentsongid);

    $.ajax({
        url: 'sql/setreset.php',
        type: 'POST',
        data: {currentsongid: currentsongid, value: value}//, 
    });
}


//set curernt cover
function setcurrentcover(currentcover) {

    $.ajax({
        url: 'sql/setcurrentcover.php',
        type: 'POST',
        data: {currentcover: currentcover}//, 
    });
}

/*
 //Voting System
 $(function () {
 $("a.vote_up").click(function () {
 //get the id
 the_id = $(this).attr('id');
 
 // show the spinner
 
 //fadeout the vote-count 
 $("span#votes_count" + the_id).fadeOut("fast");
 
 //the main ajax request
 $.ajax({
 type: "POST",
 data: "action=vote_up&id=" + $(this).attr("id"),
 url: "sql/votes.php",
 success: function (msg)
 {
 $("span#votes_count" + the_id).html(msg);
 //fadein the vote count
 $("span#votes_count" + the_id).fadeIn();
 //remove the spinner
 $("span#vote_buttons" + the_id).remove();
 }
 });
 });
 
 $("a.vote_down").click(function () {
 //get the id
 the_id = $(this).attr('id');
 
 // show the spinner
 //$(this).parent().html("<img src='img/spinner.gif'/>");
 
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
 $("span#vote_buttons" + the_id).remove();
 }
 });
 });
 });
 */

//if theres no Cover get a random
function getrandomCover() {

    $.get("sql/getrandomcover.php", function (data) {
        currentcover = data;

    });
}
