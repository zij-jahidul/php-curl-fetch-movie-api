<?php
//session_start();
include "db.php";
if (isset($_GET["search_value"])) {
    // search fetch api
    $query = $_GET["search_value"];
    if ($query != null) {
        $json = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=15d2ea6d0dc1d476efbca3eba2b9bbfb&query=$query");
        $obj = json_decode($json);
        $result = array();
    }
    $search_value = $_GET["search_value"];
    $_SESSION["search_value"] = $search_value;

    $server_ip =  $_SERVER['SERVER_ADDR'];
    $_SESSION["server_ip"] = $server_ip;

    $date = date('m-d-Y h:i:s', time());
    $_SESSION["date"] = $date;

    if ($_SESSION["search_value"] != null) {
        $sql = "INSERT INTO search_information (search_term, ip_address, date_time) VALUES ('{$_SESSION['search_value']}','{$_SESSION['server_ip']}','{$_SESSION['date']}')";
    } else {
        echo "No Result Found. Please enter value";
        // default fetch api
        $page = rand(1, 99);
        $json = "https://api.themoviedb.org/3/search/movie?api_key=15d2ea6d0dc1d476efbca3eba2b9bbfb&query=$page";
        $json = preg_replace('/\s+/', '%', $json);
        $json = file_get_contents($json);
        $obj = json_decode($json);
        $result = array();
    }
} else {
    // default fetch api
    $page = rand(1, 99);
    $json = "https://api.themoviedb.org/3/search/movie?api_key=15d2ea6d0dc1d476efbca3eba2b9bbfb&query=$page";
    $json = preg_replace('/\s+/', '%', $json);
    $json = file_get_contents($json);
    $obj = json_decode($json);
    $result = array();
}
$html = '';

foreach ($obj->results as $key => $value) {
    $html .= '  <div class="col my-3">
                    <div class="card">
                        <img src="https://image.tmdb.org/t/p/original/' . $value->poster_path . '" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title" id="name">' . $value->title . '</h5>
                            <p class="card-text">
                            <ul style="list-style: none;">

                                <li>Year of the Movie:' . substr($value->release_date, 0, 4) . '</li> <br />

                            </ul>

                            </p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModel' . $value->id . '">
                                Details
                                </button>
                          
                           
                            <!-- <a href="#" class="btn btn-primary btn-lg">Details</a> -->
                        </div>
                    </div>
                </div>';
    $html .= '<div class="modal fade" id="detailsModel' . $value->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"> Movie Name : ' . $value->title . '</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <div class="card-fluid">
                                <img src="https://image.tmdb.org/t/p/original/.' . $value->backdrop_path . '" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            ID No.
                                            <span class="badge bg-primary rounded-pill"> ' . $value->id . ' </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Release Date:
                                            <span class="badge bg-primary rounded-pill"> ' . $value->release_date . ' </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Original_language :
                                            <span class="badge bg-primary rounded-pill"> ' . $value->original_language . ' </span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Vote Average:
                                            <span class="badge bg-primary rounded-pill"> ' . $value->vote_average . ' </span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Vote Count :
                                            <span class="badge bg-primary rounded-pill"> ' . $value->vote_count . ' </span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Popularity:
                                            <span class="badge bg-primary rounded-pill"> ' . $value->popularity . ' </span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span style="font-weight: bold;"> Overview:</span>
                                            <span style="text-align: justify;"> ' . $value->overview . ' </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    
                                </div>
                                </div>
                            </div>
                        </div>';
}
echo $html;
