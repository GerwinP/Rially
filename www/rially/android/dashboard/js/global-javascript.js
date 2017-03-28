/**
 * Created by Admin on 25-Mar-17.
 */

var $header = $('#header-import');
var $navbar = $('#navbar-import');

$header.load("page_parts/header.html");

$navbar.load("page_parts/navbar.html");

$(function() {

    $.ajax({
       type: 'GET',
        url: '../../get_all_users.php',
        success: function(usersReturn) {
            var users = JSON.parse(usersReturn);
            console.log("Buidling");
            $.each(users.users, function(i, user) {
                $('#participants').append("<li> <a href='viewimages.php?username=" + user.username +"'>" + user.username + "</a></li>")
            });
        }
    });

    $("a").mouseup(function() {
        $(this).blur();
    });
});