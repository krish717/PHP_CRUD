<?php
include('functions.php');
//authenticate
authenticate();
$query = mysqli_query($conn,"SELECT * FROM `game` where player_id='".$_GET['player_id']."' order by date desc, uniquekey desc ");


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
    <button class="btn btn-secondary mb-3" onclick="location.href='index.php'">Home Page</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                
                <th>Playing Date</th>
                <th>Time</th>
                <th>Score</th>
               
                
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            while($fetch = mysqli_fetch_assoc($query)){

            ?>
            <tr>
                <td><?php echo $i;?></td>
               
                <td><?php 
                     $date = new DateTime($fetch['date']);
                        echo $date->format('d-M-Y'); 
                        ?></td>
               <td>
                    <?php 
                    echo $fetch['uniquekey'];
                        ?>
                </td>
                <td>
                    <?php 
                    echo $fetch['score'];
                        ?>
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
