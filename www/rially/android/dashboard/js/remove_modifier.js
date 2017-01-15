/**
 * Created by Gerwin on 4-11-2016.
 */

$(function() {

    var $modifiers = $('#all-modifiers');
    var $removeModifiers = $('#remove-modifier');
    var $noModifiers = $('#no-modifiers');
    var $alertDanger = $('.alert-danger-message');
    var $alertSuccess = $('.alert-success-message');
    var $selectAll = $('#select-all');
    var $selectNone = $('#select-none');

    $.ajax({
        type:'GET',
        url: '../../get_all_modifiers.php',
        success: function(modifierReturn) {
            var modifiers = JSON.parse(modifierReturn);
            $.each(modifiers.modifiers, function(i, modifier) {
                $modifiers.append("<li><label><input type='checkbox' id='" + modifier.id +"'> " + modifier.modifier + "</label></li>");
            });
            if ($modifiers.children().length == 0) {
                $noModifiers.show();
            } else {
                $removeModifiers.show();
                $selectAll.show();
                $selectNone.show();
            }
        }
    });

    $removeModifiers.on('click', function() {

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
                                $('#successMessage').text("Successfully removed " + checked +" modifier(s)");
                                $alertSuccess.fadeIn();
                                setTimeout(function() {
                                    $alertSuccess.fadeOut(1000);
                                }, 5000);
                                if ($modifiers.children().length == 0) {
                                    $removeModifiers.hide();
                                    $selectAll.hide();
                                    $selectNone.hide();
                                    $noModifiers.show();
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

    $removeModifiers.mouseup(function(){
        $(this).blur();
    });

    $selectAll.mouseup(function() {
        $(this).blur();
    });

    $selectNone.mouseup(function() {
        $(this).blur();
    });

    $selectAll.on('click', function() {
        $modifiers.find(":checkbox").prop('checked', true);
    });

    $selectNone.on('click', function() {
        $modifiers.find(":checkbox").prop('checked', false);
    });

});