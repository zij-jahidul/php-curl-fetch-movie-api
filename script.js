// // submit_btn.addEventListener("click", function() {

// // })


// function search() {
//     var search_val = document.getElementById("search_val").value;

//     alert(i)
//     fetch(`https://api.themoviedb.org/3/search/movie?api_key=d6ba05fdc46ba6668ef446a3343acb7f&language=en-US&query=${search_val}&page=1&include_adult=false`)
//         .then(response => response.json())
//         .then(json => alert(json))
// }


// var search_val = 'dog';
// var adult = true;
// fetch(`https://api.themoviedb.org/3/search/movie?api_key=d6ba05fdc46ba6668ef446a3343acb7f&language=en-US&query=${search_val}&page=1&include_adult=${adult}`)
//     .then(response => response.json())
//     .then(json => console.log(json))

// // function display(data) {
// //     const datas = data

// //     for (let i = 0; i < datas.length; i++) {
// //         console.log(datas)
// //     }
// // }




function search(){
    var search_value = $("#search_value").val();
    $.ajax({
        url:"searchResult.php",
        method:"GET",
        data:{"search_value":search_value},
        datatype:"json",
        success:function(result){
            //alert(JSON.stringify(result));
            $('#search_result').html(result);
        }, beforeSend: function () {
            $('#loading').show();
        },complete: function () {
            $('#loading').hide();
        }, error: function(response) {
            //alert(JSON.stringify(response));
        }
    });
};


$("#search_value").on("keyup",function() {
    var search_value = $("#search_value").val();
    $.ajax({
        url:"searchPage.php",
        method:"GET",
        data:{"search_value":search_value},
        datatype:"json",
        success:function(result){
            $('#all-card').hide();
            //alert(JSON.stringify(result));
            $('#search-card').html(result);
           
        }, beforeSend: function () {
            $('#loading').show();
        },complete: function () {
            $('#loading').hide();
        }, error: function(response) {
            //alert(JSON.stringify(response));
        }
    });
});


function detailsPage(id){
    $('#modelId').text(id);
    $("#detailsModel").modal('show');
}