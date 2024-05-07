<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <form action="#" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <br><br>
            <button name="login" type="submit">Log In</button>
        </form>
        <?php
            if(isset($_POST["login"])) {
                $username=$_POST["username"];
                $password=$_POST["password"];
                if($username=="ayan"){
                    if($password=="0712") {
                        $_SESSION["logged_in"] = true;
                        header("Location: adminpanel.php");
                    }
                    else {
                        echo "Incorrect password entered";
                    }
                }
                else {
                    echo "You are not admin";
                }
            }
        ?>
    </div>
</body>
</html>