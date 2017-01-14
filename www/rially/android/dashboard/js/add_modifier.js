/**
 * Created by Admin on 11/7/2016.
 */

$(function() {

    var $modifiers = $('#modifiers');
    var $modifier = $('#modifier');
    var $addModifier = $('#add-modifier');
    var $alertDanger = $('.alert-danger-message');
    var $alertSuccess = $('.alert-success-message');

    $.ajax({
        type: 'GET',
        url: '../../get_all_modifiers.php',
        success: function(modifierResult) {
            var modifiers = JSON.parse(modifierResult);
            $.each(modifiers.modifiers, function(i, modifier) {
                $modifiers.append('<li>' + modifier.modifier + '</li>');
            });
        }
    });

    $addModifier.on('click', function() {

        if ($modifier.val() != "") {

            var add_modifier = {
                modifier: $modifier.val()
            };

            $.ajax( {
                type: 'POST',
                url: '../../create_modifier.php',
                data: add_modifier,
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success == 1) {
                        $alertSuccess.fadeIn();
                        document.getElementById("modifier").value = "";
                        $modifiers.append('<li>' + result.modifier + '</li>');
                        setTimeout(function() {
                            $alertSuccess.fadeOut(1000);
                        }, 5000);
                    } else {
                        $('#failmessage').text(result.message);
                        $alertDanger.fadeIn();
                        setTimeout(function() {
                            $alertDanger.fadeOut(1000);
                        }, 5000);
                    }
                }
            })
        } else {
            $('#failmessage').text("The required field is still empty");
            $alertDanger.fadeIn();
            setTimeout(function() {
                $alertDanger.fadeOut(1000);
            }, 5000);
        }   
    });

    $addModifier.mouseup(function() {
        $(this).blur();
    });

    $(document).ready(function(){
        $modifier.keypress(function(e){
            if(e.keyCode==13) {
                $addModifier.click();
                return false;
            }
        })
    });
});