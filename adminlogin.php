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

header
{
    padding: 0.5em;
    color: white;
    background-color: #a03131;
    clear: left;
    text-align: center;
	max-width:100%;
}

body
{
background-color:#eaf7f9;                   <!-- RGB value is (234,247,249)-->
}


footer
{
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


<!--.....................PHP for connection to DB and LOGIN......................................................-->
 <?php
/*
Admin login is for logging in to the ADMIN PANEL
@$_POST is an associative array to access all the sent information using POST method.
*/

  if($_POST)
  {
    	$pass=$_POST["password"];											//Variable Listing
	    if($pass == "admin123")												//Log In Condition
	    {
	        header("location:adminpanel.php");
	    }
	    else 
	    {
    			echo "<script>alert('Invalid Password')</script>";
		}
  }
?>

<!--.............................................   PAGE HEADER.................................................-->
  

    <header>
    <img class="img-responsive" src="abc.jpeg" width="70px" height="70px" align="left" />
    <h2 style="color: #d7eaea">ONGC ATTENDANCE PORTAL</h2>
    </header>


 <!--................................................MAIN BODY...................................................-->   
    <div class="container-fluid">
    <body>
	<h2 align="center">Admin Login</h2>
	<form class="form-horizontal" action="" method="post" id="form1">
     	<div class="form-group">
    		<label class="control-label col-sm-6" for="pwd">Password:</label>
    			<div class="col-sm-2"> 
      			<input type="password" class="form-control" name="password" placeholder="Enter password">
    			</div>
  		</div>
   		<div class="form-group"> 
    			<div class="col-sm-offset-6 col-sm-8">
              <!--LOG IN Button-->
      				<button type="submit" class="btn btn-success">Login</button>
    			</div>
  		</div>
	</form>
	</body>
	</div>

<!--...............................................PAGE FOOTER.....................................................-->
<footer>
<p style="color: #d7eaea"><strong>© Oil and Natural Gas Corporation Ltd.</strong></p>
</footer>
</html>
