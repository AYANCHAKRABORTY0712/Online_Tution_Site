<?php 
    include 'header.php';
    if(!$_SESSION["logged_in"])
        header("Location: login.php");
    if($_SESSION['user_profile']=='student') {
        $sql="SELECT COUNT(*) AS SUBCOUNT FROM enrollment WHERE SID=".$_SESSION["user_info"]["SID"];
        if(!mysqli_query($conn, $sql)->fetch_assoc()['SUBCOUNT'])
        header("Location: catalog.php");
    }
?>
	<link rel="stylesheet" href="../css/dashboard.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="../js/dashboard.js"></script>
    <script src="../js/add_content.js"></script>
    <div class="dashboard">
    <div id="left-panel">
        <div class="user-info">
            <div class="user-image">
            </div>
        </div>
        <div align="center" class="profile-link">
            <p><?php echo $_SESSION["user_info"]["FNAME"]." ".$_SESSION["user_info"]["LNAME"] ?></p>
            <a href="#profile">Edit Profile</a>
        </div>
        <hr>
            <?php if($_SESSION['user_profile']=='student') {
                            echo '<div>
                                    <form action="#" method="POST">
                                        <select name="subject">
                                            <option>--Choose--</option>';
                            $sql="SELECT SUBID,SUBNAME FROM enrollment NATURAL JOIN subject WHERE SID=".$_SESSION["user_info"]["SID"];
                            $subjects=mysqli_query($conn, $sql);
                            while($sub=$subjects->fetch_assoc()) {
                                echo "<option value=".$sub['SUBID'].">".$sub['SUBNAME']."</option>";
                            }
                            echo        '<select>
                                    <button style="border-radius: 10px; background-color:lightgreen" type="submit" name="subject-choice">Select</button>
                                </form>
                            </div>
                        <hr>';
                        } 
                if($_SESSION['user_profile']=='teacher') {
                    $sql="SELECT SUBID,SUBNAME FROM subject WHERE TID=".$_SESSION["user_info"]["TID"];
                    $subject=mysqli_query($conn, $sql)->fetch_assoc();
                }
                ?>
        <div class="navigation-links">
            <?php if($_SESSION['user_profile']=='teacher') echo '<a href="#students">My Students</a>' ?>
            <a href="#meetings">Meetings</a>
            <a href="#notes">Notes</a>
            <a href="#assignments">Assignments</a>
            <a href="#exams">Exams</a>
            <a onclick="signout()" href="logout.php">Sign Out</a>
        </div>
    </div>
    <div align="center" id="main-area">
        <?php
            if($_SESSION['user_profile']=='teacher') {
                echo "<h1>Department Of ".$subject['SUBNAME']."</h1>";
            }
        ?>
        <div class="content active" id="profile">
            <div class="profile-content">
                <h2>Edit Profile</h2>
            </div>
            <div class="profile-image-editor">
            <div class="user-image"></div>
            </div>
            <button class="edit-button">Edit</button>
        </div>
        <div class="content" id="students">
            <h2>Enrolled Students</h2>
                <?php 
                    if($_SESSION['user_profile']=='teacher') {
                        $sub_id=$subject['SUBID'];
                        $sql="SELECT CONCAT(FNAME,' ',LNAME) AS NAME, EMAIL, PHN, ENROLLMENT_DATE FROM STUDENT NATURAL JOIN ENROLLMENT WHERE SUBID=".$sub_id;
                        $students=mysqli_query($conn, $sql);
                        echo '<table class="table table-striped table-bordered table-hover">
                                <thead align="center" class="table-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Contact Number</th>
                                        <th>Enrollment Date</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        while($student=$students->fetch_assoc()) {
                            echo "<tr>
                                    <td>".$student["NAME"]."</td>
                                    <td><a href=mailto:".$student["EMAIL"].">".$student["EMAIL"]."</td>
                                    <td>".$student["PHN"]."</td>
                                    <td>".$student["ENROLLMENT_DATE"]."</td>
                                </tr>";
                        }
                        echo "</tbody>
                            </table>";
                    }
                ?>
        </div>
        <div class="content" id="meetings">
            <h2>Meetings</h2>
                <?php 
                    if(isset($_POST['subject-choice']) || $_SESSION['user_profile']=='teacher') {
                        $sub_id=isset($_POST['subject-choice'])?$_POST['subject']:$subject['SUBID'];
                        $sql="SELECT TOPIC,LINK,DATE_TIME FROM CURRICULUM WHERE SUBID=".$sub_id." AND TYPE='MEETING'";
                        $meetings=mysqli_query($conn, $sql);
                        echo '<table class="table table-striped table-bordered table-hover">
                                <thead align="center" class="table-dark">
                                    <tr>
                                        <th>Topic</th>
                                        <th>Meeting Link</th>
                                        <th>Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        while($meeting=$meetings->fetch_assoc()) {
                            echo "<tr>
                                    <td>".$meeting["TOPIC"]."</td>
                                    <td><a href=".$meeting["LINK"].">".$meeting["LINK"]."</td>
                                    <td>".$meeting["DATE_TIME"]."</td>
                                </tr>";
                        }
                        echo "</tbody>
                            </table>";
                        if($_SESSION['user_profile']=='teacher')
                            echo "<button class='btn btn-primary btn-circle btn-xl' style='border-radius: 50px' onclick='addform()'><b>+</b></button>";
                    }
                ?>
        </div>
        <div class="content" id="notes">
            <h2>Notes</h2>
                <?php 
                    if(isset($_POST['subject-choice']) || $_SESSION['user_profile']=='teacher') {
                        $sub_id=isset($_POST['subject-choice'])?$_POST['subject']:$subject['SUBID'];
                        $sql="SELECT TOPIC,LINK,DATE_TIME FROM CURRICULUM WHERE SUBID=".$sub_id." AND TYPE='NOTE'";
                        $notes=mysqli_query($conn, $sql);
                        echo '<table class="table table-striped table-bordered table-hover">
                                <thead align="center" class="table-dark">
                                    <tr>
                                        <th>Topic</th>
                                        <th>Link</th>
                                        <th>Upload Time</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        while($note=$notes->fetch_assoc()) {
                            echo "<tr>
                                    <td>".$note["TOPIC"]."</td>
                                    <td><a href=".$note["LINK"].">".$note["LINK"]."</td>
                                    <td>".$note["DATE_TIME"]."</td>
                                </tr>";
                        }
                        echo "</tbody>
                            </table>";
                        if($_SESSION['user_profile']=='teacher')
                            echo "<button class='btn btn-primary btn-circle btn-xl' style='border-radius: 50px' onclick='addform()'><b>+</b></button>";
                    }
                ?>
        </div>
        <div class="content" id="assignments">
            <h2>Assignments</h2>
            <?php 
                    if(isset($_POST['subject-choice']) || $_SESSION['user_profile']=='teacher') {
                        $sub_id=isset($_POST['subject-choice'])?$_POST['subject']:$subject['SUBID'];
                        $sql="SELECT TOPIC,LINK,DATE_TIME FROM CURRICULUM WHERE SUBID=".$sub_id." AND TYPE='ASSIGNMENT'";
                        $assignments=mysqli_query($conn, $sql);
                        echo '<table class="table table-striped table-bordered table-hover">
                                <thead align="center" class="table-dark">
                                    <tr>
                                        <th>Topic</th>
                                        <th>Link</th>
                                        <th>Deadline</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        while($assgn=$assignments->fetch_assoc()) {
                            echo "<tr>
                                    <td>".$assgn["TOPIC"]."</td>
                                    <td><a href=".$assgn["LINK"].">".$assgn["LINK"]."</td>
                                    <td>".$assgn["DATE_TIME"]."</td>
                                </tr>";
                        }
                        echo "</tbody>
                            </table>";
                        if($_SESSION['user_profile']=='teacher')
                            echo "<button class='btn btn-primary btn-circle btn-xl' style='border-radius: 50px' onclick='addform()'><b>+</b></button>";
                    }
                ?>
        </div>
        <div class="content" id="exams">
            <h2>Exams</h2>
            <?php 
                    if(isset($_POST['subject-choice']) || $_SESSION['user_profile']=='teacher') {
                        $sub_id=isset($_POST['subject-choice'])?$_POST['subject']:$subject['SUBID'];
                        $sql="SELECT TOPIC,LINK,DATE_TIME FROM CURRICULUM WHERE SUBID=".$sub_id." AND TYPE='EXAM'";
                        $exams=mysqli_query($conn, $sql);
                        echo '<table class="table table-striped table-bordered table-hover">
                                <thead align="center" class="table-dark">
                                    <tr>
                                        <th>Topic</th>
                                        <th>Link</th>
                                        <th>Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        while($exam=$exams->fetch_assoc()) {
                            echo "<tr>
                                    <td>".$exam["TOPIC"]."</td>
                                    <td><a href=".$exam["LINK"].">".$exam["LINK"]."</td>
                                    <td>".$exam["DATE_TIME"]."</td>
                                </tr>";
                        }
                        echo "</tbody>
                            </table>";
                        if($_SESSION['user_profile']=='teacher')
                            echo "<button class='btn btn-primary btn-circle btn-xl' style='border-radius: 50px' onclick='addform()'><b>+</b></button>";
                    }
                ?>
        </div>
        <div id="addform"></div>
    </div>
    <?php 
        if(isset($_POST['add'])) {
            $topic = $_POST['topic'];
            $link = $_POST['link'];
            $date_time = $_POST['date_time'];
            $type = strtoupper($_POST['type']);
            //echo "$sub_id, $topic, $link, $date_time, $type";
            $sql = "INSERT INTO CURRICULUM VALUES(?,?,?,?,?)";
            $insertion = $conn->prepare($sql);
            $insertion->bind_param('issss',$sub_id, $topic, $link, $type, $date_time);
            //print_r($insertion);
            $insertion->execute();
            echo "<meta http-equiv='refresh' content='0'>";

        }
    ?>
</div>
</body>
</html>