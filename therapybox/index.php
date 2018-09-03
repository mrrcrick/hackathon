<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['validuser']) && ($_SESSION['validuser']==1)){
	header("Location: dashboard.php");
	die();
}
//conect to the database
$dbservername = "localhost";
$dbusername = "therapybox";
$dbpassword = "therapybox";

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword,'therapybox');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//countfields filled.
$fieldsfilled = 0;
// register user
 if (!empty($_GET['username'])){
	 $username = $_GET['username'];
	 $fieldsfilled ++;
 }
 if (!empty($_GET['password'])){
	 $password = $_GET['password'];
	 $fieldsfilled ++;

 }
 
 if ($fieldsfilled == 2){
	$sql = "SELECT * FROM users WHERE user_name='$username' AND password='$password'";
	$result = $conn->query($sql);
	if($result->num_rows>0){
	 while($row = $result->fetch_assoc()) {
			   $_SESSION['username'] = $row["user_name"];
			   $_SESSION['userid'] = $row["id"];
			   
		}
	$_SESSION['validuser']=1;
	
	}


}

?>
<HTML>


<HEAD>
<style>
body {
    background-image: url("images/Background.png");
	background-size: cover; /* Resize the background image to cover the entire container */
    background-repeat: no-repeat; /* Do not repeat the image */
	}
.login
{
	position:absolute;
	bottom: 30%;
	right: 40%;
	
}
.login input{
  width:300px; 
  height:200px; 
  border: 0;
  background:url("images/Login_button.png");
  background-size: 100%; /* To fill the dimensions of container (button), or */
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
   	
}

.signin{
position:relative;
display:inline;
font-family: Helvetica, Arial, Sans-Serif;
font-size: 200%;	
color: white;	
border-bottom: 2px solid white;
padding-bottom: 5px;

}
.signin input{
	background-color: transparent;
	outline: none;
	font-family: Helvetica, Arial, Sans-Serif;
   font-size: 50%;	
   color: white;	
   border: none;
	
}
.signin input.middle:focus {
    outline-width: 0;
}
#main_form{
	width:70%;
	height:70%;
	display: block;
    margin-left: auto;
    margin-right: auto;
	
	
}
.space{
   width:20%;
   display:inline-block;   
}
.title{
margin-left: auto;
margin-right: auto;
margin-bottom: 7%;	
width: 50%;
font-family: Helvetica, Arial, Sans-Serif;
font-size: 300%;	
color: white;	

	
}

.footertitle{
margin-left: auto;
margin-right: auto;
margin-top:7%;	
width: 50%;
font-family: Helvetica, Arial, Sans-Serif;
font-size: 200%;	
color: white;	

	
}
.signup{
	color: yellow;
}
a:link {
    text-decoration: none;
}

a:visited {
    text-decoration: none;
}

a { color: inherit; } 

</style>

</HEAD>
<BODY>
<br><br>

<div id ="main_form">

<form action="index.php" method="get">
<div class="title">HACKATHON</div> 
<div class = "signin">
  Username
  <input type = "text" name = "username">
</div>

<div class="space"></div>
<div class = "signin">
  Password
  <input type = "password" name = "password">
</div>

<div class="login">
<input type="submit" name="login" value="">
</div>
</form>
</div>
<div class="footertitle"><a href="register.php">New to hackathon? <span class="signup">sign up</span></a><div>

</BODY>
</HTML>