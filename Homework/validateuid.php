<?php
require_once('include/DE.css');
require_once 'include/DeploymentDB.php' ;
error_reporting(1);

/// Establish a DB Connection.   This assumes that the MYSQL daemeon is running.
/// Passed parmaters:  Show DEBUG information = 'true' or 'false'
intializeConnection('false') ;

/// Selects the correct database to use for this code.
/// Passed parmaters:  Show DEBUG information = 'true' or 'false'

selectDatabase('false');

$USER=$_POST["username"];
$PASSWORD=$_POST["password"];
$SB=$_POST["sb"] ;

switch ($SB)
{
	case 0: 
		$rc=lookupuser($USER,$PASSWORD);
		if ($rc==1)
		{
			echo "<br>Return to previous page";
		} else {
			echo "<br><br><hr><font size=5>$USER accessable functions:</font>";
			echo "<hr><br>";
			echo "<form name='myForm' action='functions.php' method='post' >";
			echo "<input type='hidden' name='FT' value='SHOW'>"  ;
			echo "<input type='submit' value='show users'></form>" ;
			echo "<hr><br>";
			if (strpos($rc,"ADMIN"))
			{
				$auth=userauthstate("No");
				if (count($auth)==0)
				{
					echo "All users are Authorized<br><br>";
				} else {
					echo "<form name='myForm' action='functions.php' method='post' >";
					echo "<input type='hidden' name='FT' value='AUTH'>"  ;
					echo "<select name='USER'>" ;
					for ($i=0;$i<count($auth); $i++)
					{
        					$a=$auth[$i] ;
        					echo "<option  value=$a>$a</option>" ;
					}
					echo "</select>";
					echo "<input type='submit' value='Authorize'></form>" ;
				}
				echo "<hr><br>";
				$auth=userauthstate("Yes");
				if (count($auth)==0)
				{
					echo "All users are Unauthorized";
				} else {
					echo "<form name='myForm' action='functions.php' method='post' >";
					echo "<input type='hidden' name='FT' value='DEAUTH'>"  ;
					echo "<select name='USER'>" ;
					for ($i=0;$i<count($auth); $i++)
					{
        					$a=$auth[$i] ;
        					echo "<option  value=$a>$a</option>" ;
					}
					echo "</select>";
					echo "<input type='submit' value='Deauthorize'></form>" ;
				}
				echo "<hr><br>";
				$users=allusers();
				echo "<form name='myForm' action='functions.php' method='post' >";
                                echo "<input type='hidden' name='FT' value='CHANGEROLE'>"  ;
				echo "<select name='USER'>" ;
				for ($i=0;$i<count($users); $i++)
				{
        				$a=$users[$i] ;
        				echo "<option  value=$a>$a</option>" ;
				}
				echo "</select>";
				echo "<input type='submit' value='Modifiy User Roles'></form>";
				echo "<hr><br>";
				echo "<form name='myForm' action='functions.php' method='post' >";
                                echo "<input type='hidden' name='FT' value='ADDROLE'>"  ;
				echo "<input type='submit' value='Add New Roles'></form>";

			}
		}
		break ;
	case 1: 
		$rc=adduser($USER,$PASSWORD);
		if ($rc==0)
			echo "User already exists!" ;
		else
			echo "User Added" ;   
		break ;
}
?>
