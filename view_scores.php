<?php
include('functions.php');
//authenticate
authenticate();
$query = mysqli_query($conn,"SELECT * FROM `admin` where status=0");
if(isset($_GET['game_id'])){
    $delete = mysqli_query($conn,"DELETE from `admin` where id='".$_GET['game_id']."' ");
if($delete){
    echo "<script>alert('Delete successfully');</script>";
    header("Location: view_scores.php");
}else{
    echo "<script>alert('Error: " . $conn->error . "');</script>";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Scores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
<body>

<div class="container mt-5">
    <h2>Game Scores</h2>
    <button class="btn btn-secondary mb-3" onclick="location.href='add.php'">Home Page</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Player Name</th>
                <th>Player Email</th>
                <th>Date</th>
                <th>Score</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            while($fetch = mysqli_fetch_assoc($query)){
            ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $fetch['name'];?></td>
                <td><?php echo $fetch['email'];?></td>
               
                <td>
                    <?php 
                     $date = new DateTime($fetch['date']);
                        echo $date->format('d-M-Y'); 
                        ?>
                </td>
               <td>
                <a href="scoreList.php?player_id=<?php echo $fetch['id']; ?>" class="text-primary">
    <i class="bi bi-eye"></i> 
</a></td>
                <td>
                

    <a href="add.php?game_id=<?php echo $fetch['id']; ?>" class="text-primary">
        <i class="bi bi-pencil"></i>
    </a>
    <a href="view_scores.php?game_id=<?php echo $fetch['id']; ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this record?');">
        <i class="bi bi-trash"></i>
    </a>
</td>

            </tr>
            <?php
            $i++;
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
