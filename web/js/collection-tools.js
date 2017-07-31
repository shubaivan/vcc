$(function() {
    $('body').on('click', 'a.add-collection-item', function () {
        var prototype = $(this).attr('data-prototype');
        var target = $(this).attr('data-collection');
        var countElements = parseInt($('#' + target).attr('data-count'));

        var newItem = prototype.replace(/__name__/g, countElements);

        if (countElements == 0) {
            $('#' + target + ' tbody').empty();
        }

        $('#' + target + ' > tbody').append($(newItem));

        $('#' + target).attr('data-count', (countElements + 1));

        /*$('a.remove-collection-item').on('click', function() {
         var dataGroup = $(this).attr('data-group');

         if (dataGroup != undefined) {
         $('[data-group="' + dataGroup + '"]', '#' + target).remove();
         } else {
         $(this).parent().parent().remove();
         }

         return false;
         });*/

        assignDatePickers();

        return false;
    });

    $('body').on('click', '.remove-collection-item', function () {
        var dataGroup = $(this).attr('data-group');

        if (dataGroup != undefined) {
            $('[data-group="' + dataGroup + '"]').remove();
        } else {
            $(this).parent().parent().remove();
        }

        return false;
    });
});