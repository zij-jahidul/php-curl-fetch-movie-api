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

           /*  if (mysqli_query($mysqli, $sql)) {
                echo $_SESSION['search_value'] . " Search Found successfully";
                // Finally, destroy the session.
                session_destroy();
                header("index.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            } */
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
        $html='';
        $html .='<ul class="list-group col-md-3">';
    foreach (array_slice($obj->results, 1, 10) as $key => $value) {
        $html .='<li class="list-group-item text-right"><img src="https://image.tmdb.org/t/p/original/'.$value->poster_path.'" class="list-img" width="35px" height="25px" alt="..."> '.$value->title.'</li>';
    }
        $html .= '</ul>';
        echo $html;
?>
   