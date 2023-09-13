<?php
function ForgotPassword($FirstName, $LastName, $EmailAddress,$MiddleName) // Search if the name is duplicated
{		
	global $dbcon;
	$a = "SELECT * FROM accounts WHERE FirstName = '$FirstName' AND LastName='$LastName' AND EmailAddress = '$EmailAddress' AND MiddleName = '$MiddleName'";
	$b = $dbcon->query($a) or trigger_error();
	return mysqli_num_rows($b) >=1 ? mysqli_fetch_array($b, MYSQLI_ASSOC) : FALSE;
	
}
function CheckName($FirstName, $LastName) // Search if the name is duplicated
{		
	global $dbcon;
	$a = "SELECT * FROM accounts WHERE FirstName = '$FirstName' AND LastName='$LastName'";
	$b = $dbcon->query($a) or trigger_error();
	return mysqli_num_rows($b) >=1 ? mysqli_fetch_array($b, MYSQLI_ASSOC) : FALSE;
	
}
function CheckUser($EmailAddress) // Search if the name is duplicated
{		
	global $dbcon;
	$a = "SELECT * FROM accounts WHERE EmailAddress = '$EmailAddress'";
	$b = $dbcon->query($a) or trigger_error();
	return mysqli_num_rows($b) >=1 ? mysqli_fetch_array($b, MYSQLI_ASSOC) : FALSE;
	
}

function login(){
	global $dbcon;
		$UserName = filter($_POST['UserName']);
  		$PassWord = hash('sha256',$_POST['PassWord']);

		$view = "SELECT * FROM accounts WHERE UserName = '$UserName' AND PassWord = '$PassWord'";
		$result=$dbcon->query($view) or die('ERROR:'.mysqli_error());
		$results=array();
		
		if(mysqli_num_rows($result)>=1){
			while($row=mysqli_fetch_object($result)){
				$results[]=$row;
			}
			return $results;
		}
		else
		return 0;
	
}
?>