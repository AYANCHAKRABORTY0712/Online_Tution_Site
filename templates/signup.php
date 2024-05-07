<?php 
ob_start();
include 'header.php';
?>
<script src="../js/teacher_additional_info.js"></script>

<?php 
  $sql = "SELECT SUBID, SUBNAME, STREAM FROM subject WHERE TID IS NULL";
  $vacancy = array(
    "Science" => array(),
    "Commerce" => array(),
    "Humanities" => array(),
    "Technology" => array(),
    "Medicine" => array(),
    "Others" => array()
  );
  $subjects = mysqli_query($conn, $sql);
  while($sub = $subjects->fetch_assoc()) {
    $vacancy[$sub["STREAM"]][]=array("id"=>$sub["SUBID"],"subname"=>$sub["SUBNAME"]);
  }
  $json_data = json_encode($vacancy);

// Write the JSON string to a file
  file_put_contents('../vacancy.json', $json_data);
?>

<div class="formbold-main-wrapper">
  <!-- Author: FormBold Team -->
  <!-- Learn More: https://formbold.com -->
  <div class="formbold-form-wrapper">
    <h1 align="center">Application Form</h1><br><br>
    <form action="#" method="POST">
      <div class="formbold-input-flex">
        <div>
          <label for="fname" class="formbold-form-label"> First Name </label>
          <input id="fname" name="fname" type="text" class="formbold-form-input" placeholder="Enter your first name" required>
        </div>

        <div>
          <label for="lname" class="formbold-form-label"> Last Name </label>
          <input id="lname" name="lname" type="text" class="formbold-form-input" placeholder="Enter your second name" required>
        </div>
      </div>

      <div class="formbold-mb-3">
        <div>
            <label for="email" class="formbold-form-label"> Email </label>
            <input id="email" name="email" type="email" class="formbold-form-input" placeholder="Enter your email address" required>
        </div>
      </div>

      <div class="formbold-mb-3">
        <div>
            <label for="phn" class="formbold-form-label"> Phone </label>
            <input id="phn" name="phn" type="tel" class="formbold-form-input" placeholder="Enter your phone no" required>
        </div>
      </div>

      <div class="formbold-form-file-flex">
        <label for="stream" class="formbold-form-label"> Stream </label>
        <select id="stream" name="stream" required>
            <option>--choose one--</option>
            <option value="Science">Science</option>
            <option value="Commerce">Commerce</option>
            <option value="Humanities">Humanities</option>
            <option value="Technology">Technology</option>
            <option value="Medicine">Medicine</option>
            <option value="Others">Others</option>
        </select>
      </div>
      <br>
      <div class="formbold-form-file-flex">
        <label for="designation" class="formbold-form-label"> Select Profile </label>
        <input type = "radio" name = "designation" id = "student" value="student">Student
        <input type = "radio" name = "designation" id = "teacher" value="teacher">Teacher
      </div>
      <br>
      <div id="additional_info"></div>

      <div class="formbold-mb-3">
        <label for="password" class="formbold-form-label">
            Create Password
        </label>
        <input
          type="password"
          name="password"
          id="password"
          class="formbold-form-input"
          required
        >
      </div>

      <div class="formbold-mb-3">
        <label for="passwordcnf" class="formbold-form-label">
            Confirm Password
        </label>
        <input
          type="password"
          name="passwordcnf"
          id="passwordcnf"
          class="formbold-form-input"
          required
        >
      </div>

      <div class="formbold-form-file-flex">
        <input type="checkbox" id="terms" required>
        <label for="checkbox" class="formbold-form-label">
            I agree to the terms ands conditions
        </label>
      </div>
    <div class="formbold-mb-3">
       <button type="submit" name="register" class="formbold-btn">Apply</button>
    </div>
    </form>
  </div>
