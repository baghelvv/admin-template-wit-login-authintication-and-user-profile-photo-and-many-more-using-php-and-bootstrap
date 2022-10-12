<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admintemp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$Username = $_REQUEST['Username'];
$Password = MD5($_REQUEST['Password']);
$Email = $_REQUEST['Email'];
$Role = $_REQUEST['Role'];
$Name = $_REQUEST['Name'];
$IP = $_SERVER['REMOTE_ADDR'];
$Token = bin2hex(random_bytes(15));

$_SESSION['Username'] = "$Username";
$_SESSION['Password'] = "$Password";
$_SESSION['Email'] = "$Email";
$_SESSION['Role'] = "$Role";
$_SESSION['IP'] = "$IP";



$sql = "SELECT * FROM `user` WHERE UserName = '$Username' OR Email = '$Email' ";


 
      $res=mysqli_query($conn, $sql);

      if (mysqli_num_rows($res) > 0) {
        
        $row = mysqli_fetch_assoc($res);
         
         
          if($Email == $row["Email"])
        {
              echo '  <script type="text/javascript">
alert("Email already exists Pls Conitiue With Login");
location="login.php";
</script>';
              
              }elseif($Username == $row["UserName"])
    {
      echo '
      <script type="text/javascript">
alert("username  already exists Pls Try Another");
location="Register.php";
</script>'; 
    }
  }
   
else{

$sql = "INSERT INTO `user` (`ID`, `UserName`, `Password`, `Role`, `Status`, `Email`, `Last Login`, `Login Ip`, `User Created Date`, `Modification Date`, `Name`,`token`) VALUES (NULL, '$Username', '$Password', '$Role', 'inactive', '$Email', CURRENT_TIMESTAMP, '$IP', CURRENT_TIMESTAMP, NOW(), '$Name', '$Token')";
	
//	$result = mysqli_query($conn, $sql);
if ($conn->query($sql) === TRUE) {
	echo '
	<script type="text/javascript">
alert("Registered Successfully continue with Login");
location="login.php";
</script>';

} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}

?>