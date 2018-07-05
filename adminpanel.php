
<!---ADMIN PANEL is where we can access Attendance Stats of all the Employees-->
<!--ADMIN can see details of all teams, Export Stats, Change MAC of User-->
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--BOOTSTRAP-->
<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<link href="mybootstrap_main.css" rel="stylesheet" type="text/css">
<link href="mybootstrap_theme.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<script src="js/bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="chart2.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<title>ADMIN PANEL</title>
</head>

<style>
header
{
width:100%;
padding: 0.3em;
color: white;
background-color: #a03131;
clear: left;
text-align: center;
}

body
{
max-width:100%;
background-color:#eaf7f9;
}

footer
{
position:fixed;
color: white;
background-color: #a03131;
clear: both;
text-align: center;
bottom:0;
padding:0.2em;
width:100%;
}

</style>

<?php
$total_days=0;                                          //Variable Listing
$i=0;
/**
Database Connection
* @MySQLi functions allows to access MySQL database servers.
* @param1 localhost is hostname
* @param2 root is username
* @param3 is for password
* @param4 name of Database
*/
  $conn=new mysqli('localhost','root','','attendance');
	if ($conn->connect_error) 
  {
	    die("Connection failed: " . $conn->connect_error);
	}

/*
  Performing Queries against database
  * @mysqli_connect()  Opens new connection to the MySQL server
  * @mysqli_fetch_assoc()  Fetches result row as an associative array
*/
	$query1="select * from user_info";
	$result=$conn->query($query1);
	
	/* Displaying Live Attendance*/
	$query2="SELECT user_info.Name,user_info.CPF from user_info INNER JOIN live_mac on user_info.mac=live_mac.mac ";
	$result2=$conn->query($query2);
	
  /*Quering Databse and fetching Present Days*/
	$query4="SELECT Name,CPF,COUNT(date) FROM attendance_history GROUP BY cpf";
	$result4=$conn->query($query4);
	
  /*Quering Databse and fetching Attendance for Particular Day*/
	$query5="SELECT COUNT(DISTINCT date) FROM attendance_history WHERE date LIKE'2017-06%'";
	$result5=$conn->query($query5);
	$tdays=mysqli_fetch_assoc($result5);

  /*Quering Databse and displaying Attendance Stats Of Employees*/
  $query6="SELECT Name,CPF,COUNT(date) FROM attendance_history GROUP BY cpf";
  $result6=$conn->query($query6);

  /*Quering Databse and displaying Number of employees*/
  $query7="SELECT COUNT(CPF) FROM `user_info` WHERE 1";
  $result7=$conn->query($query7);
  $total_emp=mysqli_fetch_assoc($result7);

  
  //$_GET is associative array to access information using GET method
  if($_GET)
  {
    /* Variable Listing*/      
    @$mac=$_GET["m"];
    @$cpf=$_GET["cpf"];
    $query7="update user_info set mac='$mac' where CPF='$cpf'";           //Updating MAC Address in case Device is Changed
    $result7=$conn->query($query7);
  }

  //$_GET is associative array to access information using GET method
  if($_POST)
  {
    $date=$_POST["date"];
	  $query3="SELECT * FROM attendance_history where date='$date'";         //Displaying all the employees present on a particular day
	  $result3=$conn->query($query3);
  }
     
      while ($data=mysqli_fetch_assoc($result6))
       {
       # Total days is equals to number of records in date column
       $total_days=$total_days + $data['COUNT(date)'];
       }
       /*
       @Count provides Number of records in selected Query
       */
       $avg_days=($total_days/$total_emp['COUNT(CPF)']);
	?>
  

  <!--Google Pie Chart-->
    <script type="text/javascript">
    /**
      * @google.charts.load is for loading libraries for piechart
      * @param 'current' for latest official release of Google Charts to be loaded
      * @param 'corechart' for bar, column, line, area, stepped area, bubble, pie, donut, combo, candlestick, histogram, scatter charts
      * @google.charts.setOnLoadCallback function that will be called once the packages have been loaded

    */
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
         var data = google.visualization.arrayToDataTable([
          ['Task', 'value'],
          ['Present',parseInt('<?php echo $avg_days;?>')],
          ['absent',parseInt('<?php echo $total_emp['COUNT(CPF)'];?>')],
         ],false);

         var options = {
         backgroundColor: '#eaf7f9',
         title: 'ATTENDANCE ANALYSIS',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));                  //visualization's class
        chart.draw(data, options);
      }
