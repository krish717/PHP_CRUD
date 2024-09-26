<?php
include('functions.php');
// login processing
if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the login check function
    $user = login_check($conn, $email, $password);

    if ($user) {
        // User found, set session variables
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['status'] = $user['status'];

        // Redirect to the desired page
        header('Location: add.php');
        exit();
    } else {
        // Redirect back to login if authentication fails
        echo "Invalid credentials";
        header('Location: index.php');
        exit();
    }
}
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>LOGIN</title>
</head>
<body>

<div class="container mt-5">
    <h2>LOGIN</h2>
    
    <form method="POST">
        <div class="form-group">
            <label for="playerName">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo isset($fetch['player_name']) ? $fetch['player_name'] : ''; ?>" id="playeokrName" placeholder="Enter Email" required>
        </div>
        
        <div class="form-group">
            <label for="playerName">Password</label>
            <input type="password" class="form-control" name="password" value="<?php echo isset($fetch['player_name']) ? $fetch['player_name'] : ''; ?>" id="playerName" placeholder="Enter password" required>
        </div>
        <button type="submit" name="signin" class="btn btn-primary">Submit</button>
        
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
