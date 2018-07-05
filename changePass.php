<?php
/*
include function takes text and copies it into file that uses the include function
*/
     include 'config1.php';         
	 
	 // Check whether username or password is set from android	
     if( isset($_POST['cpf']) &&isset($_POST['old'])  &&isset($_POST['new1']))
     {
		  /* Variable Listing
      @old is the old password
      @cpf is the CPF ID of employee
      @new1 is the desired New Password
      */
		  $result='';
	   	  $old = $_POST['old'];
        $cpf = $_POST['cpf'];
        $new1 = $_POST['new1'];
        
		  /*Query database for row exist or not
      @param sql1 is query for getting details of employee 
      */
        $sql1 = "Select * from user_info where cpf=$cpf and password='$old'";
          $stmt=$conn->prepare($sql1);
          $stmt->execute();
          if($stmt->rowCount()==1)                    //Comparing the number of row must be equal to 1
          {
              $sql = "Update user_info set password='$new1' where cpf=$cpf";            //query for changing password
              
              if ($conn->query($sql) == TRUE) 
              {
    			       $result="true";	
              }  
              else
              {
    			  	  $result="false";
              }
          }
          else
              $result="wrong"
		  
		  // Sending result back to android
   		  echo $result;
  	}
	
?>