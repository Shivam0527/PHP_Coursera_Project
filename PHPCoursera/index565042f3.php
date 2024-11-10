<!DOCTYPE html>
<html>
<head>
    <title>Rock Paper Scissors Game 565042f3</title>
</head>
<body>
<div class="container">
<?php
// Constants and variables
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Password is 'meow123'
$failure = false;
$names = array('Rock', 'Paper', 'Scissors');
$human = -1;
$computer = rand(0, 2);

// Check if the user requested logout
if (isset($_POST['logout'])) {
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Check login form submission
if (isset($_POST['who']) && isset($_POST['pass'])) {
    if (strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1) {
        $failure = "User name and password are required";
    } else {
        $check = hash('md5', $salt . $_POST['pass']);
        if ($check == $stored_hash) {
            // Successful login, start game
            $name = htmlentities($_POST['who']);
        } else {
            $failure = "Incorrect password";
        }
    }
}

// Function to determine game outcome
function check($computer, $human)
{
    if ($human == $computer) {
        return "Tie";
    } elseif (($human == 0 && $computer == 2) || 
              ($human == 1 && $computer == 0) || 
              ($human == 2 && $computer == 1)) {
        return "You Win";
    } else {
        return "You Lose";
    }
}

if (isset($name)) {
    // Game section
    echo "<h1>Rock Paper Scissors</h1>";
    echo "<p>Welcome, $name!</p>";
    $result = null;
    
    // Check the game form submission
    if (isset($_POST['human'])) {
        $human = $_POST['human'] + 0;
        if ($human == 3) { // Test mode
            echo "<pre>";
            for ($c = 0; $c < 3; $c++) {
                for ($h = 0; $h < 3; $h++) {
                    $r = check($c, $h);
                    echo "Human={$names[$h]} Computer={$names[$c]} Result=$r\n";
                }
            }
            echo "</pre>";
        } elseif ($human >= 0 && $human <= 2) { // Normal game mode
            $result = check($computer, $human);
            echo "<p>Your Play={$names[$human]}, Computer Play={$names[$computer]}, Result=$result</p>";
        } else {
            echo "<p>Please select a strategy and press Play.</p>";
        }
    }
    ?>
    <form method="post">
        <select name="human">
            <option value="-1">Select</option>
            <option value="0">Rock</option>
            <option value="1">Paper</option>
            <option value="2">Scissors</option>
            <option value="3">Test</option>
        </select>
        <input type="submit" value="Play">
        <input type="submit" name="logout" value="Logout">
    </form>
    <?php
} else {
    // Login form
    echo "<h1>Please Log In</h1>";
    if ($failure !== false) {
        echo "<p style='color: red;'>$failure</p>";
    }
    ?>
    <form method="post">
        <label for="nam">User Name</label>
        <input type="text" name="who" id="nam"><br/>
        <label for="id_1723">Password</label>
        <input type="text" name="pass" id="id_1723"><br/>
        <input type="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <p>For a password hint, view source and find a password hint in the HTML comments.</p>
    <!-- Hint: The password is the 3 character language we are learning (all lower case) followed by 123. -->
    <?php
}
?>
</div>
</body>
</html>
