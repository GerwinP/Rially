/**
 * Created by Gerwin on 31-10-2016.
 */

$(function() {

    var $assignments = $('#assignments');
    var $assignment = $('#assignment');
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

    $('#add-assignment').on('click', function() {

        var add_assignment = {
            opdracht: $assignment.val()
        };

        $.ajax( {
           type: 'POST',
            url: '../../create_opdracht.php',
            data: add_assignment,
            success: function(result) {
                console.log(result);
            }
        });
    });
});