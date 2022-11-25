function search() {
    var search_value = $("#search_value").val();
    $.ajax({
        url: "searchResult.php",
        method: "GET",
        data: { "search_value": search_value },
        datatype: "json",
        success: function (result) {
            //alert(JSON.stringify(result));
            $('#search_result').html(result);
        }, beforeSend: function () {
            $('#loading').show();
        }, complete: function () {
            $('#loading').hide();
        }, error: function (response) {
            //alert(JSON.stringify(response));
        }
    });
};


$("#search_value").on("keyup", function () {
    var search_value = $("#search_value").val();
    $.ajax({
        url: "searchPage.php",
        method: "GET",
        data: { "search_value": search_value },
        datatype: "json",
        success: function (result) {
            $('#all-card').hide();
            //alert(JSON.stringify(result));
            $('#search-card').html(result);

        }, beforeSend: function () {
            $('#loading').show();
        }, complete: function () {
            $('#loading').hide();
        }, error: function (response) {
            //alert(JSON.stringify(response));
        }
    });
});


function detailsPage(id) {
    $('#modelId').text(id);
    $("#detailsModel").modal('show');
}