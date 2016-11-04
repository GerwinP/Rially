/**
 * Created by Gerwin on 4-11-2016.
 */

$(function() {

    var $assigments = $('#all-assignments');
    var $removeAssignments = $('#remove-assignment');

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

        $.ajax({
            type:'POST',
            url:'../../remove_assignments.php'
        })
    });
});