<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');
    // connet to db
    include('api/v1/config/dbconfig.php');
    
    // Create connection
    $conn = mysqli_connect(DBHOST, DBUSER, DBPWS,DBNAME);
    
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    // echo "Connected successfully";


    // select data 

    $sql = "SELECT id, app_id, banner_id, interstitial_id FROM admob";
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $data = $row;
    }
    } else {
        echo "0 results";
    }
    $conn->close();

    echo json_encode($data);

?>
