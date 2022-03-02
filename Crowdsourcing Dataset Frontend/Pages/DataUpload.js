
$(document).ready(function () {
    $('#addTag').click(function () {
        $('#data').append('<li class="list-group-item w-50">' + $('#search').val() + '</li>')
    });
});

$(document).ready(function () {
    $('#datasetSubmit').click(function () {
        var list = document.getElementsByClassName('list-group-item w-50');
        var listArray = [];
        for (var i = 0; i < list.length; i++) {
            listArray.push(list[i].innerHTML);
        }
        for (let i = 0; i < $('#data').find("li").length; i++) {
            $('#dataRecieved').append('<li class="list-group-item w-50">' + listArray[i] + '</li>')
        }
    });
})