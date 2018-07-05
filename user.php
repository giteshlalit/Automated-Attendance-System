<!-- USER.PHP is page that appears when user successfully LOG IN to the ATTENDANCE PORTAL--> 
<!-- User can check his attendance stats till date in form of figures and Pie Chart-->
<!doctype html>
<html>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
<title>YOUR ATTENDANCE</title>

<!-- BOOTSTRAP-->
<link rel="stylesheet" href="bootstrap_main.css">
<link rel="stylesheet" href="bootstrap_theme.css">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Including javascript file for Piechart in User Portal-->
 <script type="text/javascript" src="chart2.js"></script>
</head>

<style>

/*Styling Pie Chart*/
div.pie
{

	max-width: 100%;
}

body
{
background-color:#eaf7f9;
}

header
{
padding: 0.1em;
color: white;
background-color: #a03131;
clear: left;
text-align: center;
position:fixed;
width:100%;
z-index: 1;
}

footer
{
position:fixed;
color: white;
background-color: #a03131;
clear: both;
text-align: center;
bottom:0;
padding:1px;
width:100%;
}


</style>


<!--.....................PHP for connection to DB and Quering Database.....................................................-->
<?php
	 session_start();
	 										//New Session is started when user Log In to User Portal
/**
* @MySQLi functions allows to access MySQL database servers.
* @param1 localhost is hostname
* @param2 root is username
* @param3 is for password
* @param4 name of Database
*/
	 $conn=new mysqli('localhost','root','','attendance');
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	/* Query for getting total attendance of employee in a particular month*/
	$query1="select count(*) from attendance_history where cpf='$_SESSION[user_cpf]' and date like '2017-06%'";
	$result=$conn->query($query1);
	$data = mysqli_fetch_assoc($result);
	
	/* Query for getting attendance from joining date*/
	$query2="SELECT COUNT(DISTINCT Date) from attendance_history WHERE Date>=(SELECT date FROM attendance_history WHERE cpf='$_SESSION[user_cpf]' LIMIT 1)";
	$result2=$conn->query($query2);
	$data2=mysqli_fetch_assoc($result2);

	/* Query for showing attendance of last 7 days of User*/
	$query3="SELECT Date,Time FROM attendance_history where CPF='$_SESSION[user_cpf]'  order by date DESC limit 7";
	$result3=$conn->query($query3);

 ?>

<!--.....................PHP for Quering Database and Presenting In Calender View...............................................-->
<?php 

$query9="SELECT date from attendance_history where cpf='$_SESSION[user_cpf]'";						//fetching date from database
$result9=$conn->query($query9);
$data9=mysqli_fetch_assoc($result9);

/*
@strtotime() Parse English Date Format to Unix Timestamp
@param1 expects String having English Date Format
*/
$date = strtotime(date("Y-m-d"));

/**
Variable Listing
* @$day only day is parsed from date
* @$month parsed from date
* @$year parsed from date
* @$a array name 
*/											
$a=array(12,15);
$day = date('d', $date);												
$month = date('m', $date);													
$year = date('Y', $date);	


/**
mktime() get UNIX timestamp for a date
* @param1 is for hour
* @param2 is for minute
* @param3 is for second
* @param4 is for month
* @param5 is for day
* @param6 is for year
* @returns timestamp if success

@$firstDay for first Day in Calender day equals to 1
*/
$firstDay = mktime(0,0,0,$month, 1, $year);		

/*
@strftime() formats a local time or date
* @param1 is format
* @param2 is timestamp
* %B is for full Month Name
* D is same as m/d/y
*/
$title = strftime('%B', $firstDay);
$dayOfWeek = date('D', $firstDay);


/*
cal_days_in_month() returns Number of days in a month for specified year
* @param1 specifies calender to be used
* @param2 specifies month in selected calender
* @param3 specifies year in selected calender
*/
$daysInMonth = cal_days_in_month(0, $month, $year);

/* Get the name of the week days */
$timestamp = strtotime('next Sunday');
$weekDays = array();

