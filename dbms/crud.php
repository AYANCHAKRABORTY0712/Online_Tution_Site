<?php
    Class Connection {
        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $conn;

        public function __construct($database) {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $database);
        }
        
        public function get_conn() {
            return $this->conn;
        }
    
    }

    class Student {
        private $conn;
        public function __construct($conn){
            $this->conn = $conn;
        }

        public function create($fname, $lname, $email, $phn, $stream, $pass) {
            $sql = "INSERT INTO STUDENT(FNAME, LNAME, EMAIL, PHN, STREAM, PASS) VALUES (?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssss", $fname, $lname, $email, $phn, $stream, $pass);
            $stmt->execute();
        }
    }

    class Teacher {
        private $conn;
        public function __construct($conn){
            $this->conn = $conn;
        }

        public function create($fname, $lname, $email, $phn, $stream, $pass) {
            $sql = "INSERT INTO TEACHER(FNAME, LNAME, EMAIL, PHN, STREAM, PASS) VALUES (?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssss", $fname, $lname, $email, $phn, $stream, $pass);
            $stmt->execute();
        }
    }
    
?>