$(function() {
    $('.chosen-select').chosen(
        {
            search_contains: true
        }
    );

    $('button[type="submit"]').on('click', function() {
        $('button', $(this).closest('form')).prop('disabled', 'disabled');
        //$(this).prop('disabled', 'disabled');
        $(this).text('Loading...');
        // generate hidden element with button name
        var form = $(this).closest('form');
        var hid = $('<input />').attr('type', 'hidden').attr('name', $(this).attr('name'));
        form.append(hid);
        form.submit();

        return false;
    });

    assignDatePickers();
});

function assignDatePickers() {
    $('.datepicker').datepicker({
        format: "dd.mm.yyyy",
        daysOfWeekHighlighted: "5,6",
        autoclose: true,
        toggleActive: true
    });
}