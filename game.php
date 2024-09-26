<?php
include('functions.php');
//authenticate
authenticate();



//store game option
$choices = ['rock', 'paper', 'scissors'];
$resultMessage = '';  
$userChoice = '';
$computerChoice = '';
$id = $_SESSION['id'];

if (isset($_POST['play'])) {
    $userChoice = strtolower($_POST['choice']);
    $computerChoice = $choices[array_rand($choices)];
        $winner = determine_winner($userChoice,$computerChoice);
        //2 means match tie
    if ($winner==2) {
        $resultMessage = "It's a tie! You both chose $userChoice.";
        //1 means match winner
    } elseif ($winner==1) {
        $resultMessage = "You win! $userChoice beats $computerChoice.";
        insertUserStats($conn, $id, 1); 
        //else means match lose
    } else {
        $resultMessage = "You lose! $computerChoice beats $userChoice.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rock, Paper, Scissors Game</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<button class="btn btn-secondary mb-3" onclick="location.href='add.php'">Home Page</button>
<div class="container mt-5">
    <h1 class="text-center">Rock, Paper, Scissors Game</h1>
    <form method="post" class="text-center">
        <div class="form-group">
            <label for="choice">Choose:</label>
            <select name="choice" id="choice" required>
                <option value="">Select your choice</option>
                <option value="rock">Rock</option>
                <option value="paper">Paper</option>
                <option value="scissors">Scissors</option>
            </select>
        </div>
        <button type="submit" name="play" class="btn btn-primary">Play</button>
    </form>

    <?php if ($resultMessage): ?>
        <div class="mt-4">
            <h4><?php echo $resultMessage; ?></h4>
            <p>You chose: <strong><?php echo ucfirst($userChoice); ?></strong></p>
            <p>Computer chose: <strong><?php echo ucfirst($computerChoice); ?></strong></p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
