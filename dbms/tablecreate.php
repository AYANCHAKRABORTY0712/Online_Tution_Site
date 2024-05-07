<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Elearn";

$conn = new mysqli($servername, $username, $password, $database);

if($conn -> connect_error) {
    die("Connection failed:". $conn -> connect_error);
}

$sql = "CREATE TABLE STUDENT (
            SID INTEGER(3) AUTO_INCREMENT PRIMARY KEY,
            FNAME VARCHAR(20) NOT NULL,
            LNAME VARCHAR(20) NOT NULL,
            EMAIL VARCHAR(20) NOT NULL,
            PHN VARCHAR(15) NOT NULL,
            STREAM VARCHAR(20) NOT NULL,
            PASS CHAR(128) NOT NULL
    );";
if($conn -> query($sql) === TRUE)
    echo "Student Table Created Successfully!<br>";
else
    echo "Error creating table: ".$conn->error."<br>";

$sql="CREATE TABLE TEACHER (
        TID INTEGER(3) AUTO_INCREMENT PRIMARY KEY,
        FNAME VARCHAR(20) NOT NULL,
        LNAME VARCHAR(20) NOT NULL,
        EMAIL VARCHAR(20) NOT NULL,
        PHN VARCHAR(15) NOT NULL,
        STREAM VARCHAR(20) NOT NULL,
        PASS CHAR(128) NOT NULL
);";
if($conn -> query($sql) === TRUE)
echo "Teacher Table Created Successfully!<br>";
else
echo "Error creating table: ".$conn->error."<br>";

$sql="CREATE TABLE SUBJECT (
        SUBID INTEGER(3) AUTO_INCREMENT PRIMARY KEY,
        SUBNAME VARCHAR(30) NOT NULL,
        STREAM VARCHAR(20) NOT NULL,
        PRICE INTEGER(4) NOT NULL,
        CAPACITY INTEGER(3) NOT NULL,
        ENROLLED INTEGER(3) NOT NULL,
        TID INTEGER(3),
        FOREIGN KEY (TID) REFERENCES TEACHER(TID)
);";
if($conn -> query($sql) === TRUE)
echo "Subject Table Created Successfully!<br>";
else
echo "Error creating table: ".$conn->error."<br>";

$sql="CREATE TABLE ENROLLMENT (
    SID INTEGER(3) NOT NULL,
    SUBID INTEGER(3) NOT NULL,
    ENROLLMENT_DATE DATE NOT NULL,
    FOREIGN KEY (SID) REFERENCES STUDENT(SID),
    FOREIGN KEY (SUBID) REFERENCES SUBJECT(SUBID)
);";

if($conn -> query($sql) === TRUE)
echo "Enrollment Table Created Successfully!<br>";
else
echo "Error creating table: ".$conn->error."<br>";

$sql="CREATE TABLE CURRICULUM (
    SUBID INTEGER(3) NOT NULL,
    TOPIC VARCHAR(60) NOT NULL,
    LINK VARCHAR(255) NOT NULL,
    TYPE VARCHAR(15) NOT NULL,
    DATE_TIME DATETIME,
    FOREIGN KEY (SUBID) REFERENCES SUBJECT(SUBID)
);";

if($conn -> query($sql) === TRUE)
echo "Curriculum Table Created Successfully!<br>";
else
echo "Error creating table: ".$conn->error."<br>";

$sql="CREATE TABLE TEACHER_APPLICATIONS (
    TID INTEGER(3) NOT NULL,
    SUBID INTEGER(3) NOT NULL, 
    DATE_TIME DATETIME,
    FOREIGN KEY (TID) REFERENCES SUBJECT(TID),
    FOREIGN KEY (SUBID) REFERENCES SUBJECT(SUBID)
);";

if($conn -> query($sql) === TRUE)
echo "Teacher_Applications Table Created Successfully!<br>";
else
echo "Error creating table: ".$conn->error."<br>";

$conn->close();
?>