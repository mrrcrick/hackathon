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
 if (!empty($_POST['username'])){
	 $username = $_POST['username'];
	 $fieldsfilled ++;
 }
 if (!empty($_POST['password'])){
	 $password = $_POST['password'];
	 $fieldsfilled ++;

 }
 if (!empty($_POST['email'])){
	 $email = $_POST['email'];
	 $fieldsfilled ++;

 }
 if (!empty($_POST['confirmpassword'])){
	 $confirmpassword = $_POST['confirmpassword'];
	 $fieldsfilled ++;

 }
 // if all fields filled in
if ($fieldsfilled == 4){
	$sql = "SELECT * FROM users WHERE user_name='$username' AND email='$email'";
	$result = $conn->query($sql);
	
	// if username and email dosen't exist insert new user and set user name and id
	if ($result->num_rows == 0){
		$sql = "INSERT INTO users (user_name,password,email) VALUES ('$username','$password','$email')" ;
	    $result = $conn->query($sql);
		// get the user id 
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
   



 

 if(isset($_FILES['image']) && !empty($_FILES['image'])){
	 
	 echo "file found";
      $errors= array();

 if(count($_FILES['image']['name']) > 0){
	 if (isset($_SESSION['userid']))
	 $userid = $_SESSION['userid'];
	for($i=0; $i<count($_FILES['image']['name']); $i++) {
      $file_name[$i] = $_FILES['image']['name'][$i];
      $file_size =$_FILES['image']['size'][$i];
      $file_tmp =$_FILES['image']['tmp_name'][$i];
      $file_type=$_FILES['image']['type'][$i];
      
	  $tmp = explode('.', $_FILES['image']['name'][$i]);
      $file_ext = end($tmp);
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
        // $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
	   // mkdir if not present
	   if (!file_exists("userpictures/$userid")) {
		mkdir("userpictures/$userid", 0777, true);
		}
	  $picturepath = "userpictures/$userid/".$file_name[$i];
	  move_uploaded_file($file_tmp,$picturepath);
		// insert userpicture link into database
		$sql = "INSERT INTO user_pics (picturepath,user_id) VALUES ('$picturepath','$userid')" ;
	    $result = $conn->query($sql);
		header("Location: dashboard.php");
	    die();
		
      }else{
         print_r($errors);
      }
   }
   
 }
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

#addpicturelabel{
  
  margin:auto;	
  width:300px; 
  height:200px; 
  border: 0;
  background:url("images/Add_picture.png");
  background-size: 100%; /* To fill the dimensions of container (button), or */
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  padding:auto;
  font-family: Helvetica, Arial, Sans-Serif;
font-size: 150%;	
color: white;
text-align:center;
line-height:200px;	

	
}

.register
{

 	
}

.register input{
  position: relative;
  display: block;
  margin:auto;
  width:30%; 
  height:20%; 
  border: 0;
  background:url("images/Register_button.png");
  background-size: 100%; /* To fill the dimensions of container (button), or */
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
   	
}





.addpicture input{
  display:none;
   	
}

.signin{
position:relative;
display:inline;
font-family: Helvetica, Arial, Sans-Serif;
font-size: 150%;	
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

</style>

</HEAD>
<BODY>
<br><br>

<div id ="main_form">

<form action="" method="POST" enctype="multipart/form-data">
<div class="title">HACKATHON</div> 
<div class = "signin">
  Username
  <input type = "text" name = "username">
</div>

<div class="space"></div>
<div class = "signin">
  Email
  <input type = "text" name = "email">
</div>
<br>
<br>
<br>
<br>
<br>
<div class = "signin">
  Password
  <input type = "password" name = "password">
</div>

<div class="space"></div>
<div class = "signin">
  Confirm Password
  <input type = "password" name = "confirmpassword">
</div>
<p>
<div class="addpicture">
<label for="addpicture">
 <div id="addpicturelabel">Add picture</div>
</label>
<input id="addpicture" type="file" name="image[]" multiple="multiple"/>
<input id='upload' name="upload[]" type="file" multiple="multiple" />
</div></p>

<div class="register"><input type="submit" name="register" value=""></div>



</form>
</div>


<?php
//echo "<b> TEST </b>";









?>
</BODY>
</HTML>