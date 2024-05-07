<?php 
    ob_start();
    include 'header.php';
    if(!$_SESSION["logged_in"])
        header("Location: login.php");
    $subid = $_GET["subid"];
    //echo "GET method: subject = $subid";
    $sql="SELECT * FROM SUBJECT NATURAL JOIN TEACHER WHERE SUBID=$subid";
    $detail = mysqli_query($conn, $sql)->fetch_assoc();
?>

<div style="background-color: white; background-color: seashell;margin-left: 30%;margin-right:30%;margin-top: 5%;border-radius: 10%;padding: 5%;font-size: larger">
    Subject Name : <?=$detail['SUBNAME']?><br>
    Stream : <?=$detail['STREAM']?><br>
    Teacher Name: <?=$detail['FNAME']." ".$detail['LNAME']?><br>
    Teacher's Email Address: <?=$detail['EMAIL']?> <br>
    Teacher's Contact Number: <?=$detail['PHN']?> <br>
    Price : <?=$detail['PRICE']?><br>
    Capacity : <?=$detail['CAPACITY']?><br>
    Enrolled Candidates : <?=$detail['ENROLLED']?><br><BR>
    <form action="" method="POST">
        <button class="btn btn-md success" style="background-color:aquamarine; border-radius: 20px;" type="submit" name="enroll">Enroll</button>
    </form>
</div>
<div>
<?php 
    if(isset($_POST["enroll"])) {
        $date_time = date("Y-m-d");
        $sql = "INSERT INTO enrollment VALUES(".$_SESSION["user_info"]["SID"].", $subid, '$date_time')";
        mysqli_query($conn, $sql);
        header("Location: dashboard.php");
    }
?>
</div>
</body>
</html>