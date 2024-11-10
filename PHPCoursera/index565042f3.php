<!DOCTYPE html>
<html>
<head>
<title>Shivam Maheshwari 565042f3</title>
</head>
<body>
<div class="container">
<h1>Welcome to Broken Rock Paper Scissors</h1>
<p><strong>Note:</strong> This sample code is only
partially done and serves only as a starting point for the assignment.
</p>
<p>
<a href="login.php">Please Log In</a>
</p>
<p>
Attempt to go to 
<a href="game.php">game.php</a> without logging in - it should fail with an error message.
<p>
</div>

<?php
// Do not put any HTML above this line
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is meow123
$failure = false;  // If we have no POST data
// Check to see if we have some POST data, if we do process it
if ( isset($_POST['who']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1 ) {
        $failure = "User name and password are required";
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            // Redirect the browser to game.php
            header("Location: game.php?name=".urlencode($_POST['who']));
            return;
        } else {
            $failure = "Incorrect password";
        }
    }
}
// Fall through into the View
?>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the 3  character language we are learning (all lower case) followed by 123. -->
</p>
</div>

<?php
// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}
// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}
// Set up the values for the game...
// 0 is Rock, 1 is Paper, and 2 is Scissors
$names = array('Rock', 'Paper', 'Scissors');
$human = isset($_POST["human"]) ? $_POST['human']+0 : -1;
$computer = rand(0,2); // Hard code the computer to rock
// TODO: Make the computer be random
// $computer = rand(0,2);
// This function takes as its input the computer and human play
// and returns "Tie", "You Lose", "You Win" depending on play
// where "You" is the human being addressed by the computer
function check($computer, $human) {
    // For now this is a rock-savant checking function
    // TODO: Fix this
    if ( $human == $computer ) {
        return "Tie";
    } else if ( $human == 1 AND $computer == 0 ){
        return "You Win";
    } else if ( $human == 2 AND $computer == 1 ){
        return "You Win";
    } else if ( $human == 0 AND $computer == 2 ){
    	return "You Win";
    } else if ( $human == 2  and $computer == 0 ) {
        return "You Lose";
    } else if ( $human == 1  and $computer == 2) {
        return "You Lose";
    } else if ( $human == 0  and $computer == 1 ) {
        return "You Lose";
    }
    
    return false;
}
// Check to see how the play happenned
$result = check($computer, $human);
?>
<div class="container">
<h1>Rock Paper Scissors</h1>
<?php
if ( isset($_REQUEST['name']) ) {
    echo "<p>Welcome: ";
    echo htmlentities($_REQUEST['name']);
    echo "</p>\n";
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

<pre>
<?php
if ( $human == -1 ) {
    print "Please select a strategy and press Play.\n";
} else if ( $human == 3 ) {
    for($c=0;$c<3;$c++) {
        for($h=0;$h<3;$h++) {
            $r = check($c, $h);
            print "Human=$names[$h] Computer=$names[$c] Result=$r\n";
        }
    }
} else {
    print "Your Play=$names[$human] Computer Play=$names[$computer] Result=$result\n";
}
?>
</pre>
</div>
</body>
</html>
