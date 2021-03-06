/**
 * Created by Gerwin on 4-11-2016.
 */

$(function() {

    var $assignments = $('#all-assignments');
    var $removeAssignments = $('#remove-assignment');
    var $noAssignments = $('#no-assignments');
    var $alertDanger = $('.alert-danger-message');
    var $alertSuccess = $('.alert-success-message');
    var $selectAll = $('#select-all');
    var $selectNone = $('#select-none');
    var $reverseAll = $('#reverse-all');
    var $assignmentsCount = $('#assignment-count');
    
    $.ajax({
        type:'GET',
        url: '../../get_all_opdrachten.php',
        success: function(assignmentsReturn) {
            var assignments = JSON.parse(assignmentsReturn);
            $.each(assignments.opdrachten, function(i, assignment) {
                $assignments.append("<li><label><input type='checkbox' id='" + assignment.id +"'> " + assignment.opdracht + "</label></li>");
            });
            if ($assignments.children().length == 0) {
                $noAssignments.show();
            } else {
                $removeAssignments.show();
                $selectAll.show();
                $selectNone.show();
            }
        }
    });
    
    $removeAssignments.on('click', function() {
        //var confirmResult = confirm("Are you sure you want to delete the selected assignments? \n They cannot be recovered");
        var message = "Are you sure you want to delete the selected assignments? \n They cannot be recovered";
        $('<div></div>').appendTo('body')
            .html('<div><h6>' + message + '</h6></div>')
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
                                $assignmentsCount.text("There are no assignments selected.");
                                $('#successMessage').text("Successfully removed " + checked +" assignment(s)");
                                $alertSuccess.fadeIn();
                                setTimeout(function() {
                                    $alertSuccess.fadeOut(1000);
                                }, 5000);
                                if ($assignments.children().length == 0) {
                                    $removeAssignments.hide();
                                    $selectAll.hide();
                                    $selectNone.hide();
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
    });

    $selectAll.mouseup(function() {
        $(this).blur();
    });

    $selectNone.mouseup(function() {
       $(this).blur();
    });

    $reverseAll.mouseup(function() {
        $(this).blur();
    });

    $selectAll.on('click', function() {
        $assignments.find(":checkbox").prop('checked', true).change();
    });

    $selectNone.on('click', function() {
       $assignments.find(":checkbox").prop('checked', false).change();
    });

    $reverseAll.on('click', function() {
        $assignments.find(':checkbox').each(function() {
            $(this).is(':checked') ? $(this).prop('checked', false).change() : $(this).prop('checked', true).change();
        })
    });

    $assignments.on('change', ':checkbox', function() {

        var count = $assignments.find(':checked').length;

        if (count == 0) {
            $assignmentsCount.text("There are no assignments selected.");
        } else if (count == 1) {
            $assignmentsCount.text("There is " + count + " assignment selected.");
        } else {
            $assignmentsCount.text("There are " + count + " assignments selected.");
        }

    })
});