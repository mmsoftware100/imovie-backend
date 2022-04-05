
<!DOCTYPE html>

<?php
    // connet to db
    include('api/v1/config/dbconfig.php');
    
    // Create connection
    $conn = mysqli_connect(DBHOST, DBUSER, DBPWS,DBNAME);
    
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    // echo "Connected successfully";

    // update data
    if(isset($_POST['app_id'])){
        $id = $_POST['id'];
        $app_id = $_POST['app_id'];
        $banner_id = $_POST['banner_id'];
        $interstitial_id = $_POST['interstitial_id'];
        $sql = "UPDATE admob SET app_id='$app_id', banner_id='$banner_id', interstitial_id='$interstitial_id' WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }

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

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admob Panel</title>
    <style>
        h2,form{
            width: 200px;
            margin: auto;
        }
        input, label{
            display: block;
        }
        label{
            margin-top: 20px;
            padding-top: 20px;
        }
    </style>
</head>
<body>

    <h2>Admob Panel</h2>
    <form action="" method="POST">
        <input type="hidden" name="id" value="1"/>

        
        <label for="appId">App ID</label>
        <input type="text" name="app_id" value="<?php echo $data['app_id']; ?>" />

        <label for="appId">Banner ID</label>
        <input type="text" name="banner_id" value="<?php echo $data['banner_id']; ?>" />

        <label for="appId">Interstitial ID</label>
        <input type="text" name="interstitial_id" value="<?php echo $data['interstitial_id']; ?>" />

        <br>
        <input type="submit" value="Update"/>


    </form>
    
</body>
</html>