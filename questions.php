<?php

    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $database = "c9";
    $dbport = 3306;
    $uid = $_REQUEST['userId'];
    $vid;
     // Create connection
    $db = new mysqli($servername, $username, $password, $database, $dbport);

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 
    if($uid == 0){
    $string;
    $temp = 0;
    while($temp == 0){
    $rdrString = generateRandomString();
    $sql = "SELECT ID FROM users WHERE UID='" .$rdrString ."'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
} else{
    $string = $rdrString;
    $temp = 1;

}
}
$uid = $string;
$vid = 1;
/*$sql = "INSERT INTO users (UID,VID) VALUES('" . $uid ."','" . $vid . "')";
if ($db->query($sql) === TRUE) {
   // echo "New record created successfully";
} else {
   // echo "Error: " . $sql . "<br>" . $conn->error;
} */
 // new user 
        } else {
    $sql ="SELECT VID FROM users WHERE UID='" . $uid ."' ORDER BY VID DESC LIMIT 0, 1";
    $result = $db->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $vid = $row["VID"] +1;
    }
}
} // vid fetteched from database or created for new user
   
function generateRandomString() {
    $length = 10;
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
<html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
      <div class="row"></div>
      <div class="row"></div>
      <div class="row"></div>
      <div class="row"></div>
      <div class="row"></div>
    <div class="row">
      <div class="col s8 offset-s2">
        <div class="card-panel grey darken-3">
            <form class="s8" method="get" action="answer.php">
               
              <?php
              echo ' <input type="hidden" name="userId" value="'.$uid.'">
               <input type="hidden" name="vid" value="'.$vid.'">
              ';
              $sql = "SELECT QID,Question FROM question WHERE VID ='" . $vid ."'";
              $result = $db->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                           
                                $name = $row['QID'] . "value";
            
                            echo '<div class="row">
                                    <div class="col s6 offset-s1">
                                            <span class="white-text">' . $row["Question"] . '</span>
                                        <div class="switch">
                                            <label>
                                              No
                                              <input type="checkbox" name="'.$name.'">
                                              <span class="lever"></span>
                                            Yes
                                            </label>
                                          </div>
                                         </div>
                                        </div>
                            ';}
                        }
              ?>
              <div class="row">
                 <div class="col s4">
                <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                  </button>
                  </form>
        </div>
      </div>
    </div>
    </body>
  </html>