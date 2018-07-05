<!--REGISTER.PHP is the registration page for new Users, where they Register device's MAC Address and set password-->

<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="bootstrap_theme.css" rel="stylesheet" type="text/css">
<link href="bootstrap_main.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

<!--Including Validation javascript file-->
<script src="registration_validation.js" type="text/javascript"></script>



<!--BOOTSTRAP-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<title>Registration</title>

</head>

<!--Script For POPUP that comes as a hint for MAC Address-->
<script type="text/javascript">
	function myFunction()
	 {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");								
	 }
</script>

<style>
header
{
	width:100%;
    padding: 0.5em;
    color: white;
    background-color: #a03131;
    clear: left;
    text-align: center;
	top:0;
}

body
{
 max-width:100%;
background-color:#eaf7f9;
}

/*Styling For POPUP*/
.popup 
{
    position: relative;
    display: inline-block;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
	color:red;
}

/* The actual popup */
.popup .popuptext {
    visibility: hidden;
    width: 160px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 8px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -80px;
}

/* Popup arrow */
.popup .popuptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

/* Toggle this class - hide and show the popup */
.popup .show {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s;
}

footer{
    position:fixed;
    color: white;
    background-color: #a03131;
    clear: both;
    text-align: center;
	bottom:0;
	padding:0em;
	width:100%;
}
</style>

<!--.............................................   PAGE HEADER.................................................-->
<header>
  <img src="abc.jpeg" width="70px" height="70px" align="left" />
  <h2 style="color: #d7eaea">REGISTRATION</h2>
  </header>
  
  <!--.....................PHP for connection to Database and fill in Details to Database............................-->
  <?php
    if($_POST)											
	{
		/*
		Variable Listing
		@$name is Employee's Name
		@$cpf is Employee's CPF ID
		@$mac is Employee Device's MAC Address
		@$mobile is Employee's Mobile Number
		@pass is Password set by Employee
		@team1 is Employee's Team
		$_POST is associative array to access information using POST method
		*/
		$name=$_POST["name"];
		$cpf=$_POST["cpf"];
		$mac=$_POST["mac"];
		$mobile=$_POST["mobile"];
		$pass=$_POST["password"];
		$group=$_POST["group"];
		$team1=$_POST["team"];
		/*
		@MySQLi functions allows to access MySQL database servers.
		@param1 localhost is hostname
		@param2 root is username
		@param3 is for password
		@param4 name of Database
		*/
		$conn=new mysqli('localhost','root','','attendance');
		if ($conn->connect_error)
		    {
			die("Connection failed: " . $conn->connect_error);
			}
			/*
			sql is query for inserting details of employee into Database
			*/
			$sql = "INSERT INTO user_info(name,cpf,mac,password,mobile,Organization,Team)
					VALUES ('$name',$cpf,'$mac','$pass','$mobile','$group','$team1')";

					if ($conn->query($sql) == TRUE)
					 {
						echo "<h2>Thank you for registering</h2>";
						header("Location: http://localhost/naya2/thank.html");					//If Registered Successfully, ThankYou screen appears
					 } 
					 else 
					 {
							//echo <script>alert('MAC address or CPF already taken !!')</script>";
							echo "Error: " . $sql . "<br>" . $conn->error;
					 }
						$conn->close();
		/*
			Group and Team is Displayed of Employee
		*/
  	  	echo $group;					
    	echo $team1;
    }

	?>


 <!--................................................MAIN BODY...................................................--> 
	<body>
	<br>
	<div class="container-fluid">
	<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
	<h4 align="center">Registration Form</h4><br>

		<!--Form Designed for fetching Details From User-->
		 <form class="form-inline" id="form1" name="form1" method="POST" onsubmit="return validate()">
				 <div class="row">
					<div class="col-sm-4">
						<strong>NAME:</strong>
					</div>
				   <div class="col-sm-8">
				   		<input type="text" name="name"  class="form-control" placeholder="Enter Your Name">
					</div>
					<div class="col-sm-4">
						<strong>CPF:</strong>
					</div>
					<div class="col-sm-8">
						<input type="text" name="cpf" class="form-control" placeholder="Enter Your CPF ID">
					</div>
					<div class="col-sm-4">
						<strong>MAC:</strong>
					</div>
					<div class="col-sm-8">

					<!--Hint Popup For MAC Address appears on Click-->
						<input type="text" name="mac" id="mac"  class="form-control" placeholder="Enter MAC Address">&nbsp;&nbsp;&nbsp;<div class="popup" onclick="myFunction()">Click for hint!
  						<span class="popuptext" id="myPopup"> Settings->About Phone->Status->Wifi MAC Address</span>
    </div>
					</div>
					<div class="col-sm-4">
						<strong>GROUP :</strong>
					</div>
					<div class="col-sm-8">

					<!--Drop Down Menu For Selecting Your Group-->
						<select name="group">
							<option value="NONE">--none--</option>
							<option value="IMTEG">IMTEG</option>
							<option value="MM">MM</option>
							<option value="PROC">PROC</option>
							<option value="HR">HR</option>
							<option value="CSSW">CSSW</option>
							<option value="CSMW">CSMW</option>
							<option value="GMS">GMS</option>
							<option value="FIM">FIM</option>
						</select>
					</div>
					<div class="col-sm-4">
						<strong>TEAM :</strong>
					</div>

					<div class="col-sm-8">

					<!--Drop Down Menu For Selecting Your Group-->
						<select name="team">
							<option value="NONE">--none--</option>
							<option value="NONE">--IMTEG--</option>
							<option value="WOM">WOM</option>
							<option value="WOF">WOF</option>
							<option value="KGPG">KGPG</option>
							<option value="CAUV">CAUV</option>
							<option value="AAB">AAB</option>
							<option value="MBA">MBA</option>
							<option value="PPG">PPG</option>
							<option value="SPL">SPL</option>
							<option value="FB">FB</option>
							<option value="NONE">--PROC--</option>
							<option value="OMEGA">OMEGA</option>
							<option value="CGG">CGG</option>
							<option value="PDGM">PDGM</option>
							<option value="GT">GT</option>
						</select>
					</div>

					<div class="col-sm-4">
						<strong>MOBILE NUMBER:</strong>
					</div>

					<div class="col-sm-8">
						<input type="text" name="mobile" id="mobile"  class="form-control" placeholder="Enter Mobile number">
					</div>

					<div class="col-sm-4">
						<strong>CREATE PASSWORD:</strong>
					</div>

					<!--Enter Desired Password-->
					<div class="col-sm-8">
						<input type="password" name="password"  class="form-control" placeholder="Create Your Password">
					</div>

					<!--Confirm Password-->
					<div class="col-sm-4">
						<strong>CONFIRM PASSWORD:</strong>
					</div>
					<div class="col-sm-8">
						<input type="password" id="p2"  class="form-control" placeholder="Confirm Your Password">
					</div>

					<div class="col-sm-4"></div>
					 <div class="col-sm-8">
						<input type="submit" value="REGISTER"class="btn btn-success">

						<!--Reset Button for resetting all entries-->
						<input type="reset" value="RESET" class="btn btn-danger">
					 </div>
				</div>
		</form>
	</div>
	<div class="col-sm-3"></div>
	</div>
	</div>
	</body>

	<!--...............................................PAGE FOOTER.....................................................-->
	<footer>
	<p style="color: #d7eaea"><strong>© Oil and Natural Gas Corporation Ltd.</strong></p>
	</footer>
	</html>