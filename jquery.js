
$(document).ready(function(){
    $(".box").load(function() {
        var that = $(this);
        date_time = $(".box").attr('id');
        month = $(this).attr('month');
        year = $(this).attr('year');
        //console.log(date_time);
        $.ajax({
            type: 'GET',
            url: '/book.me/check.php', //processing
            data: "date=" + date_time + "&month=" + month + "&year=" + year, //input
            success: function(msg) { //output
                    that.css("background-color", "#cccccc");
                    alert('success');
                    $('#jresult').html(msg);
            },
            error: function(msg){
                alert('failure');
                $('#jresult').html(msg);
            }
        });
    });
    $(".box").mouseenter(function(){$(this).css("background-color", "red");});
    $(".box").mouseout(function(){$(this).css("background-color", "transparent");});
    $(".box").click(function() {
        date_time = $(this).attr('id');
        month = $(this).attr('month');
        year = $(this).attr('year');
        //console.log(date_time);
        $.ajax({
            type: 'GET',
            url: '/book.me/date.php', //processing
            data: "date=" + date_time + "&month=" + month + "&year=" + year, //input
            success: function(msg) { //output
                    $('#jresult').html(msg);
            }
        });
    });
    $(".bookedrow").parent().children("div:even").css("background-color", "#cccccc");
    $(".bookedrow").parent().children("div:odd").css("background-color", "#efefef");
    $(".unbookedrow").parent().children("div:even").css("background-color", "#cccccc");
    $(".unbookedrow").parent().children("div:odd").css("background-color", "#efefef");
    $(".deletablerow").parent().children("div:even").css("background-color", "#cccccc");
    $(".deletablerow").parent().children("div:odd").css("background-color", "#efefef");
    $(".bookedrow").click(function() {
        date_time = $(this).attr('id');
        $.ajax({
            type: 'GET',
            url: '/book.me/process.php', //processing
            data: "bookid=" + date_time, //input
            success: function(msg) { //output
                    $('#selected').html(msg);
            }
        });
    });
    $(".unbookedrow").click(function() {
        date_time = $(this).attr('id');
        $.ajax({
            type: 'GET',
            url: '/book.me/process.php', //processing
            data: "unbkid=" + date_time, //input
            success: function(msg) { //output
                    $('#selected').html(msg);
            }
        });
    });
    $(".deletablerow").click(function() {
        date_time = $(this).attr('id');
        $.ajax({
            type: 'GET',
            url: '/book.me/process.php', //processing
            data: "delid=" + date_time, //input
            success: function(msg) { //output
                    $('#selected').html(msg);
            }
        });
    });
});



