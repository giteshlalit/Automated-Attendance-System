<!--LIVE.PHP shows Users that are currently present and connected to WI-FI-->

<!doctype html>
<html>
<head>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="mybootstrap_main.css" rel="stylesheet" type="text/css">

<!--BOOTSTRAP-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
 
 <style type="text/css">
	
	body {

		background-color: #eaf7f9;
}
</style>

 <script type="text/javascript">setTimeout(function(){												//Page Refreshes Automatically after every 4 Seconds
	location =''
},4000);
</script>

<?php
/*
Database Connection
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

	$query2="SELECT user_info.Name,user_info.CPF from user_info INNER JOIN live_mac on user_info.mac=live_mac.mac ";				//Querying Details of Employees Which are currently connected to WI-FI
	$result2=$conn->query($query2);
	
	?>



<div class="container-fluid">

 <!--................................................MAIN BODY...................................................--> 
<body>
<table class="table table-hover" id="live1">
    <thead>
      <tr>
        <th>Name</th>
        <th>CPF</th>
        </tr>
    </thead>
    <tbody>

       <!--Use a while loop to make a table row for every Database row-->
	  	          <?php  while($data2 = mysqli_fetch_assoc($result2)){?>
	  	          <tr>

	  	              <!--Each table column is echoed in to a td cell-->
	  	              <td><?php echo $data2['Name']; ?></td>
	  	              <td><?php echo $data2['CPF']; ?></td>
	  	            </tr>

	          <?php } ?>
    </tbody>
  </table>
 
  </body>
  </div>
  </html>