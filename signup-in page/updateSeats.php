<?php

require "database.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedSeats = $_POST['selectedSeats'];
    // var_dump($selectedSeats);


    // try {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pcinemau";

    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }



    $theatre_id = $_POST["theatre_id"];
    $diagram_kursi = $_POST["diagram_kursi"];
    $user = $_POST["user"];
    $movie_id = $_POST["movie_id"];
    $theatre_id = $_POST["theatre_id"];
    $diagram_kursi = $_POST["diagram_kursi"];

    $price = $_POST["price"];
    $ticketCount = $_POST["ticketCount"];
    $input_date = $_POST["date"];
    $date_obj = DateTime::createFromFormat('d-m-Y', $input_date);
    $date = $date_obj->format('Y-m-d');

    $time = $_POST["time"];
    $user_id = getUserID($user);




    $rows = query("SELECT * FROM detail_penayangan ds JOIN movie m ON (m.movie_id= ds.fk_movie_id) JOIN data_theatre t ON (t.theatre_id = ds.fk_theatre_id) JOIN schedule_hours s ON (ds.detail_penayangan_id = s.fk_detail_penayangan_id) WHERE fk_movie_id = $movie_id and fk_theatre_id = $theatre_id and jam_penayangan = '$time'");
    $schedule_id = $rows[0]["schedule_hours_id"];






    $timestamp = date('Y-m-d H:i:s');


    // foreach ($selectedSeats as $seat) {

    //     $stmt2 = $conn->prepare("INSERT INTO tiket (fk_schedule_hours_id, fk_kursi_id, fk_customer_id, price, fk_movie_id, date) VALUES ( ?, ?, ?, ?, ?, ?)");

    //     if (!$stmt2) {
    //         echo 0;
    //         exit();
    //     }

    //     if (!$stmt2->bind_param("isiiis", $schedule_id, $seat, $user_id, $price, $movie_id, $date)) {
    //         echo 0;
    //         exit();
    //     }

    //     if (!$stmt2->execute()) {
    //         echo 0;
    //         exit();
    //     }
    // }
    foreach ($selectedSeats as $seat) {
        $stmt2 = $conn->prepare("INSERT INTO tiket (fk_schedule_hours_id, fk_kursi_id, fk_customer_id, price, fk_movie_id, date, timestamp) VALUES ( ?, ?, ?, ?, ?, ?, ?)");
    
        if (!$stmt2) {
            echo 0;
            exit();
        }
    
        if (!$stmt2->bind_param("isiiiss", $schedule_id, $seat, $user_id, $price, $movie_id, $date, $timestamp)) {
            echo 0;
            exit();
        }
    
        if (!$stmt2->execute()) {
            echo 0;
            exit();
        }
    }


    $fusion_ids = array();
    foreach ($selectedSeats as $seat) {
        $fusion_ids[] = "{$theatre_id}-{$diagram_kursi}-{$seat}";
    }


    $placeholders = implode(',', array_fill(0, count($fusion_ids), '?'));
    $stmt = $conn->prepare("UPDATE seat SET status = 1 WHERE fusion_id IN ($placeholders)");

    $types = str_repeat('s', count($fusion_ids));
    $stmt->bind_param($types, ...$fusion_ids);
    $stmt->execute();

    if ($stmt->error) {
        echo 0;
        exit;
    }

    $stmt->close();
    $stmt2->close();

    $conn->close();

    echo 1;
} else {
    header("Location: index.php");
}
