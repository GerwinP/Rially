/**
 * Created by Admin on 11/7/2016.
 */

$(function() {

    var $username = $('#username');
    var $password = $('#password');
    var $rePassword = $('#rePassword');
    var $isAdmin = $('#isAdmin');
    var $addUser = $('#add-user');
    var $alertSuccess = $('.alert-success-message');
    var $alertDanger = $('.alert-danger-message');
    var $users = $('#users');

    $.ajax({
        type: 'GET',
        url: '../../get_all_users.php',
        success: function(userResult) {
            var users = JSON.parse(userResult);
            $.each(users.users, function(i, user) {
               if (user.admin == 1) {
                   $users.append('<li>' + user.username + ' <i>(admin)</i></li>');
               } else {
                   $users.append('<li>' + user.username + '</li>');
               }
            });
        }
    });

    $addUser.on('click', function() {

        if ($username.val() != "" || $password.val() != "" || $rePassword.val() != "") {
            if ($password.val() == $rePassword.val()) {

                var isAdmin = 0;

                if ($isAdmin.prop("checked")) {
                    isAdmin = 1;
                }

                var hash = CryptoJS.SHA256($password.val());
                var hashString = hash.toString(CryptoJS.enc.Base64);

                var addUser = {
                    username: $username.val(),
                    hpassword: hashString,
                    isAdmin: isAdmin
                };

                $.ajax( {
                    type: 'POST',
                    url: '../../create_user.php',
                    data: addUser,
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success == 1) {
                            $alertSuccess.fadeIn();
                            $username.val("");
                            $password.val("");
                            $rePassword.val("");
                            $isAdmin.prop("checked", false);
                            if (isAdmin == 1) {
                                $users.append('<li>' + result.username + ' <i>(admin)</i></li>');
                            } else {
                                $users.append('<li>' + result.username + '</li>');
                            }
                            setTimeout(function() {
                                $alertSuccess.fadeOut(1000);
                            }, 5000);
                        } else if (result.success == 0) {
                            $('#failmessage').text(result.message);
                            $alertDanger.fadeIn();
                            setTimeout(function() {
                                $alertDanger.fadeOut(1000);
                            }, 5000);
                        }
                    }
                })
            } else {
                $('#failmessage').text("The passwords do not match");
                $alertDanger.fadeIn();
                setTimeout(function() {
                    $alertDanger.fadeOut(1000);
                }, 5000);
            }
        } else{
            $('#failmessage').text("Required field(s) is/are missing ");
            $alertDanger.fadeIn();
            setTimeout(function() {
                $alertDanger.fadeOut(1000);
            }, 5000);
        }
    });

    $addUser.mouseup(function() {
        $(this).blur();
    })
});