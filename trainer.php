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
  
    $risk= floor($risk);
   
    
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

    <body>
    <h3 class="col s6 offset-s3"><?php echo $risk; ?></h3> 
     
    <form class="col s12" method="post" action="training.php">
      <div class="row">
        <div class="input-field col s6 offset-s3">
          <input name="number" id="number" type="number" class="validate">
          <label for="number">FeedBack</label>
        </div>
        <div class="switch">
    <label>
      minus
      <input type="checkbox" name="yes">
      <span class="lever"></span>
        plus
    </label>
  </div>
        <input type="hidden" name="risk" value=<?php echo $risk; ?>>
        <input type="hidden" name="vid" value=<?php echo $vid; ?>>
  <button class="btn waves-effect waves-light" type="submit" name="action">Submit
    <i class="material-icons right">send</i>
  </button>