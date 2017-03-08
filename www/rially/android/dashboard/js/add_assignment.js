/**
 * Created by Gerwin on 31-10-2016.
 */

$(function() {

    var $assignments = $('#assignments');

    //Alerts
    var $alertDanger = $('.alert-danger-message');
    var $alertSuccess = $('.alert-success-message');

    //Select assignments block
    var $selectAll = $('#select-all');
    var $selectNone = $('#select-none');
    var $reverseSelected = $('#reverse-selected');

    //Search assignments block
    var $searchPanel = $('#search-panel');
    var $searchPanelHeading = $('#search-panel-heading');

    //Add assignments block
    var $assignment = $('#assignment');
    var $addAssignmentButton = $('#add-assignment');
    var $addPanel = $('#add-panel');
    var $addPanelHeading = $('#add-panel-heading');

    // Remove assignment block
    var $assignmentCount = $('#assignment-count');
    var $removeAssignments = $('#remove-assignment');
    var $removePanel = $('#remove-panel');
    var $removePanelHeading = $('#remove-panel-heading');

    // Strings
    var addAssignmenttext = "Add new assignment";
    var addedSuccesstext = "Assignment successfully added to database.";

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
                        $addPanelHeading.text(addedSuccesstext);
                        setTimeout(function() {
                            $addPanel.removeClass("panel-success");
                            $addPanelHeading.text(addAssignmenttext);
                        }, 5000);
                    } else {
                        $addPanel.addClass("panel-danger");
                        setTimeout(function() {
                            $addPanel.removeClass("panel-danger");
                        }, 5000);
                    }
                }
            });
        } else {
            $addPanel.addClass("panel-danger");
            var text = $addPanelHeading.text();
            $addPanelHeading.text("The text field is still empty");
            setTimeout(function() {
                $addPanel.removeClass("panel-danger");
                $addPanelHeading.text(text);
            }, 5000);
        }


    });

    //Functions for the selection buttons for the assignments list.
    $selectAll.on('click', function() {
       $assignments.find(":checkbox").prop('checked', true).change();
    });

    $selectNone.on('click', function() {
        $assignments.find(":checkbox").prop('checked', false).change();
    });

    $reverseSelected.on('click', function() {
        $assignments.find(':checkbox').each(function() {
            $(this).is(':checked') ? $(this).prop('checked', false).change() : $(this).prop('checked', true).change();
        })
    });

    //Removal of selected assignments
    $removeAssignments.on('click', function() {
        if ($assignments.find(":checked").length == 0) {
            console.log("No assignments selected");
        } else {
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
                                    $assignmentCount.text("There are currently no assignments selected.");
                                    $('#successMessage').text("Successfully removed " + checked +" assignment(s)");
                                    $alertSuccess.fadeIn();
                                    setTimeout(function() {
                                        $alertSuccess.fadeOut(1000);
                                    }, 5000);
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
        }
    });

    //Functions for every button to make sure it is not still in hovering state.
    $(':button').mouseup(function() {
        $(this).blur();
    });

    //Check for enter keypress
    $assignment.keypress(function(e){
        if(e.keyCode==13) {
            $addAssignmentButton.click();
            return false;
        }
    });

    //Checked assignment count
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

