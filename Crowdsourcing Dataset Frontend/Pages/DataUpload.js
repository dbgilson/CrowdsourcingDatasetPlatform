
$(document).ready(function () {
    $('#addTag').click(function () {
        $('#data').append('<li class="list-group-item w-50">' + $('#search').val() + '</li>')
    });
});