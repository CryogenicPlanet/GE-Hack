<?php
$servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $database = "c9";
    $dbport = 3306;
    $db = new mysqli($servername, $username, $password, $database, $dbport);
    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
 $risk = $_POST['risk'];
 echo $risk;
 $binaryNumber = $_POST['number'];
 $number = (base_convert($binaryNumber,2,10))/7;

 $on =$_POST['yes'];
 echo $on;
 $vid =$_POST['vid'];
 $sql = "SELECT QID,Weightage FROM question WHERE VID='".$vid."'";
 echo $sql;
     $result = $db->query($sql);
$sum;
$total;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($on=="on"){
     $newWeightage = $row['Weightage'] + $number;
     $sqlUpdate = "UPDATE question SET Weightage='".$newWeightage."' WHERE QID ='".$row['QID']."'";
     echo $sqlUpdate;
      $stmt = $db->prepare($sqlUpdate);
     $stmt->execute();
    } else {
         $newWeightage = $row['Weightage'] - $number;
     $sqlUpdate = "UPDATE question SET Weightage='".$newWeightage."' WHERE QID ='".$row['QID']."'";
     echo $sqlUpdate;
      $stmt = $db->prepare($sqlUpdate);
     $stmt->execute();
    }

 }
    }
 
?>