</script>



<!--.............................................   PAGE HEADER.................................................-->
<header>
  <img class="img-responsive" src="abc.jpeg" width="70px" height="60px" align="left" />
  <h2 style="color: #d7eaea">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ADMINISTRATOR    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="adminlogin.php"><button type="submit" class="btn btn-danger" value="LOG OUT"><span class="glyphicon glyphicon-off"></span>  LOG OUT</button></h2></a>
  </header>

<!--................................................MAIN BODY...................................................-->   
<body>



<!--.container-fluid class provides a full width container spanning the entire width of the viewport-->

<div class="container-fluid">
<div role="tabpanel" >
  <ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#live" data-toggle="tab" role="tab">Live Attendance</a></li>
       <li ><a href="#transactions" data-toggle="tab" role="tab">Today's transactions</a></li>
	 <li ><a href="#user_info" data-toggle="tab" role="tab">User Info</a></li>
    <li><a href="#check_attendance" data-toggle="tab" role="tab">Check Attendance</a></li>
	 <li><a href="#attendance" data-toggle="tab" role="tab">Attendance</a></li>
   <li><a href="#change" data-toggle="tab" role="tab">Change Mac</a></li>

   <!--Link For Exporting Data into Various Formats-->
   <li><a href="exportindex.php" data-toggle="tab" role="tab">Export</a></li>  

  </ul>
 <div id="tabContent1" class="tab-content">

  <!--LIVE ATTENDANCE tab monitors Employees which are currently connected to WI-FI-->
   <div class="tab-pane fade in active" id="live">
      <iframe src="live.php" height="600" width="1400" style="border:none;"></iframe>                   <!-- Page Refreshes Automatically-->
   </div>

  <!--TRANSACTION provides Check-IN and Check-OUT time of employees -->
   <div class="tab-pane fade" id="transactions">
      <iframe src="user_transaction.php" height="600" width="1400" style="border:none;"></iframe>       
   </div>

 <!--USER_INFO provide essential details of employees-->
	    <div class="tab-pane fade" id="user_info">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>CPF</th>
            <th>MAC</th>
            <th>Mobile</th>
            <th>Group</th>
            <th>Team</th>
          </tr>
        </thead>

          <tbody>
           <!--Use a while loop to make a table row for every Database row-->
    	  	          <?php  while($data = mysqli_fetch_assoc($result)){?>
    	  	            <tr>
    	  	              <!--Each table column is echoed in to a td cell-->
    	  	              <td><?php echo $data['Name']; ?></td>
    	  	              <td><?php echo $data['CPF']; ?></td>
    	  	              <td><?php echo $data['mac']; ?></td>
                        <td><?php echo $data['mobile'];?></td>
                        <td><?php echo $data['Organization'];?></td>
                        <td><?php echo $data['Team'];?></td>
    	  	            </tr>
    	               <?php } ?>
          </tbody>

      </table>
      </div>

      <!--CHECK ATTENDANCE is where employee can check his attendance of a particular day-->
               <div class="tab-pane fade" id="check_attendance">
                  <form name="form1" method="post">
                 <p> <b>Select Date:</b><input type="date" name="date"> <button type="submit" class="btn btn-default">Check</button></p>
                   </form>

            	   <table class="table table-hover">
                <thead>
                 <tr>
                     <form>
                          <!-- print() function prints the contents of the current window--> 
                        <button type="submit" name="print" class="btn btn-primary" onClick="window.print()"><span class="glyphicon glyphicon-print"></span> PRINT</button>
                     </form>


                </tr>
                  <tr>
                    <th>Name</th>
                    <th>CPF</th>
                    <th>Date</th>
                    <th>Time IN</th>
                    <th>Time Out</th>
                    <th>Mins. Worked</th>
                  </tr>
                </thead>
                <tbody>

      <!--Use a while loop to make a table row for every Database row-->
	  	          <?php while($data = @mysqli_fetch_assoc($result3)){?>
	  	          <tr>
	  	              <!--Each table column is echoed in to a td cell-->
	  	              <td><?php echo $data['Name']; ?></td>
	  	              <td><?php echo $data['CPF']; ?></td>
	  	              <td><?php echo $data['Date']; ?></td>
        					  <td><?php echo $data['Time']; ?></td>

                   <?php 
                      /* Fetching OUT TIME of Employee*/
                      $query8="SELECT out1 from user_transaction,user_info WHERE user_info.mac=user_transaction.mac AND cpf='$data[CPF]' AND date LIKE '$data[Date]' AND out1 is NOT NULL ORDER BY out1 DESC LIMIT 1"; 
                      $result8=$conn->query($query8);
                      $data8=mysqli_fetch_assoc($result8);
                     ?>

        	  	      <td><?php echo $data8['out1']; //Displaying Out time of employee
                    ?></td>                  
                   
                   <?php
                   $ttime=0;                    //total time initialization

                   //Quering for Employee Check In and Check Out Time
                   $query10="Select date,in1,out1 from user_transaction where mac in(Select mac from user_info where cpf='$data[CPF]') AND date LIKE '$data[Date]' and out1 is not NULL";
                   $result10=$conn->query($query10);

                   //Quering for Employee work duration
                    while($data10 = mysqli_fetch_assoc($result10))
                    { 
                      $date1=strtotime($data10['date'].' '.$data10['in1']);
                      $date2=strtotime($data10['date'].' '.$data10['out1']);
                                  
                      $y=round($date2-$date1);        //TIME OUT-TIME IN equals to Duration of Work
                      $ttime+=$y;                    //Summing up all duration of work of employee 
                  
                     }
                     $tot_time=($ttime/60);         //@$tot_time is total time in minutes
                  ?>

                  <!--Rounding Up and Displaying Work Duration-->
                  <td><?php echo round($tot_time);?></td>       
                </tr>

        	          <?php 
                    }
                    ?>
        			  </tbody>
                </table>

	     </div>

       <div class="tab-pane fade" id="change">
       <!-- Changing Mac Address in case Device of employee is changed-->
          <br>
                 <form name="form2" method="get">
                 <p> <b>Enter User CPF ID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><input type="text" name="cpf"><br><br>
                 <b>Enter New MAC Address:&nbsp;&nbsp;</b><input type="text" name="m">
                 <br> <button type="submit" class="btn btn-default">Change</button></p>
                 </form>
     </div>

	
  <!--Attendance Stats of User-->
    <div class="tab-pane fade" id="attendance">
     <div class="col-sm-6">
      <table class="table table-hover">
      <thead>
        <tr>
          <th>Name</th>
          <th>CPF</th>
          <th>Days present</th>
          <th>Total days</th>
		      <th>Percentage</th>
          <th>Total mins worked</th>
        </tr>
      </thead>
      <tbody>
       <!--Use a while loop to make a table row for every DB row-->
	  	          <?php  while($data = mysqli_fetch_assoc($result4))
                {
                ?>
	  	          <tr>
	  	              <!--Each table column is echoed in to a td cell-->
	  	              <td><?php echo $data['Name']; ?></td>
	  	              <td><?php echo $data['CPF']; ?></td>
	  	              <td><?php echo $data['COUNT(date)']; ?></td>
					          <td><?php echo $tdays['COUNT(DISTINCT date)'];?></td>
                     <!-- round functions rounds a floating point number-->
                    <td><?php $percentage=($data['COUNT(date)']/$tdays['COUNT(DISTINCT date)'])*100; echo round($percentage)." %"?></td>     

                  <?php $ttime=0;
                  $query10="Select date,in1,out1 from user_transaction where mac in(Select mac from user_info where cpf='$data[CPF]') and out1 is not NULL";
                  $result10=$conn->query($query10);
                  while($data10 = mysqli_fetch_assoc($result10))
                    { 
                  $date1=strtotime($data10['date'].' '.$data10['in1']);
                  $date2=strtotime($data10['date'].' '.$data10['out1']);
                                  
                  $y=round($date2-$date1);
                  $ttime+=$y;
                  
                }
                  $tot_time=($ttime/60);
                ?>
                <td><?php echo round($tot_time);?></td>

                </tr>
	          <?php } ?><?php $conn->close();?>

            <tr>

               <form>
                <!-- print() function prints the contents of the current window--> 
                  <button type="submit" name="print" class="btn btn-primary" onClick="window.print()"><span class="glyphicon glyphicon-print"></span> PRINT</button>
               </form>
            </tr>
       </tbody>
       </table>
        </div>
      <div class="col-sm-6"><div id="piechart_3d" style="width: 600px; height: 600px;"></div>

      </div>
      </div>
    </div>
  </div>
</div>

<!--...............................................PAGE FOOTER.....................................................-->
<footer>
<p style="color: #d7eaea"><strong>© Oil and Natural Gas Corporation Ltd.</strong></p>
</footer>

</body>
</html>