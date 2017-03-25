/**
 * Created by Admin on 11/7/2016.
 */

$(function() {

    var $modifiers = $('#modifiers');
    var $alertDanger = $('.alert-danger-message');
    var $alertSuccess = $('.alert-success-message');

    //Select modifier panel
    var $selectAll = $('#select-all');
    var $selectNone = $('#select-none');
    var $reverseSelected = $('#reverse-selected');

    //Search modifier panel
    var $searchModifier = $('#search-field');
    var $searchModifierButton = $('#search-modifier');
    var $searchpanel = $('#search-panel');
    var $searchPanelHeading = $('#search-panel-heading');

    //Add modifier panel
    var $modifier = $('#modifier');
    var $addModifierButton = $('#add-modifier');
    var $addPanel = $('#add-panel');
    var $addPanelHeading = $('#add-panel-heading');

    //Remove modifier panel
    var $modifierCount = $('#modifier-count');
    var $removeModifiers = $('#remove-modifier');
    var $removePanel = $('#remove-panel');
    var $removePanelHeading = $('#remove-panel-heading');
    
    //Strings
    var addModifierText = "Add new modifier";
    var addedSuccesstext = "Modifier successfully added to database";
    var requiredFieldEmptyText = "The required field is still empty";
    var removeModifierText = "Delete modifiers";

    $.ajax({
        type: 'GET',
        url: '../../get_all_modifiers.php',
        success: function(modifierResult) {
            var modifiers = JSON.parse(modifierResult);
            $.each(modifiers.modifiers, function(i, modifier) {
                $modifiers.append("<li><label><input type='checkbox' id='" + modifier.id + "'> " + modifier.modifier + "</label></li>");
            });
        }
    });

    $addModifierButton.on('click', function() {

        if ($modifier.val() != "") {

            var add_modifier = {
                modifier: $modifier.val()
            };

            $.ajax( {
                type: 'POST',
                url: '../../create_modifier.php',
                data: add_modifier,
                success: function(response) {
                    console.log(response);
                    var result = JSON.parse(response);
                    if (result.success == 1) {
                        document.getElementById("modifier").value = "";
                        $modifiers.append("<li><label><input type='checkbox' id='" + result.id + "'> " + result.modifier + "</label></li>");
                        $addPanel.addClass("panel-success");
                        $addPanelHeading.text(addedSuccesstext);
                        setTimeout(function() {
                            $addPanel.removeClass("panel-success");
                            $addPanelHeading.text(addModifierText);
                        }, 5000);
                    } else {
                        $addPanel.addClass("panel-danger");
                        $alertDanger.fadeIn();
                        setTimeout(function() {
                            $addPanel.removeClass("panel-danger");
                        }, 5000);
                    }
                }
            })
        } else {
            $addPanel.addClass("panel-danger");
            $addPanelHeading.text(requiredFieldEmptyText);
            setTimeout(function() {
                $addPanel.removeClass("panel-danger");
                $addPanelHeading.text(addModifierText);
            }, 5000);
        }   
    });

    //Removal of selected modifiers
    $removeModifiers.on('click', function() {
        if ($modifiers.find(":checked").length == 0) {
            console.log("No modifiers selected");
        } else {
            //var confirmResult = confirm("Are you sure you want to delete the selected assignments? \n They cannot be recovered");
            var message = "Are you sure you want to delete the selected modifiers? \n They cannot be recovered";
            $('<div></div>').appendTo('body')
                .html('<div><h6>' + message + '</h6></div>')
                .dialog({
                    modal: true, title: 'Delete message', height: "auto",
                    width: '400', resizable: false,
                    buttons: {
                        "Delete modifiers" : function () {
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
                                url:'../../remove_modifiers.php',
                                data:data,
                                success: function(successReturn) {
                                    var result = JSON.parse(successReturn);

                                    $.each(result, function(i, id) {
                                        $("input:checkbox[id^=" + id +"]").parents("li").remove();
                                    });
                                    $modifierCount.text("There are currently no modifiers selected.");
                                    $removePanel.addClass("panel-danger");
                                    $removePanelHeading.text("Successfully removed " + checked + " modifier(s)");
                                    setTimeout(function() {
                                        $removePanel.removeClass("panel-danger");
                                        $removePanelHeading.text(removeModifierText);
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

    //Functions for the selection buttons for the modifier list.
    $selectAll.on('click', function() {
        $modifiers.find(":checkbox").prop('checked', true).change();
    });

    $selectNone.on('click', function() {
        $modifiers.find(":checkbox").prop('checked', false).change();
    });

    $reverseSelected.on('click', function() {
        $modifiers.find(':checkbox').each(function() {
            $(this).is(':checked') ? $(this).prop('checked', false).change() : $(this).prop('checked', true).change();
        })
    });

    //Function for every button to make sure it is not still in hovering state
    $(':button').mouseup(function() {
        $(this).blur();
    });

    //Check for enter keypress
    $modifier.keypress(function(e){
        if(e.keyCode==13) {
            $addModifierButton.click();
            return false;
        }
    });

    //Checked modifier counter
    $modifiers.on('change', ':checkbox', function() {

        var count = $modifiers.find(':checked').length;

        if (count == 0) {
            $modifierCount.text("There are no assignments selected.");
        } else if (count == 1) {
            $modifierCount.text("There is " + count + " assignment selected.");
        } else {
            $modifierCount.text("There are " + count + " assignments selected.");
        }
    });
});