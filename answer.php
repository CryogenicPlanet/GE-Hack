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
    $sql = "SELECT QID,Type FROM question WHERE VID='".$vid."'";
     $result = $db->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if($row['Type'] == 0){
           $name =$row['QID'] . "value";
          $answer = $_GET[$name];
          if($answer == "on") $answer = 1;
          $sqlInsert = "INSERT INTO answers (QID,UID,isTrue) VALUES('".$row['QID']."','".$uid."','".$answer."')";
      }else{
           $name =  $row['QID'] . "number";
          $value = $_GET[$name];
          echo "Value =". $value;
          $answer =1;
          if($value!=0) $answer =1;
          $sqlInsert = "INSERT INTO answers (QID,UID,isTrue,Value) VALUES('".$row['QID']."','".$uid."','".$answer."','".$value."')";
      }
      if ($db->query($sqlInsert) === TRUE) {
   // echo "New record created successfully";
} else {
    echo "Error: " . $sqlInsert . "<br>" . $conn->error;
}
    } 
}
$resp = postNode($vid,$uid);
$risk = $resp.patientrisk;
echo $risk;
function postNode($vid,$uid){
    $data = array("vid" => $vid , "uid" => $uid);                                                                    
$data_string = json_encode($data);

$ch = curl_init('https://ge-hack-cryogenicplanet.c9users.io:8080/phpget');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   

//echo curl_exec($ch)."\n";
//curl_close($ch);
 if( ! $result = curl_exec($ch)) 
    { 
        trigger_error(curl_error($ch)); 
    } 
    curl_close($ch); 
    return $result; 
}
?>