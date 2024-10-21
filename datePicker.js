$(document).ready(function () {
    $('#startDate').attr('min', new Date().toLocaleDateString().split('.').reverse().join('-'));
    $('#endDate').attr('min', new Date().toLocaleDateString().split('.').reverse().join('-'));

    $('#startDate').on('change', function () {
        $('#endDate').attr('min', $('#startDate').val());
    });

    $('#endDate').on('change', function () {
        $.post('/price.php', {
            startDate: $('#startDate').val(),
            endDate: $('#endDate').val(),
            carPrice: $('#carPrice').val()
        }, function (data) {
            $('#rentPrice').html('$' + data.price);
            $('#rentDays').html(data.days);
            $('#pricePerDay').html('$' + data.price / data.days);
        }, 'json');
    });
});