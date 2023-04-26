<?php
$servername = "localhost";
$usename = "root";
$password = "";
$dbname = "blog_website";

// Create connection
$con = mysqli_connect($servername, $usename, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

  session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: homepage.php");
  exit;
} 
  
$username= $_POST ['username'];
$use_escape= mysqli_real_escape_string ($con, $username);
 $pass =$_POST['pass'];
 $pass_encrypted= md5($pass);

$s = "SELECT * from `register` WHERE username='$username'";
$res_ult = mysqli_query($con, $s);
$r=  "SELECT * from `register` WHERE pass='$pass'";
$outcome= mysqli_query($con, $r);
if(mysqli_num_rows($res_ult) <1){

	echo "<p style='color:red;'>" ."That username doesn't exist!". "</p>";
	include 'patientlogin.php';
}
else if (mysqli_num_rows($outcome) <1) {
echo "<p style='color:red;'>" ."Incorrect password!". "</p>";
	include 'patientlogin.php';
}
else{


	session_start();
               
        // Store data in session variables
         $_SESSION["loggedin"] = true;
           $_SESSION["pass"] = $pass;
            $_SESSION["username"] = $username;                            
                            
           // Redirect user to welcome page
               header("location: welcome.php");
	$reg="INSERT INTO `login` (`username`, `pass`)
	 VALUES ('$username', '$pass_encrypted')";
	mysqli_query($con, $reg); 
							  


	//header('location:homepage.php');
}