/* Loop for fetching Weekdays and Timestamp*/
for ($i = 0; $i < 7; $i++) 
{
	$weekDays[] = strftime('%a', $timestamp);
	$timestamp = strtotime('+1 day', $timestamp);
}

// 'w' for numeric representation of day of week
$blank = date('w', strtotime("{$year}-{$month}-01"));
?>


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
          ['Present',parseInt('<?php echo $data['count(*)'];?>')],										//Present days will be equal to Number of present entries in database
          ['absent',parseInt('<?php echo $data2['COUNT(DISTINCT Date)'];?>')-parseInt('<?php echo $data['count(*)'];?>')],						
          //Absent days will be equal to Total Number of days - present entries in database										
         ],false);

        var options = {
		 backgroundColor: '#eaf7f9',
		title: 'ATTENDANCE ANALYSIS',														//title of pie chart
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>



<!--.............................................   PAGE HEADER.................................................-->
  <header>
  <img class="img-responsive" src="abc.jpeg" width="70px" height="70px" align="left" />
  <!--Log Out Button for destroying session and redirecting to the index page-->
  <h2 style="color: #d7eaea">USER PORTAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="dest.php"><button type="submit" value="logout" class="btn btn-danger"><span class="glyphicon glyphicon-off"></span>  LOG OUT</button></a></h2>									
  </header>

 <!--................................................MAIN BODY...................................................-->   
  <body>

  <div class="container-fluid">

    <section style="padding-top: 70px; width: 100%;">
      <div style="background-color: black;" class="row">

      <!--.........................Displaying Details and Attendance Analysis of employee.........................-->
      <div class="col-sm-3"><h3 style="color: #d7eaea">Name: <?php echo $_SESSION['user_name'];?></h3> </div>
      <div class="col-sm-3"><h3 style="color: #d7eaea">CPF: <?php echo $_SESSION['user_cpf'];?></h3> </div>
	  <div class="col-sm-3"><h3 style="color: #d7eaea">DAYS PRESENT: <?php echo $data['count(*)'];?></h3> </div>
	  <div class="col-sm-3"><h3 style="color: #d7eaea">WORKING DAYS:<?php echo $data2['COUNT(DISTINCT Date)'];?></h3> </div>
      <div class="col-sm-4"></div>
     </section>

    <div role="tabpanel" >
  <ul class="nav nav-tabs" role="tablist">

  <!--Displaying attendance of Employee and his teaam which is visible only when he is a team leader-->
    <li class="active"><a href="#live" data-toggle="tab" role="tab">My Attendance</a></li>
       <li ><a href="#transactions" data-toggle="tab" role="tab">My Team</a></li>
       </ul>

    <div id="tabContent1" class="tab-content">
    
    <div class="tab-pane fade in active" id="live">
   	<div class="row">
	<div class="col-sm-6">
	<table class='table table-bordered' style="table-layout: fixed;">
	<tr>
		<th colspan="7" class="text-center"> <?php echo $title ?> <?php echo $year ?> </th>
	</tr>
	<tr>


	<!--PHP for Calender and showing Present and Absent Dates With Different Color-->
		<?php foreach($weekDays as $key => $weekDay) : ?>
			<td class="text-center"><?php echo $weekDay ?></td>
		<?php endforeach ?>
	</tr>
	<tr>

		<?php for($i = 0; $i < $blank; $i++): ?>
			<td></td>
		<?php endfor;?>
		<?php for($i = 1; $i <= $daysInMonth; $i++): ?>
			<?php 
             $f=explode("-",$data9['date']);						//fetching date,month and year figure seperately using explode() function
            $b=@(int)$f[2];
            $fi = mktime(0,0,0,$month, $i, $year);?>


            <!--............Showing Holidays with blue Color................-->
             <?php if(date('D',$fi)=="Sun"||date('D',$fi)=="Sat"): ?>
           		<td style="color:#0553e3" ><strong><?php echo $i ?></strong></td>
            
              <!--..........Showing Present Dates with Green Color...........-->
			<?php elseif($b== $i): 
			 $data9=mysqli_fetch_assoc($result9); ?>
             <td style="color:#19ea46;"><strong><?php echo $i ?></strong></td>

             <!--............Showing Absent Dates with Red Color..............-->
			<?php else: ?>
				<td style="color:#ea2019"><strong><?php echo $i ?></strong></td>
			<?php endif; ?>
			
			<?php if(($i + $blank) % 7 == 0): ?>
				</tr><tr>
			<?php endif; ?>
		<?php endfor; ?>

		<?php for($i = 0; ($i + $blank + $daysInMonth) % 7 != 0; $i++): ?>
			<td></td>
		<?php endfor; ?>
	</tr>

</table>
</div>

<!--Attendance Analysis Using Pie-Chart depicting Present and Absent percentage-->
	<div class="col-sm-2">
	</div>
	<div class="col-sm-6">
	 <div class="pie" id="piechart_3d" style="width: 500px; height: 500px;"></div>
	 </div>
	</div>
	</div>

	   <div class="tab-pane fade" id="transactions">
	   <?php
	   
	   $query4="SELECT team from hierarchy where cpf='$_SESSION[user_cpf]'";
	   $result4=$conn->query($query4);
	        if(mysqli_num_rows($result4)>=1)
	  	          	{?>
	   <table class="table table-hover">
	   <!--Displaying Details of Employee with Attendance %age,Total Working Days and Present Days in a table-->
    <thead>
      <tr>
        <th>Name</th>
        <th>CPF</th>
        <th>Team</th>
        <th>Group</th>
        <th>MOBILE</th>
        <th>Days present</th>
        <th>Total days</th>
        <th>Percentage</th>
        </tr>
    </thead>
    <tbody>

       <!--Use a while loop to make a table row for every Database row-->
	  	          <?php
					while($data4 = mysqli_fetch_assoc($result4))
					{
					  $query5="SELECT name,cpf,mobile from user_info WHERE Team='$data4[team]'";
					  $result5=$conn->query($query5);
					  	while($data5 = mysqli_fetch_assoc($result5)){?>
	  	          <tr>


	  	          	  <!--Quering Database and Fetching Details with Attendance stats-->
	  	              <!--Each table column is echoed in to a td cell-->
	  	              <td><?php echo $data5['name']; ?></td>
	  	              <td><?php echo $data5['cpf']; ?></td>
	  	              <?php $query6 ="SELECT count(*) from attendance_history where cpf='$data5[cpf]'";
	  	                    $result6=$conn->query($query6);
	  	                    $data6=mysqli_fetch_assoc($result6);

	  	                    $query7="SELECT team,organization from user_info where cpf='$data5[cpf]'";
	  	                    $result7=$conn->query($query7);
	  	                    $data7=mysqli_fetch_assoc($result7);
	  	                    ?>
	  	               <td><?php echo $data7['team'];?></td>
	  	               <td><?php echo $data7['organization'];?></td>     
	  	              <td><?php echo $data5['mobile'];?></td>
	  	              <td><?php echo $data6['count(*)']?></td>
	  	              <td><?php echo $data2['COUNT(DISTINCT date)'];?></td>
	  	              <td><?php echo (($data6['count(*)']/$data2['COUNT(DISTINCT date)'])*100)." %";?></td>
	  	          </tr>
	  	          
	          <?php }} ?>
    </tbody>
    </table>

    <?php } else 
    	{
    		/*
    		Message is displayed if You are not a Team/Group Leader
    		*/
    	echo "<h2 align=center>You are not a Team/Group leader</h2>";
    	}?>
	</div>

	</div>
	</div>
    </div>
	</body>

	<!--...............................................PAGE FOOTER.....................................................-->
	<footer>
	<p><strong>© Oil and Natural Gas Corporation Ltd.</strong></p>
	</footer>
	</html>