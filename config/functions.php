<?php
function filter($data)
	{
	   
	   $data = trim($data); //Removes whitespace or other predefined characters from the left side of a string  ///////// rtrim() - Removes whitespace or other predefined characters from the right side of a string
	   $data = stripslashes($data); ///stripslashes() function removes backslashes 
	   $data = htmlspecialchars($data); ///converts some predefined characters to HTML entities //To convert special HTML entities back to characters, use the htmlspecialchars_decode() function
	   $data= htmlentities($data);
	   return $data;

}
function SQLJoin($data)
	{
	global $dbcon;
	$view = "".$data."";
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
	mysqli_close($dbcon);
	}
function getSingleRow($value, $where, $database, $string) //Getting a Row into database
{
		global $dbcon;
		$kweri = "SELECT ".$value." FROM ".$database." WHERE ".$where." ='".$string."'";
		$view = $dbcon->query($kweri) or trigger_error();
		return mysqli_num_rows($view) >=1 ? mysqli_fetch_array($view, MYSQLI_ASSOC) : FALSE;
}
function SingleQuery($value, $database) // Fetching the data without condition
{
		global $dbcon;
		$kweri = "SELECT ".$value." FROM ".$database."";
		$view = $dbcon->query($kweri) or trigger_error();
		return mysqli_num_rows($view) >=1 ? mysqli_fetch_array($view, MYSQLI_ASSOC) : FALSE;
		
}
function fetchRow($data) // Fetching the data without condition
{
		global $dbcon;
		$kweri = "".$data."";
		$view = $dbcon->query($kweri) or trigger_error();
		return mysqli_num_rows($view) >=1 ? mysqli_fetch_array($view, MYSQLI_ASSOC) : FALSE;
		
}

function fetchWhere($value, $where, $database, $string) // Fetching Data with Condition
{
		/*selecting all data on using 1 where clause*/   
		global $dbcon;
		$view = "SELECT ".$value." FROM ".$database." WHERE ".$where." ='".$string."'";
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

	function UpdateQuery($connection, $tblname, array $set_val_cols, array $cod_val_cols)
	{ //Updating Query
		global $dbcon;
		$i=0;
		foreach($set_val_cols as $key=>$value) {
			$set[$i] = $key." = '".$value."'";
		    $i++;
		}

		$Stset = implode(", ",$set);

		$i=0;
		foreach($cod_val_cols as $key=>$value) {
			$cod[$i] = $key." = '".$value."'";
		    $i++;
		}

		$Stcod = implode(" AND ",$cod);

		if(mysqli_query($connection,"UPDATE $tblname SET $Stset WHERE $Stcod")){
			if(mysqli_affected_rows($connection)){
				echo "";
			}
			else{
				echo "";
			}
		}
		else{
			echo "Error updating record: " . mysqli_error($dbcon);
		}
	}
	function SaveData($table_name, $form_data)
	{ //Saving Data
		global $dbcon;
		$fields = array_keys($form_data);
		$sql = "INSERT INTO ".$table_name."(`".implode('`,`', $fields)."`) VALUES ('".implode("','", $form_data)."')";
		return mysqli_query($dbcon,$sql) or die(mysqli_error());

	
	}

	function fetchAll($value, $database)
	{
			global $dbcon;
			$view = "SELECT ".$value." FROM ".$database."";
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
	function Delete($connection, $tblname, array $val_cols){
		
		$i=0;
		foreach($val_cols as $key=>$value) {
			$exp[$i] = $key." = '".$value."'";
		    $i++;
		}

		$Stexp = implode(" AND ",$exp);

		if(mysqli_query($connection,"DELETE FROM $tblname WHERE $Stexp")){
			if(mysqli_affected_rows($connection)){
				header("location: ".$_SERVER['HTTP_REFERER']."");
			}
			else{
				echo "";
			}
		}
		else{
			echo "";
		}
		
	}


?>