</div>
<?php
        if(isset($_POST["register"])) {
            $fname=$_POST["fname"];
            $lname=$_POST["lname"];
            $email=$_POST["email"];
            $phn=$_POST["phn"];
            $stream=$_POST["stream"];
            $designation=$_POST["designation"];
            $pass=$_POST["password"];
            $hashed_password = hash('sha512', $pass);
            $conn = new Connection("elearn");
            $conn = $conn->get_conn();
            if($designation=='student'){
              $student = new Student($conn);
              $student->create($fname, $lname, $email, $phn, $stream, $hashed_password);
              $sql="SELECT SID FROM student WHERE EMAIL='$email'";
              //var_dump($sql);
              $sid=mysqli_query($conn, $sql)->fetch_assoc()['SID'];
              $_SESSION["uid"] = $sid;
              $_SESSION["user_profile"] = 'student';
              $_SESSION["logged_in"] = true;
            }
            if($designation=='teacher'){
              $teacher = new Teacher($conn);
              $teacher->create($fname, $lname, $email, $phn, $stream, $hashed_password);
              $sql="SELECT TID FROM teacher WHERE EMAIL='$email'";
              //var_dump($sql);
              $tid=mysqli_query($conn, $sql)->fetch_assoc()['TID'];
              $_SESSION["uid"] = $tid;
              $_SESSION["user_profile"] = 'teacher';
              $_SESSION["logged_in"] = true;

              $subid = $_POST["subject"];
              $date_time = date("Y-m-d");
              $sql = "UPDATE subject SET TID=$tid WHERE SUBID=$subid";
              mysqli_query($conn, $sql);

            }
            header("Location: dashboard.php");
        }
    ?>
</body>
</html>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    background-size: contain;
  }

  .formbold-mb-3 {
    margin-bottom: 15px;
  }

  .formbold-main-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px;
  }

  .formbold-form-wrapper {
    border-style: ridge;
    border-color: skyblue;
    border-width: thick;
    border-radius: 25px;
    margin: 0 auto;
    max-width: 570px;
    width: 100%;
    background: white;
    padding: 40px;
  }

  .formbold-img {
    display: block;
    margin: 0 auto 45px;
  }

  .formbold-input-wrapp > div {
    display: flex;
    gap: 20px;
  }

  .formbold-input-flex {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
  }
  .formbold-input-flex > div {
    width: 50%;
  }
  .formbold-form-input {
    width: 100%;
    padding: 13px 22px;
    border-radius: 5px;
    border: 1px solid #dde3ec;
    background: #ffffff;
    font-weight: 500;
    font-size: 16px;
    color: #536387;
    outline: none;
    resize: none;
  }
  .formbold-form-input::placeholder,
  select.formbold-form-input,
  .formbold-form-input[type='date']::-webkit-datetime-edit-text,
  .formbold-form-input[type='date']::-webkit-datetime-edit-month-field,
  .formbold-form-input[type='date']::-webkit-datetime-edit-day-field,
  .formbold-form-input[type='date']::-webkit-datetime-edit-year-field {
    color: rgba(83, 99, 135, 0.5);
  }

  .formbold-form-input:focus {
    border-color: #6a64f1;
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
  }
  .formbold-form-label {
    color: #07074D;
    font-weight: 500;
    font-size: 14px;
    line-height: 24px;
    display: block;
    margin-bottom: 10px;
  }

  .formbold-form-file-flex {
    display: flex;
    align-items: center;
    gap: 20px;
  }
  .formbold-form-file-flex .formbold-form-label {
    margin-bottom: 0;
  }
  .formbold-form-file {
    font-size: 14px;
    line-height: 24px;
    color: #536387;
  }
  .formbold-form-file::-webkit-file-upload-button {
    display: none;
  }
  .formbold-form-file:before {
    content: 'Upload file';
    display: inline-block;
    background: #EEEEEE;
    border: 0.5px solid #FBFBFB;
    box-shadow: inset 0px 0px 2px rgba(0, 0, 0, 0.25);
    border-radius: 3px;
    padding: 3px 12px;
    outline: none;
    white-space: nowrap;
    cursor: pointer;
    color: #637381;
    font-weight: 500;
    font-size: 12px;
    line-height: 16px;
    margin-right: 10px;
  }

  .formbold-btn {
    text-align: center;
    margin-left: 42%;
    /* margin-right: auto; */
    width: 20%;
    font-size: 16px;
    border-radius: 15px;
    padding: 14px 25px;
    border: none;
    font-weight: 500;
    background-color: #6a64f1;
    color: white;
    cursor: pointer;
    margin-top: 25px;
  }
  .formbold-btn:hover {
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
  }

  .formbold-w-45 {
    width: 45%;
  }
</style>