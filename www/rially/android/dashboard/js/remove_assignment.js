/**
 * Created by Gerwin on 4-11-2016.
 */

$(function() {

    var $assigments = $('#all-assignments');
    var $removeAssignments = $('#remove-assignment');
    var $noAssignments = $('#no-assignments');
    var $alertDanger = $('.alert-danger-message');
    var $alertSuccess = $('.alert-success-message');

    $.ajax({
        type:'GET',
        url: '../../get_all_opdrachten.php',
        success: function(assignmentsReturn) {
            var assignments = JSON.parse(assignmentsReturn);
            $.each(assignments.opdrachten, function(i, assignment) {
                $assigments.append("<li><label><input type='checkbox' id='" + assignment.id +"'> " + assignment.opdracht + "</label></li>");
            });
            if ($assigments.children().length == 0) {
                $noAssignments.show();
            } else {
                $removeAssignments.show();
            }
        }
    });
    
    $removeAssignments.on('click', function() {
        //var confirmResult = confirm("Are you sure you want to delete the selected assignments? \n They cannot be recovered");
        var message = "Are you sure you want to delete the selected assignments? \n They cannot be recovered";
        $('<div></div>').appendTo('body')
            .html('<div><h6>' + message + '?</h6></div>')
            .dialog({
                modal: true, title: 'Delete message', height: "auto",
                width: '400', resizable: false,
                buttons: {
                    "Delete assignments" : function () {
                        var ids = [];
                        var data = {
                            ids : ids
                        };

                        var checked = 0;

                        $("input:checkbox").each(function() {
                            var $this = $(this);
                            if ($this.is(":checked")) {
                                ids.push($this.attr("id"));
                                checked = checked+1;
                            }
                        });

                        $.ajax({
                            type:'POST',
                            url:'../../remove_assignments.php',
                            data:data,
                            success: function(successReturn) {
                                var result = JSON.parse(successReturn);

                                $.each(result, function(i, id) {
                                    $("input:checkbox[id^=" + id +"]").parents("li").remove();
                                });
                                $('#successMessage').text("Successfully removed " + checked +" assignment(s)");
                                $alertSuccess.fadeIn();
                                setTimeout(function() {
                                    $alertSuccess.fadeOut(1000);
                                }, 5000);
                                if ($assigments.children().length == 0) {
                                    $removeAssignments.hide();
                                    $noAssignments.show();
                                }
                            }
                        });

                        $(this).dialog("close");
                    },
                    No: function () {
                        $(this).dialog("close");
                    }

                },
                close: function (event, ui) {
                    $(this).remove();
                }

            });
        $('.ui-dialog :button').blur();


    });

    $removeAssignments.mouseup(function(){
        $(this).blur();
    })

});