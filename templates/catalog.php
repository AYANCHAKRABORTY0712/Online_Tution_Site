<?php include 'header.php' ;
      if(!$_SESSION["logged_in"])
            header("Location: login.php");
      echo "<h4 style='background-color: white; margin-left: 2%'><b>Hi ".$_SESSION["user_info"]["FNAME"].", Welcome to course catalog!</b></h4>";
      $connection = new Connection("elearn");
      $conn = $connection->get_conn();
      $sql="SELECT * FROM SUBJECT WHERE STREAM=?;";
      $query = $conn->prepare($sql);
      $query->bind_param('s',$_SESSION["user_info"]["STREAM"]);
      $query->execute();
      $subjects = $query->get_result();
      $tname="SELECT CONCAT(FNAME,' ',LNAME) AS TNAME FROM TEACHER WHERE TID=";
      //var_dump($_SESSION["user_info"]["SID"]);
?>

<script>
    function detail($subid) {
        const subid = $subid;
        const url = `course_detail.php?subid=${subid}`;
        window.location.href = url;
    }
</script>

<div class="container mt-5 mb-3">
    <div class="row">
        <?php
        while($row=$subjects->fetch_assoc())
        echo '<div class="col-md-4" style="margin-top: 3%" onclick="detail('.$row['SUBID'].')">
            <div class="card p-3 mb-2" style="background-size: contain;background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url(../images/'.$row['SUBNAME'].'.jpg);border-style: double ridge;border-color: black;border-radius: 20px;background-color: azure;">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                    </div>
                    <div class="badge"> <span>'.$row['STREAM'].'</span> </div>
                </div>
                <div class="mt-5">
                    <h3 class="heading">'.$row['SUBNAME'].'<br>Taught By-'.($row['TID']?mysqli_query($conn, $tname.$row['TID'])->fetch_assoc()['TNAME']:'<i>Not Assigned</i>').'</h3>
                    <div class="mt-5">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: '.(100*($row['ENROLLED'])/($row['CAPACITY'])).'%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="mt-3"> <span class="text1">'.$row['ENROLLED'].' Applied <span class="text2">of '.$row['CAPACITY'].' capacity</span></span> </div>
                    </div>
                    <div>
                        <div class="mt-3"> <span class="text1"></span>Price: <span>'.$row['PRICE'].'</span> </div>
                    </div>
                </div>
            </div>
        </div>';
        ?>
    </div>
</div>
      <footer>
        
      </footer>

</body>
</html>