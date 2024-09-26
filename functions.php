<?php 
include('conn.php');
date_default_timezone_set('Asia/Kolkata');
function authenticate(){
    if (!isset($_SESSION['id'])) { 
   
        header('Location: index.php');
        exit();
    }
}

function check_user_exist($conn,$player_email, $table_name) {
    $email_check_query = mysqli_query($conn, "SELECT * FROM `$table_name` WHERE email='$player_email'");

    // Return true if the user exists, false otherwise
    return mysqli_num_rows($email_check_query) > 0;
}


function update_user($conn, $table_name, $hid_id, $data) {
    
    $hid_id = mysqli_real_escape_string($conn, $hid_id);

    //  to hold the updated fields
    $set_clause = [];

    // Loop through the data array to build the set clause
    foreach ($data as $key => $value) {
        $value = mysqli_real_escape_string($conn, $value);
        $set_clause[] = "$key='$value'";
    }

    // Combine the set clause into a string
    $set_clause_str = implode(", ", $set_clause);

    //  UPDATE query
    $update_query = "UPDATE `$table_name` SET $set_clause_str WHERE id='$hid_id'";

    // Execute 
    $update = mysqli_query($conn, $update_query);

    // Check the result of the query
    if ($update) {
        echo "<script>alert('Updated successfully');</script>";
        header("Location: view_scores.php");
        exit(); // Ensure script stops after redirection
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}


function insert_user($conn, $table_name, $data) {
    
    $hid_id = mysqli_real_escape_string($conn, $hid_id);

    //  to hold the updated fields
    $set_clause = [];

    // Loop through the data array to build the set clause
    foreach ($data as $key => $value) {
        $value = mysqli_real_escape_string($conn, $value);
        $set_clause[] = "$key='$value'";
    }

    // Combine the set clause into a string
    $set_clause_str = implode(", ", $set_clause);

    //  UPDATE query
    $insert_query = "INSERT INTO  `$table_name` SET $set_clause_str";

    // Execute 
    $insert = mysqli_query($conn, $insert_query);

    // Check the result of the query
    if ($insert) {
        echo "<script>alert('Updated successfully');</script>";
        header("Location: view_scores.php");
        exit(); // Ensure script stops after redirection
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

function insertUserStats($conn, $sessionId, $wins) {
    $currentTime = date('H:i:s');
    $id = $sessionId;

    // Check for the last entry
    $checkQuery = "SELECT * FROM `game` WHERE player_id='".$id."' ORDER BY `uniquekey` DESC LIMIT 1";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        $row = mysqli_fetch_assoc($checkResult);
        $lastTime = $row['uniquekey'];
        $previousScore = $row['score'];
         $previousScore = $previousScore+1;
       
        $lastTimeStamp = strtotime($lastTime);
        $currentTimeStamp = strtotime(date('H:i:s'));
        $differenceInSeconds = abs($lastTimeStamp - $currentTimeStamp);
      
        if ($differenceInSeconds<300) {
            
            $updateQuery = "UPDATE `game` SET score ='".$previousScore."',uniquekey='".$currentTime."' WHERE game_id = (SELECT MAX(game_id) FROM `game` WHERE player_id = '" . $id . "')";
            //echo "UPDATE `game` SET score ='".$previousScore."' WHERE game_id = (SELECT MAX(game_id) FROM `game` WHERE player_id = '" . $id . "')";
            mysqli_query($conn, $updateQuery);
         } else {
            $val = 1;
            $insertQuery = "INSERT INTO `game` SET player_id='".$id."',score='".$val."',uniquekey='".$currentTime."',date='".date('Y-m-d')."'";
            
            mysqli_query($conn, $insertQuery);
        }
    }else{
        $val = 1;
        $insertQuery = "INSERT INTO `game` SET player_id='".$id."',score='".$val."',uniquekey='".$currentTime."',date='".date('Y-m-d')."'";
        
        mysqli_query($conn, $insertQuery);
    } 
}


function determine_winner($userChoice, $computerChoice) {
    // Normalize choices to lowercase for consistency
    $userChoice = strtolower($userChoice);
    $computerChoice = strtolower($computerChoice);

    // Define the winning conditions
    if (($userChoice === 'rock' && $computerChoice === 'scissors') ||
        ($userChoice === 'paper' && $computerChoice === 'rock') ||
        ($userChoice === 'scissors' && $computerChoice === 'paper')) {
        return 1;
    } elseif ($userChoice === $computerChoice) {
        return 2;
    } else {
        return 0;
    }
}



function login_check($conn, $email, $password) {
    
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    
    // query to find the user
    $query = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $user = mysqli_query($conn, $query);

    // Check for query execution errors
    if (!$user) {
        die('Query failed: ' . mysqli_error($conn));
    }

    // Return the user data if found
    return mysqli_fetch_assoc($user);
}

function logout(){
    if (isset($_SESSION['id'])) {
        session_destroy();
    }
    header('Location: index.php');
    exit();
}



?>