      <?php
  $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $database = "c9";
    $dbport = 3306;
    $uid = $_GET['userId'];
    $vid = $_GET['vid'];
    $db = new mysqli($servername, $username, $password, $database, $dbport);
    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    $sql = "SELECT QID,Weightage FROM question WHERE VID='".$vid."'";
     $result = $db->query($sql);
$sum;
$total;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $total += $row['Weightage'] * $row['Weightage'];
    //  echo "Total :" .$total . "\n";
           $name =$row['QID'] . "value";
          $answer = $_GET[$name];
          if($answer == "on"){
              printspecQuestions($row['QID'],$db);
             $answer =1; 
          } else $answer =0;
          if($row['Weightage'] < 0 && $answer ==1){
              $sum += $row['Weightage'] * $row['Weightage'];
          }else if($row['Weightage'] > 0 && $answer ==0){
              $sum += $row['Weightage'] * $row['Weightage'];
          }
        //  echo "sum :" . $sum . "\n";
    }}
    $risk = ($sum/$total)*20;
    updateUser($db,$vid,$uid,$risk);
    $risk= floor($risk);
    printgenrealQuestions($risk,$db);
    
?>

  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body style="background: url('doctor_office-wallpaper-1920x1200.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;">
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
         <div class="container">
              
          <?php
                  ;
                function printspecQuestions($qid,$db){
                $sql1 = "SELECT ResDesc FROM response WHERE QID=".$qid;
              $result1 = $db->query($sql1);
            if ($result1->num_rows > 0) {
             
                while($row1 = $result1->fetch_assoc()) {
                    echo ' <div class="row col s12">
                                <div class="col s6 offset-s3">
                                <div class="card-panel teal">
                                 <input type="checkbox" id="indeterminate-checkbox"/>
                                <span class="white-text">'. $row1['ResDesc'] . '
                             </span>
                                </div>
                                </div>
                        </div>';
                }}
            
    }
 ?>

<?php function printgenrealQuestions($risk,$db) {
$sql = "SELECT ResDesc,Risk FROM response WHERE Risk =" .$risk." OR Risk=".($risk+1)." OR Risk=".($risk-1)." ORDER BY Risk Asc";

 $result = $db->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) { 
      echo '            <div class="row col s12">

                <div class="col s6 offset-s3">
                    <div class="card-panel teal">
                     <input type="checkbox" id="indeterminate-checkbox" name="checkbox'.$row['Risk'].'" />
                        <span class="white-text">' . $row['ResDesc'] . '
          </span>
                    </div>
                </div>
                </div>';
    }}
    }
?>
    </body>
  </html>
<?php function UpdateUser($db,$vid,$uid,$risk){
    $sql = "INSERT INTO users (UID,VID,Risk) Values ('.$uid.','.$vid.','.$risk.')";
    if ($db->query($sql) === TRUE) {
    //echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
} ?> 