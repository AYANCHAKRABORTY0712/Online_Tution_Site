<?php 
ob_start();
session_start();
$_SESSION["username"]=isset($_SESSION["username"])?$_SESSION["username"]:null;
$_SESSION["logged_in"]=isset($_SESSION["logged_in"])?true:false;
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/interim_project/css/loginmodal.css">
    <link rel="stylesheet" href="/interim_project/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/interim_project/js/register.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="home.php">Home</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="about.php">About Us</a>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact Us</a>
            </li> -->
            <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#myModal">Log In</a>
              </li>
          </ul>
        </div>
      </nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="modal-box">
                <div class="modal show" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content clearfix">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <div class="modal-content clearfix">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <div class="modal-body">
                                    <div class="modal-icon">
                                        <i class="fas fa-desktop"></i>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <b>User Profile</b>
                                            <input type="radio" name="user_profile" value="student">Student
                                            <input type="radio" name="user_profile" value="teacher">Teacher
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="email" placeholder="Email Address" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                                        </div>
                                        <button class="btn" type="submit" name="login">Login</button>
                                    </form>
                                    <?php
                                        include '../dbms/crud.php';
                                        if(isset($_POST["login"])){
                                            $user_profile = $_POST['user_profile'];
                                            //var_dump($user_profile);
                                            $uid = $user_profile=='student'?'SID':'TID';
                                            $username = $_POST['email'];
                                            $password = $_POST["password"];
                                            $password = hash('sha512', $password);
                                            $connection = new Connection("elearn");
                                            $conn = $connection->get_conn();
                                            $query = "SELECT $uid FROM $user_profile WHERE EMAIL=?";
                                            //var_dump($query);
                                            $query = $conn->prepare($query);
                                            $query->bind_param('s',$username);
                                            $query->execute();
                                            $uid = $query->get_result()->fetch_assoc()[$uid];
                                            if($uid) {
                                                    $query = "SELECT PASS FROM $user_profile WHERE $uid=?";
                                                    $sql = $conn->prepare($query);
                                                    $sql->bind_param('s',$uid);
                                                    $sql->execute();
                                                    $user_pass = $sql->get_result()->fetch_assoc()['PASS'];
                                                    if($password === $user_pass)
                                                    {
                                                        $_SESSION["uid"]=$uid;
                                                        $_SESSION['user_profile']=$user_profile;
                                                        $_SESSION["logged_in"]=true;
                                                        header("Location: dashboard.php");
                                                    }
                                                    else {
                                                            echo "Incorrect password entered";
                                                    }
                                                }
                                                else {
                                                    echo "User not registered";
                                                }
                                            }
                                        ?>
                                </div>
                                <div class="modal-footer">
                                    <ul>
                                        <li><a href="">Forgot Password ?</a></li>
                                        <li><a href="signup.php">Sign Up</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<script type="text/javascript" src="http://jrain.oscitas.netdna-cdn.com/tutorial/js/jquery-1.12.0.min.js"></script>-->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>



</body>
</html>

