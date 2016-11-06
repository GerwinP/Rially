/**
 * Created by Gerwin on 4-11-2016.
 */

$(function() {

    var $assigments = $('#all-assignments');
    var $removeAssignments = $('#remove-assignment');

    if ($assigments.children().length == 0) {
        console.log("De kinderen zijn 0 geworden");
    }

    $.ajax({
        type:'GET',
        url: '../../get_all_opdrachten.php',
        success: function(assignmentsReturn) {
            var assignments = JSON.parse(assignmentsReturn);
            $.each(assignments.opdrachten, function(i, assignment) {
                $assigments.append("<li><label><input type='checkbox' id='" + assignment.id +"'> " + assignment.opdracht + "</label></li>");
            });
        }
    });
    
    $removeAssignments.on('click', function() {

        var ids = [];

        var data = {
          ids : ids
        };

        $("input:checkbox").each(function() {

            var $this = $(this);

           if ($this.is(":checked")) {
               ids.push($this.attr("id"));
           }
        });

        $.ajax({
            type:'POST',
            url:'../../remove_assignments.php',
            data:data,
            success: function(successReturn) {
                var result = JSON.parse(successReturn);

                $.each(result, function(i, id) {
                    $("input:checkbox[id^=" + id +"]").parents("li").hide();
                });
            }
        })
    });
});