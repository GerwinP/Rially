/**
 * Created by Gerwin on 31-10-2016.
 */

$(function() {

    var $assignments = $('#assignments');
    var $assignment = $('#assignment');
    var $addAssignmentButton = $('#add-assignment');
    var $alertDanger = $('.alert-danger-message');
    var $alertSuccess = $('.alert-success-message');

    $.ajax({
       type: 'GET',
        url: '../../get_all_opdrachten.php',
        success: function(assignmentsReturn) {
            var dingen = JSON.parse(assignmentsReturn);
            //console.log(dingen.opdrachten[0]);
            $.each(dingen.opdrachten, function(i, ding) {
               $assignments.append('<li>' + ding.opdracht + '</li>');
            });
        }
    });

    $addAssignmentButton.on('click', function() {

        if ($assignment.val() != "") {
            var add_assignment = {
                opdracht: $assignment.val()
            };

            $.ajax( {
                type: 'POST',
                url: '../../create_opdracht.php',
                data: add_assignment,
                success: function(response) {
                    console.log(response);
                    var result = JSON.parse(response);
                    if (result.success == 1) {
                        $alertSuccess.fadeIn();
                        document.getElementById("assignment").value = "";
                        $assignments.append('<li>' + result.opdracht + '</li>');
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
            });
        } else {
            $('#failmessage').text("The required field is still empty");
            $alertDanger.fadeIn();
            setTimeout(function() {
                $alertDanger.fadeOut(1000);
            }, 5000);
        }


    });

    $addAssignmentButton.mouseup(function(){
        $(this).blur();
    });

    $(document).ready(function(){
       $assignment.keypress(function(e){
           if(e.keyCode==13) {
               $addAssignmentButton.click();
               return false;
           }
       })
    });
});

