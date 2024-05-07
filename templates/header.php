<?php 
session_start();
include '../dbms/crud.php';
$_SESSION["uid"]=isset($_SESSION["uid"])?$_SESSION["uid"]:null;
$connection = new Connection("elearn");
$conn = $connection->get_conn();
//var_dump($_SESSION);
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
  $uid = $_SESSION['user_profile']=='student'?'SID':'TID';
  $sql="SELECT * FROM ".$_SESSION['user_profile']." WHERE $uid=".$_SESSION["uid"].";";
  $_SESSION["user_info"]=mysqli_query($conn, $sql)->fetch_assoc();
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact Us</a> -->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="catalog.php">Catalog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=<?=(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"])?"logout.php":"login.php"?>>
                <?=(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"])?"Sign Out":"Login/Sign Up"?></a>
              </li>
          </ul>
        </div>
      </nav>