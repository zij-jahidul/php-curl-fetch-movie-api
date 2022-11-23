<?php
include('db.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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


    <div class="search_section">


        <div class="container">

            <center>

                <?php
                if (isset($_GET["search_value"])) {
                    $query = $_GET["search_value"];
                    if ($query != null) {
                        $json = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=15d2ea6d0dc1d476efbca3eba2b9bbfb&query=$query");
                        $obj = json_decode($json);
                        $result = array();
                    }
                }
                ?>

                <div class="col">

                    <form class="form-inline search" method="GET">
                        <h2 class="searh_title">Search Your favorite Movie</h2>
                        <br>
                        <input class="form-control mr-2 value py-3" type="text" name="search_value" placeholder="Search Your faveriod Movie" aria-label="Search">
                        <input class="btn btn-success search_btn btn-lg my-3" value="Search" type="submit">
                    </form>
                </div>
            </center>

        </div>
    </div>

    <br>

    <div class="movie_list">
        <div class="container text-center">
            <div class="row">

                <?php
                $json = 'https://api.themoviedb.org/3/search/movie?api_key=15d2ea6d0dc1d476efbca3eba2b9bbfb&query=Avengers';
                $json = preg_replace('/\s+/', '%', $json);
                $json = file_get_contents($json);
                $obj = json_decode($json);
                $result = array();
                ?>

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

                                    <li>ID: <?php echo $value->id ?></li> <br />
                                    <li>Original_language: <?php echo $value->original_language ?></li> <br />
                                    <li>Original_title: <?php echo $value->original_title ?></li> <br />
                                    <li>Popularity: <?php echo $value->popularity ?></li> <br />
                                    <li>Release_date: <?php echo $value->release_date ?></li> <br />
                                    <li>Vote_average: <?php echo $value->vote_average ?></li> <br />
                                    <li>Vote_count: <?php echo $value->vote_count ?></li> <br />
                                    <!-- <li>Overview: <?php echo $value->overview ?></li> <br /> -->

                                </ul>

                                </p>
                                <a href="#" class="btn btn-primary btn-lg">Details</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <!-- <script src="script.js"></script> -->
</body>

</html>