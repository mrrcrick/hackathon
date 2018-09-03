<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//logout
if (isset($_GET['logout'])){
	unset($_SESSION['validuser']);
	header("Location: index.php");
	die();
}

// check if valid user
if (!isset($_SESSION['validuser']) && ($_SESSION['validuser']!=1 )){
	header("Location: index.php");
	die();
}

// parse rss for use in news
$i = 0; // counter
$url = "http://feeds.bbci.co.uk/news/rss.xml"; // url to parse
$rss = simplexml_load_file($url); // XML parser
$news ="";
// RSS items loop

foreach($rss->channel->item as $item) {
if ($i < 1) { 
   $news.=$item->title;
}

$i++;
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
	echo "Valid user" ;
	}


}

?>
<HTML>


<HEAD>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<style>
body {
    background-image: url("images/Background.png");
	background-size: cover; /* Resize the background image to cover the entire container */
    background-repeat: no-repeat; /* Do not repeat the image */
	}


.title{
margin-left:20%;
font-family: Helvetica, Arial, Sans-Serif;
font-size: 400%;	
color: white;	
display:inline;

	
}


.row{
	vertical-align:top;
	margin-top:2%;
	margin-left :5%;
	
}
.thumbnail{
     vertical-align:top;
	 font-family: Helvetica, Arial, Sans-Serif;
	font-size: 120%;	
	display:inline-block;
	width:294px;
	height:216px;
	padding:5px;
	text-align: center;
	margin-left:5%;
	background-image: url("images/Container.png");
	background-size: 100%; /* Resize the background image to cover the entire container */
    background-repeat: no-repeat; /* Do not repeat the image */
	
}
.thumbnail img{
	margin-right:30px;
	margin-left:2px;
	padding-left:0px;
	text-align: left;
	
	
}

.thumbnailheading{
	font-size: 130%;	
	font-weight: bold;
	margin-top:10px;
	margin-bottom:15px;
		
}
.weathericon{
	display:inline-block;
	margin-bottom:30px;
}.logout{
	display:inline;
	margin-right:auto;
	
	
}
.logout img{
	width:100px;
	margin:0px;
	
}

</style>

<script>

$(document).ready(function(){ 
var x = document.getElementById("weather");


function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    url = "http://api.openweathermap.org/data/2.5/weather?lat="+position.coords.latitude+"&lon="+position.coords.longitude+"&units=metric&appid=d0a10211ea3d36b0a6423a104782130e";
	$.ajax({
	  url: url,
	  cache: false,
	  success: function(html){
		var weather = html.weather[0].main;
		var weathericon = 'images/Clouds_icon.png';
		if (weather =='Rain'){
		   weathericon = 'images/Rain_icon.png';
		}
		else if(weather =='Sun')
		{
			weathericon = 'images/Sun_icon.png';
		}
		else if(weather =='Cloud')
		{
			weathericon = 'images/Clouds_icon.png';
		}
		x.innerHTML ="<div class='thumbnailheading'>Weather</div><img width='100px'src='"+weathericon+"'> <div class='weathericon'>"+html.main.temp +"<br>Celcius</div>"+
		"<div><b>"+html.name+"</b></div>";


  }
});
}

getLocation();



 
 
 
 
 





 }) ;
</script>


</HEAD>
<BODY>
<div class="logout"><a href="dashboard?logout=true"><img src="images/logout.png" alt="Log out"></a></div>
<div class="title">Good day Swapnil</div>
<div class="row">
<div id="weather" class = "thumbnail"></div>
<div class = "thumbnail"><div class="thumbnailheading">News</div><?php echo "News headline <br> $news";?></div>
<div class = "thumbnail"><div class="thumbnailheading">Sport</div></div>
</div>
<div class="row">
<div class = "thumbnail"><div class="thumbnailheading">Photos</div>
<?php 
    $userpaths = array();
    if (isset($_SESSION['userid'])){
	$userid = $_SESSION['userid'];
    $sql = "SELECT * FROM user_pics WHERE user_id='$userid'";
	$result = $conn->query($sql);
	if($result->num_rows>0){
	 while($row = $result->fetch_assoc()) {
			   $userpaths[] = $row["picturepath"];
			  	   
		}
	
	}
	$count =0;
	foreach ($userpaths as $pictures)
	{
		$userlink = $pictures;
		echo "<img style='width:100px; display:inline;margin-right:10px;'src='$userlink'>";
		$count++;
		if ($count ==3)
			echo "<<br>";
		if ($count==5)
			break;
	}
	
	}?>
</div>
<div class = "thumbnail"><div class="thumbnailheading">Tasks</div></div>
<div class = "thumbnail"><div class="thumbnailheading">Clothes</div></div>
</div>


</BODY>
</HTML>