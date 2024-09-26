
<?php
include('functions.php');
//authenticate
authenticate();
$fetch = [];
if(isset($_GET['game_id'])){
    $query = mysqli_query($conn,"SELECT * FROM `admin` where id='".$_GET['game_id']."' ");
    $fetch = mysqli_fetch_assoc($query);
}
if(isset($_POST['submit'])){
    $player_name = $_POST['name'];
    $player_email = $_POST['email'];
    $player_password = $_POST['password'];
    $status = $_POST['status']; 
    $hid_id = $_POST['hid_id'];
    // Check if the email already exists
    // $email_check_query = mysqli_query($conn, "SELECT * FROM `admin` WHERE email='" . $player_email . "'");
    $admin_table_name = 'admin';
    $data = [
        'name' => $player_name,
        'email' => $player_email,
        'password' => $player_password,
        'status' => $status,
        'date' => date('Y-m-d')
    ];
    if (check_user_exist($conn,$player_email,$admin_table_name) && $hid_id == '') {
        echo "<script>alert('Error: Email already exists.');</script>";
    } else{
    if($hid_id!=''){
        update_user($conn, 'admin', $hid_id, $data);
    }else{
        insert_user($conn, 'admin',$data);
    
    }
}
    
    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Player Score</title>
</head>
<body>

<div class="container mt-5">
    <?php
    if(isset($_SESSION['id']) && $_SESSION['id']==1){
        ?>
    <h1>Hello Admin <?php echo $_SESSION['name'] ?></h1>
    <?php 
    }else{
        ?>
        <h1>Hello Player <?php echo $_SESSION['name'] ?></h1>
        <?php
    }
    ?>
   
    <?php 
if(isset($_SESSION['id']) && $_SESSION['id']==1){
?>
     <h4>Add Player Score</h4>
    <button class="btn btn-secondary mb-3" onclick="location.href='view_scores.php'">View All Player Scores</button>
    <button class="btn btn-secondary mb-3" onclick="location.href='topfive.php'">Top 5 Players</button>
    <?php 
} else{
    ?>
    <button class="btn btn-secondary mb-3" onclick="location.href='game.php'">Play Game</button>
    <button class="btn btn-secondary mb-3" onclick="location.href='topfive.php'">Top 5 Players</button>

<?php
}
if(isset($_SESSION['id']) && $_SESSION['id']==1){
?>
    <form method="POST">
        <div class="form-group">
            <label for="playerName">Player Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo isset($fetch['name']) ? $fetch['name'] : ''; ?>" id="playerName" placeholder="Enter player name" required>
        </div>
        <div class="form-group">
            <label for="playerName">Player Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo isset($fetch['email']) ? $fetch['email'] : ''; ?>" id="playerName" placeholder="Enter player name" required>
        </div>
        <div class="form-group">
            <label for="playerName">Player Password</label>
            <input type="password" class="form-control" name="password" value="<?php echo isset($fetch['password']) ? $fetch['password'] : ''; ?>" id="playerName" placeholder="Enter player name" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <input type="hidden" name="hid_id" value="<?php echo isset($_GET['game_id']) ? $_GET['game_id'] : ''; ?>"/><br /><br>
        <input type="hidden" name="status" value="0"/><br /><br>
        
        
    </form>
    <?php } ?>
    <button class="btn btn-secondary mb-3" onclick="location.href='logout.php'">Logout</button>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

