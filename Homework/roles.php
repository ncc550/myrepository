<?php
require_once('include/DE.css');
require_once('include/DeploymentDB.php') ;
error_reporting(1);

/// Establish a DB Connection.   This assumes that the MYSQL daemeon is running.
/// Passed parmaters:  Show DEBUG information = 'true' or 'false'
intializeConnection('false') ;

/// Selects the correct database to use for this code.
/// Passed parmaters:  Show DEBUG information = 'true' or 'false'

selectDatabase('false');

$FT=$_POST["FT"];

switch ($FT)
{
	case "ADDROLE":
		addnewrole("1",$_POST["newrole"]);
		echo "A new role has been added" ;
		break ;
	case "CHANGEROLE":
		$USER=$_POST["USER"];
		$CHECKED=$_POST["ROLES"];
		if(empty($CHECKED))
  		{
    			echo("You didn't select any roles.");
  		} else {
			$str="";
			foreach($CHECKED as $check)
			{
				$str=$str . $check . ";" ;
			}
			updateroles($USER,$str) ;
			echo "$USER roles have been modified" ;
			break ;
  		}
}
?>
