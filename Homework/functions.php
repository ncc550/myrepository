<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once('include/DE.css');
require_once 'include/DeploymentDB.php' ;

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
		echo "<form action='roles.php' method='post'>";
                echo "<input type='hidden' name='FT' value='ADDROLE'>"  ;
		echo "Role name: <input type='text' name='newrole'><br>";
  		echo "<br><input type='submit' value='Submit'>";
		break ;
	case "CHANGEROLE":
		$USER=$_POST["USER"] ;
		echo "<br><hr><br><font size=5>Modify User $USER roles </font><br><br><hr><br><br>" ;
		// Get list of current user roles
		$userroles=getuserroles($USER);
		// Get list of all avail roles
		$allroles=getallroles("1");
		$aroles=(explode(";",$allroles));
		// Build a list
		echo "<form action='roles.php' method='post'>";
		echo "<input type='hidden' name='FT' value='CHANGEROLE'>"  ;
		echo "<input type='hidden' name='USER' value='$USER'>"  ;
		foreach ($aroles as $eachrole)
		{
  			echo "<input type='checkbox' name='ROLES[]' value='$eachrole' " ;
			if (strstr($userroles, $eachrole))
			{
  				echo "checked='checked'";
			}
			echo ">" . $eachrole . "<br>" ;
		}
  		echo "<br><input type='submit' value='Submit'>";
		echo "</form>";
		break ;
	case "SHOW":
		$utype="ALL" ;
		$html=showusers($utype) ;
		echo $html ;
		break;
	case "AUTH":
		$USER=$_POST["USER"] ;
		echo "<BR>Authorizing $USER" ;
		authorizeuser($USER) ;
		break;
	case "DEAUTH":
		$USER=$_POST["USER"] ;
		if ($USER=="Admin")
		{	
			echo "You cannot de-authorize the Admin user.";
		} else {
			echo "<BR>Unauthorizing $USER" ;
			deauthorizeuser($USER) ;
		}
		break ;
}
?>
