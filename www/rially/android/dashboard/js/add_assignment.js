/**
 * Created by Gerwin on 31-10-2016.
 */

$(function() {

    var $assignments = $('#assignments');

    //Alerts
    var $alertDanger = $('.alert-danger-message');
    var $alertSuccess = $('.alert-success-message');

    //Select assignments block

    //Search assignments block

    //Add assignments block
    var $assignment = $('#assignment');
    var $addAssignmentButton = $('#add-assignment');
    var $addPanel = $('#add-panel');

    // Remove assignment block
    var $assignmentCount = $('#assignment-count');

    $.ajax({
       type: 'GET',
        url: '../../get_all_opdrachten.php',
        success: function(assignmentsReturn) {
            var assignments = JSON.parse(assignmentsReturn);
            $.each(assignments.opdrachten, function(i, assignment) {
               $assignments.append("<li><label><input type='checkbox' id='" + assignment.id +"'> " + assignment.opdracht + "</label></li>");
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
                    var result = JSON.parse(response);
                    if (result.success == 1) {
                        document.getElementById("assignment").value = "";
                        $assignments.append("<li><label><input type='checkbox' id='" + result.id +"'> " + result.opdracht + "</label></li>");
                        $addPanel.addClass("panel-success");
                        setTimeout(function() {
                            $addPanel.removeClass("panel-success");
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

    $assignment.keypress(function(e){
        if(e.keyCode==13) {
            $addAssignmentButton.click();
            return false;
        }
    });

    $assignments.on('change', ':checkbox', function() {

        var count = $assignments.find(':checked').length;

        if (count == 0) {
            $assignmentCount.text("There are no assignments selected.");
        } else if (count == 1) {
            $assignmentCount.text("There is " + count + " assignment selected.");
        } else {
            $assignmentCount.text("There are " + count + " assignments selected.");
        }
    });
});

