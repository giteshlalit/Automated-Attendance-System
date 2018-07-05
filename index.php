<!--INDEX.PHP is index page for the attendance portal and we can access complete portal from here-->
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--BOOTSTRAP-->
<link rel="stylesheet" href="bootstrap_main.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<style>

body
{
background-color:#eaf7f9;
}

header{
    padding: 0.5em;
    color: white;
    background-color: #a03131;
    clear: left;
    text-align: center;
	max-width:100%;
}

footer{
    position:fixed;
    color: white;
    background-color:#a03131;
    clear: both;
    text-align: center;
	bottom:0;
	padding:0.2em;
	width:100%;
}

img{
	
	max-width:100%;
}
.borderless td, .borderless th {
    border: none;
}
/* Animations */
.animate
{
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s;
}

@-webkit-keyframes animatezoom
{
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}

@keyframes animatezoom
{
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

</style>

<!--..........................Script for show password on mouse hover...........................................-->
		<script>
		function mouseoverPass(obj) {
		  var obj = document.getElementById('password');
		  obj.type = "text";
		}
		function mouseoutPass(obj) {
		  var obj = document.getElementById('password');
		  obj.type = "password";
		}
		</script>
<!--.....................On Mouse Hover Password Object Type is converted to Text Object Type.....................-->

<!--.....................PHP for connection to Database and LOGIN......................................................-->
		<?php
		/*
		@MySQLi functions allows to access MySQL database servers.
		@param1 localhost is hostname
		@param2 root is username
		@param3 is for password
		@param4 name of Database

		*/
		  $conn=new mysqli('localhost','root','','attendance');
		  if ($conn->connect_error) {
		  	    die("Connection failed: " . $conn->connect_error);
		  	}
		  session_start();
		  if($_POST)
		  {
		  	/*
				Variable Listing
		  	*/
		    $c=$_POST["cpfLogin"];
		    $pass=$_POST["password"];
			 $sql = "SELECT * FROM user_info WHERE CPF='$c' and Password='$pass'";
			 $result = mysqli_query($conn,$sql);
			      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			      //$active = $row['active'];
			      $count = mysqli_num_rows($result);				//counts number of rows in result
			       if($count == 1) 
			       {
			       	/*
			       	Session Variables
			       	header sends a raw HTTP header user.php to client
			       	*/
			        $_SESSION["user_cpf"] = $c;
			        $_SESSION["user_name"]=$row['Name'];
			        $_SESSION["user_mac"]=$row['mac'];
			         header("location:user.php");
			       }
			      else {
		    			echo "<script>alert('Invalid CPF or Password')</script>";				//showing alert dialog box
				      }
		   $conn->close();
		}?>

<!--.................................................PAGE HEADER.......................................-->
    <header>
    <img class="img-responsive" src="abc.jpeg" width="70px" height="70px" align="left" />
    <h2 style="color: #d7eaea">ONGC ATTENDANCE PORTAL</h2>
    </header>

 <!--................................................MAIN BODY...................................................-->   
    <body>
	<br/>
	<div class="container-fluid">
	<!--<div class="row" >
	<h3 align="center">WELCOME</h3>
	</div>-->
	<div class="row">
	<div class="col-sm-5">
		<form action="" class="form-horizontal animate" method="POST" id="form1">
		<div class="table-responsive">
			<table class="table borderless">
			 <!--.....................................FILL DETAILS FOR LOGGING IN..................................................-->   
				<tr>
					<td><h4>CPF</h4></td>
					<td><input type="text" class="form-control" name="cpfLogin" placeholder="Enter CPF"></td>
				</tr>
				<tr>
					<td><h4>Password</h4></td>
					<td><input type="password" class="form-control" name="password" id="password" placeholder="Enter Password"></td>
					<td><span class="glyphicon glyphicon-eye-open" onmouseover="mouseoverPass();" onmouseout="mouseoutPass();"></span></td>
				</tr>
				<tr>
					<td><input type="submit" value="LOGIN" class="btn btn-success"></td>

					<!--Link For FORGOT PASSWORD-->
					<td><a href="forgot.php"><h5>Forgot Password?</h5></a></td>

				</tr>
			</table>
		</div>
		</form>

		<!--Link For Admin Log In-->
		<a href="adminlogin.php">Administrator Log In</a>	

		<!--Link For USER REGISTRATION-->
		<h2 class="animate">Not an exisitng user ?</h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="register.php"><button type="submit" class="btn btn-primary animate"><span class="glyphicon glyphicon-user"></span> REGISTER</button></a>

		<!--Link For ONGC ATTENDANCE PORTAL ANDROID APPLICATION DOWNLOAD-->
		<a href="ONGC_Attendance.apk">Download Android App</a>

	 </div>
	 <div class="col-sm-7">
	 <img class="animate" src="pic_1.jpg"/>
	 </div>
	 </div>
	 </div>
	 </body>

<!--.............................................PAGE FOOTER...............................................................-->
<footer>
<p style="color: #d7eaea"><strong>© Oil and Natural Gas Corporation Ltd.</strong></p>
</footer>
</html>
