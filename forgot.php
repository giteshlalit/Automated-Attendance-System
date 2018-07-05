<!--Forgot Password Page is for Retrieving Password which is sent to Registered Contact Number when needed via Way2SMS--> 

<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>

	<!---BOOTSTRAP-->
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
</style>


<!--sms.php is included for sending password to registered Mobile Number-->
<!--.....................PHP for connection to Database ...........................-->
<?php
include('sms.php');
/*
@MySQLi functions allows to access MySQL database servers.
@param1 localhost is hostname
@param2 root is username
@param3 is for password
@param4 name of Database
*/
$conn=new mysqli('localhost','root','','attendance');
	if ($conn->connect_error) 												//Shows error if Connection Failed
	{
	    die("Connection failed: " . $conn->connect_error);
	}
	if($_POST)																//$_POST is associative array to access information using POST method
	{
		$m=$_POST["mac"];
		$sql="SELECT Password,mobile from user_info where mac='$m'";	
		$result=$conn->query($sql);
		$data=mysqli_fetch_assoc($result);
		/*
		sendWay2SMS function used for sending message
		@$msg is Message to be send
		@param1 Username registered on WAY2SMS
		@param2 Password
		@param3 Mobile Number of Particular Employee

		*/
		$msg="Your Password for Login is ".$data['Password'];								
		sendWay2SMS ( '7500337981' , '12345678' , $data['mobile'], $msg);
		}
?>

<!--.............................................   PAGE HEADER.................................................-->
 <header>
    <img class="img-responsive" src="abc.jpeg" width="70px" height="70px" align="left" />
    <h2 style="color: #d7eaea">ONGC ATTENDANCE PORTAL</h2>
    </header>

<!--................................................MAIN BODY...................................................-->  
<body>
<div class="container-fluid">
<div class="col-sm-3"></div>
<div class="col-sm-6">
<h3 align="center">Enter your mac address to get password</h3>
<form action="" class="form-horizontal" method="POST" id="form1">
		<div class="table-responsive">
			<table class="table borderless">
				<tr>
					<td><h4>MAC</h4></td>
					<td><input type="text" class="form-control" name="mac" placeholder="Enter MAC"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="submit" class="btn btn-success"></td>
				</tr>
			</table>
		</div>
		</form>
		</div>
		<div class="col-sm-3"></div>

<!--...............................................PAGE FOOTER.....................................................-->
		<footer>
<p style="color: #d7eaea"><strong>© Oil and Natural Gas Corporation Ltd.</strong></p>
</footer>
</body>

</html>