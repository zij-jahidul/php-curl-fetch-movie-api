<?php
session_start();
include('db.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VMware Job Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img class="logo" src="image/Untitled-2.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="main_div" style="background-image: url('./image/bg2.jpg');">

        <div class="search_section">
            <div class="container">
                <center>

                    <?php
                    if (isset($_POST["search_value"])) {
                        // search fetch api
                        $query = $_POST["search_value"];
                        if ($query != null) {
                            $json = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=15d2ea6d0dc1d476efbca3eba2b9bbfb&query=$query");
                            $obj = json_decode($json);
                            $result = array();
                        }
                        $search_value = $_POST["search_value"];
                        $_SESSION["search_value"] = $search_value;

                        $server_ip =  $_SERVER['SERVER_ADDR'];
                        $_SESSION["server_ip"] = $server_ip;

                        $date = date('m-d-Y h:i:s', time());
                        $_SESSION["date"] = $date;

                        if ($_SESSION["search_value"] != null) {
                            $sql = "INSERT INTO search_information (search_term, ip_address, date_time) VALUES ('{$_SESSION['search_value']}','{$_SESSION['server_ip']}','{$_SESSION['date']}')";

                            if (mysqli_query($mysqli, $sql)) {
                                echo $_SESSION['search_value'] . " <h2 class='text-white'>Search Found successfully</h2>";
                                // Finally, destroy the session.
                                session_destroy();
                                header("index.php");
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }
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
                    ?>

                    <div class="col">
                        <form class="form-inline search" method="POST">
                            <h2 class="searh_title text-white" style="font-size:48px; font-weight: 600; ">Search Your favorite Movie</h2>
                            <br>
                            <input class="form-control mr-2 value py-3" type="text" name="search_value" id="search_value" placeholder="Search Your faveriod Movie" aria-label="Search" onkeyup="search()">
                        </form>
                    </div>
                </center>
            </div>
        </div>
        <br>

        <div class="movie_list">
            <div class="container text-center">

                <div class="row" id="all-card">
                    <?php
                    foreach ($obj->results as $key => $value) {
                    ?>

                        <div class="col my-3">
                            <div class="card">
                                <img src="https://image.tmdb.org/t/p/original/.<?php echo $value->poster_path ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title" id="name"> <?php echo $value->title ?> </h5>
                                    <p class="card-text">
                                    <ul style="list-style: none;">

                                        <li>Year of the Movie: <?php echo substr($value->release_date, 0, 4)  ?></li> <br />

                                    </ul>

                                    </p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModel<?php echo  $value->id ?>">
                                        Details
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="detailsModel<?php echo  $value->id ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"> Movie Name : <?php echo $value->original_title ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-fluid">
                                            <img src="https://image.tmdb.org/t/p/original/.<?php echo $value->backdrop_path ?>" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        ID No.
                                                        <span class="badge bg-primary rounded-pill"> <?php echo  $value->id ?> </span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        Release Date:
                                                        <span class="badge bg-primary rounded-pill"> <?php echo  $value->release_date ?> </span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        Original_language :
                                                        <span class="badge bg-primary rounded-pill"> <?php echo  $value->original_language ?> </span>
                                                    </li>

                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        Vote Average:
                                                        <span class="badge bg-primary rounded-pill"> <?php echo  $value->vote_average ?> </span>
                                                    </li>

                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        Vote Count :
                                                        <span class="badge bg-primary rounded-pill"> <?php echo  $value->vote_count ?> </span>
                                                    </li>

                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        Popularity:
                                                        <span class="badge bg-primary rounded-pill"> <?php echo  $value->popularity ?> </span>
                                                    </li>

                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span style="font-weight: bold;"> Overview:</span>
                                                        <span style="text-align: justify;"> <?php echo  $value->overview ?> </span>
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

                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="row" id="search-card"></div>
            </div>
        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js"></script>


</body>

</html>