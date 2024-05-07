<?php session_start();
if(!$_SESSION["logged_in"])
    header("Location: adminlogin.php");
include '../dbms/crud.php';
$connection = new Connection("elearn");
$conn = $connection->get_conn();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="panel.css" rel="stylesheet">
</head>
<body>
    <div class="modal show" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true"> 
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h5 class="modal-title" id="crudModalLabel"> 
                    
                    </h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                        <span aria-hidden="true"> 
                            × 
                        </span> 
                    </button> 
                </div> 
                <div class="modal-body"> 
                    <h6 id="modal_body">
                    
                    </h6> 
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#crudModal" id="submit"> Submit </button> 
                </div> 
            </div> 
        </div> 
    </div>
    <div class="sidebar" align="center">
        <div style="margin-top: 15%">
            <p><img src="../images/user_image.png" class="rounded-circle" width="100"></p>
            <p><b>Admin</b></p>
        </div>
        <hr>
        <div id="edit" style="padding: 3%">
            <a href="" style="color: white; cursor: pointer">Main Menu</a>
        </div>
        <div style="padding: 15%">
            <a href="adminlogout.php">
                <img src="../images/logout.png" class="rounded-circle" width="40">
            </a>
        </div>
    </div>
    <div class="container">
        <div class="box" id="students" style="background-color: #d2f9ff; border-color: #87c1e5">
            <p class="logo" style="background-image: url(../images/student.png);"></p>
            <b style="color: darkslateblue; font-size: x-large">Students</b>
        </div>
        <div class="box" id="teachers" style="background-color: lightgoldenrodyellow; border-color: #d9cb40">
            <p class="logo" style="background-image: url(../images/teacher.png);"></p>
            <b style="color: #7d7419; font-size: x-large">Teachers</b>
        </div>
        <div class="box" id="subjects" style="background-color: #ffdfe4; border-color: #ff99cc">
            <p class="logo" style="background-image: url(../images/subject.png);"></p>
            <b style="color: #d9428e; font-size: x-large">Subjects</b>
        </div>
        <div class="box" id="enrollments" style="background-color: #d1ffd1; border-color: #62c562">
            <p class="logo" style="background-image: url(../images/enrollment.png);"></p>
            <b style="color: #1c741c; font-size: x-large">Enrollments</b>
        </div>
    </div>

    <div class="details" id="students_list">
        <h2 align="center"><b>Students</b></h2>
        <?php 
            $sql = "SELECT SID, CONCAT(FNAME,' ', LNAME) AS SNAME, EMAIL, PHN, STREAM FROM student";
            $students = mysqli_query($conn, $sql);
            echo '<table class="table table-striped table-bordered table-hover">
                    <thead align="center" class="table-dark">
                        <tr>
                            <th>Student Name</th>
                            <th>Email Address</th>
                            <th>Contact No</th>
                            <th>Stream</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
            while($student = $students->fetch_assoc()) {
                echo '<tr>
                        <td>'.$student['SNAME'].'</td>
                        <td>'.$student['EMAIL'].'</td>
                        <td>'.$student['PHN'].'</td>
                        <td>'.$student['STREAM'].'</td>
                        <td align="center"><button name="delete_student" value='.$student['SID'].' class="delete" data-toggle="modal" data-target="#crudModal"></button></td>
                    </tr>';
            }
            echo '</tbody>
            </table>';
        ?>
    </div>

    <div class="details" id="teachers_list">
    <h2 align="center"><b>Teachers</b></h2>
        <?php 
            $sql = "SELECT TID, CONCAT(FNAME,' ', LNAME) AS TNAME, EMAIL, PHN, STREAM FROM teacher";
            $teachers = mysqli_query($conn, $sql);
            echo '<table class="table table-striped table-bordered table-hover">
                    <thead align="center" class="table-dark">
                        <tr>
                            <th>Teacher Name</th>
                            <th>Email Address</th>
                            <th>Contact No</th>
                            <th>Stream</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
            while($teacher = $teachers->fetch_assoc()) {
                echo '<tr>
                        <td>'.$teacher['TNAME'].'</td>
                        <td>'.$teacher['EMAIL'].'</td>
                        <td>'.$teacher['PHN'].'</td>
                        <td>'.$teacher['STREAM'].'</td>
                        <td align="center"><button name="delete_teacher" value='.$teacher['TID'].' class="delete"></button></td>
                    </tr>';
            }
            echo '</tbody>
            </table>';
        ?>
    </div>

    <div class="details" id="subjects_list">
        <h2 align="center"><b>Subjects</b></h2>
        <?php 
            $sql = "SELECT SUBID, SUBNAME, subject.STREAM, CONCAT(FNAME,' ', LNAME) AS TNAME, PRICE, CAPACITY, ENROLLED FROM subject LEFT JOIN teacher ON subject.TID=teacher.TID";
            $subjects = mysqli_query($conn, $sql);
            echo '<table class="table table-striped table-bordered table-hover">
                    <thead align="center" class="table-dark">
                        <tr>
                            <th>Subject Name</th>
                            <th>Stream</th>
                            <th>Teacher Name</th>
                            <th>Price</th>
                            <th>Capacity</th>
                            <th>Enrolled</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            while($subject = $subjects->fetch_assoc()) {
                echo '<tr>
                        <td>'.$subject['SUBNAME'].'</td>
                        <td>'.$subject['STREAM'].'</td>
                        <td>'.$subject['TNAME'].'</td>
                        <td>'.$subject['PRICE'].'</td>
                        <td>'.$subject['CAPACITY'].'</td>
                        <td>'.$subject['ENROLLED'].'</td>
                        <td align="center">
                            <button name="edit_subject" value='.$subject['SUBID'].' class="edit"></button>
                            <button name="delete_subject" value='.$subject['SUBID'].' class="delete"></button>  
                        </td>
                    </tr>';
            }
            echo '</tbody>
            </table>';
        ?>
    </div>
    
    <div class="details" id="enrollments_list">
        <h2 align="center"><b>Enrollments</b></h2>
        <?php 
            $sql = "SELECT SID, CONCAT(FNAME,' ', LNAME) AS SNAME, SUBID, SUBNAME, ENROLLMENT_DATE FROM student NATURAL JOIN enrollment NATURAL JOIN subject";
            $enrollments = mysqli_query($conn, $sql);
            echo '<table class="table table-striped table-bordered table-hover">
                    <thead align="center" class="table-dark">
                        <tr>
                            <th>Student</th>
                            <th>Subject</th>
                            <th>Enrollment Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
            while($enrollment = $enrollments->fetch_assoc()) {
                echo '<tr>
                        <td>'.$enrollment['SNAME'].'</td>
                        <td>'.$enrollment['SUBNAME'].'</td>
                        <td>'.$enrollment['ENROLLMENT_DATE'].'</td>
                        <td align="center"><button name="delete_enrollment" value='.$enrollment['SID'].' class="delete"></button></td>
                    </tr>';
            }
            echo '</tbody>
            </table>';
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // JS
        $(document).ready(function() {
            $('.details').hide();
            $('.box').click(function() {
                $('.box').hide();
                var id = $(this).attr('id');
                $('#'+id+'_list').show();
            });
        });
    </script>
</body>
</html>
