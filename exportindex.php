<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="jquery.base64.js"></script>
<script type="text/javascript" src="html2canvas.js"></script>
<script type="text/javascript" src="jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="jspdf/jspdf.js"></script>
<script type="text/javascript" src="jspdf/libs/base64.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!--BOOTSTRAP-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<!--Including Script For Exporting Data into different Formats-->
<script type="text/javascript" src="tableExport.js"></script>

<?php
/*
Database Connection
@MySQLi functions allows to access MySQL database servers.
@param1 localhost is hostname
@param2 root is username
@param3 is for password
@param4 name of Database
*/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

 $qry="SELECT * FROM attendance_history";							//Selecting All Data From Attendance History Table
 $result=mysqli_query($conn, $qry);


 $records = array();

 while($row = mysqli_fetch_assoc($result)){ 
	$records[] = $row;
  }

?>

<div class="container">
	<div class="row">
		<div class="btn-group pull-right" style=" padding: 10px;">
			<div class="dropdown">

<!--Drop Down Menu For Choosing Export Format-->
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
     <span class="glyphicon glyphicon-th-list"></span> Dropdown
   
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><a href="#" onclick="$('#employees').tableExport({type:'json',escape:'false'});"> <img src="images/json.jpg" width="24px"> JSON</a></li>
								<li><a href="#" onclick="$('#employees').tableExport({type:'json',escape:'false',ignoreColumn:'[2,3]'});"><img src="images/json.jpg" width="24px">JSON (ignoreColumn)</a></li>
								<li><a href="#" onclick="$('#employees').tableExport({type:'json',escape:'true'});"> <img src="images/json.jpg" width="24px"> JSON (with Escape)</a></li>
								<li class="divider"></li>

								<!--........................................XML and SQL Format......................................-->
								<li><a href="#" onclick="$('#employees').tableExport({type:'xml',escape:'false'});"> <img src="images/xml.png" width="24px"> XML</a></li>
								<li><a href="#" onclick="$('#employees').tableExport({type:'sql'});"> <img src="images/sql.png" width="24px"> SQL</a></li>
								<li class="divider"></li>

								<!--........................................CSV and TEXT Format......................................-->
								<li><a href="#" onclick="$('#employees').tableExport({type:'csv',escape:'false'});"> <img src="images/csv.png" width="24px"> CSV</a></li>
								<li><a href="#" onclick="$('#employees').tableExport({type:'txt',escape:'false'});"> <img src="images/txt.png" width="24px"> TXT</a></li>
								<li class="divider"></li>				
								
								<!--........................................Export To EXCEL,DOC,POWER-POINT......................................-->
								<li><a href="#" onclick="$('#employees').tableExport({type:'excel',escape:'false'});"> <img src="images/xls.png" width="24px"> XLS</a></li>
								<li><a href="#" onclick="$('#employees').tableExport({type:'doc',escape:'false'});"> <img src="images/word.png" width="24px"> Word</a></li>
								<li><a href="#" onclick="$('#employees').tableExport({type:'powerpoint',escape:'false'});"> <img src="images/ppt.png" width="24px"> PowerPoint</a></li>
								<li class="divider"></li>

								<!--........................................PNG and PDF Format......................................-->
								<li><a href="#" onclick="$('#employees').tableExport({type:'png',escape:'false'});"> <img src="images/png.png" width="24px"> PNG</a></li>
								<li><a href="#" onclick="$('#employees').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> <img src="images/pdf.png" width="24px"> PDF</a></li>
								
  </ul>
</div>
		</div>
	</div>	
	<div class="row" style="height:300px !important;overflow:scroll;">
						<table id="employees" class="table table-striped">
				<thead>			
					<tr class="warning">
						<th>Name</th>
						<th>CPF</th>
						<th>Date</th>
						<th>Time</th>
					</tr>
				</thead>
				<tbody>
				<!--Loop For Traversing in all Records-->
				<?php foreach($records as $rec):?>								
					<tr>
						<td><?php echo $rec['Name']?></td>
						<td><?php echo $rec['CPF']?></td>
						<td><?php echo $rec['Date']?></td>
						<td><?php echo $rec['Time']?></td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					</table>
</div>
</div>

</body>
</html>
<script type="text/javascript">
//$('#employees').tableExport();
$(function(){
	//DataTable() selects given table based on given selector
	$('#example').DataTable();		
      }); 
</script>