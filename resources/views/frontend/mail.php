<?php
if(isset($_POST)){
    	$name=$_POST['name'];
    	$email=$_POST['email'];
        $phone=$_POST['phone'];
     	$message=$_POST['message'];
        if((strlen($phone))==10  && ((is_numeric($phone))))
            {
             	// Always set content-type when sending HTML email
    			$headers = "MIME-Version: 1.0" . "\r\n";
    			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    			// More headers
    			$headers .= 'From: <'.$email.'>' . "\r\n";
    			$headers .= 'Cc:info.myhindkart@gmail.com' . "\r\n";
    			// the message
    
    			$msg .= "<table style='border:1px solid #000;' border='1' cellspacing='0' cellpadding='10'>
    			<tr>
    			<th>name</th>
    			<th>email</th>
    			<th>phone</th>
    			<th>message</th>
    			</tr>
    			 <tr>
    			 <td>$name</td>
    			 <td>$email</td>
    			 <td>$phone</td>
    			 <td>$message</td>
    			 </tr>
    
    			</table>";
    
    			if(mail("info.myhindkart@gmail.com","$name",$msg,$headers)){
                    header('location: thankyou.php');
    			}
    			else
    			{
    		  	  echo "<script>alert('Some Error Occur!!!')</script>";
    		  	  echo "<script>window.location.href='index.php'</script>";
    		    }
	  	      
 		    }
 		    else
 		    {
 		         echo "<script>alert('please Valid Mobile Number...')</script>"; 
	  	   	     echo "<script>window.location.href='index.php'</script>";
 		    }

        }
        else
        {
            echo "<script>alert('Something Went Wrong!')</script>"; 
        	echo "<script>window.location.href='index.php'</script>";
        }



?>