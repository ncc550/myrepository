<?php

$con = false;
$host='127.0.0.1';
$user='root' ;
$pass='root' ;
$dbname='DeploymentEngine';

function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}

function intializeConnection($DEBUG) {
        global $con;
	global $host ;
	global $user ;
	global $pass ;
	global $dbname ;
	if ($DEBUG=='true') {
   	echo "<br>Intialize Connection in progress.... ";
	}
        if( $con )
            return $con;
	if ($DEBUG=='true') {
   		 echo "mysqli_connect($host, $user, $pass, $dbname)... ";
	}
        $con = mysqli_connect( $host, $user, $pass, $dbname) or die('Could not connect to server.' );
	if ($DEBUG=='true') {
   	echo "<br>Intialize Connection Completed<br>";
	}
        return $con;
}


function executeSQL($sql,$DEBUG) {
	global $con ;
	if ($DEBUG=='true') {
   		 echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;Execute:  $sql";
	}
	$result=mysqli_query($con,$sql);
	if (!$result)
	{
		die('<br>Error: ' . mysqli_error($con));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;Non-fatal Error: " . mysqli_error()  ;		
	} else {
		if ($DEBUG=='true') echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;Success!"  ;
		return $result ;
	}
}


function selectDatabase($DEBUG) {
	global $con;
	global $dbname;
        mysqli_select_db($con,$dbname) or die('Could not select database.');
	if ($DEBUG=='true') {
	echo "<hr>Database $dbname Selected<hr>" ;
	}
}

function adduser($USER,$PASSWORD)  /* Create User */
{
	$sql="select * from I_MYUSER where Name='$USER' ;" ;
	$result=executeSQL($sql,"false");
	$i = mysqli_num_rows($result);
	if ($i==1) 
	{
		return 0 ;
	}
	$sql="insert into I_MYUSER (Name,Password) values ('$USER','$PASSWORD') ;" ;
	$result=executeSQL($sql,"false");
	return 1 ;
}

function lookupuser($USER,$PASSWORD)    /*Authtenicate*/
{
	$sql="select * from I_MYUSER where Name='$USER' ;" ;
	$result=executeSQL($sql,"false");
	$i = mysqli_num_rows($result);
	switch ($i)
	{
		case 0:
			echo "There is no user $USER in the Database" ;
			return 1;
			break ;
		case 1:
			$sql="select * from I_MYUSER where Name='$USER' and Password='$PASSWORD' ;";
			$result=executeSQL($sql,"false");
			$i = mysqli_num_rows($result);
			if ($i==1) 
			{
				$row = mysqli_fetch_assoc($result) ;
				$auth=$row["Authorized"];
				if ($auth=='No')
				{
					echo "You have not been authorized";
					return 1;
				}
				$roles=$row["Roles"];
				return $roles ;
			} else {
				echo "Invalid Password!" ;
				return 1;
			}
			break;
	}
}

function showusers($utype)
{
        switch($utype)
        {
                case "ALL": $sql="select * from I_MYUSER ;" ;
                            break ;
        }
        $result=executeSQL($sql,"false");
        $i = mysqli_num_rows($result);
        $html="<br><table border=1><tr><th width=200 >Username</th><th width=150>Authorized</th><th width=200 >Roles</th></tr>" ;
        if ($i > 0)
        {
                while ($row = mysqli_fetch_assoc($result))
                {
                        $html=$html .  "<tr><td>" . $row['Name'] ."</td>";
                        $html=$html .  "<td>" . $row['Authorized'] ."</td>";
                        $roles=$row['Roles'] ;
                        $roles=str_replace(";"," ",$roles);
                        $html=$html .  "<td>" . $roles ."</td>";
                        $html=$html .  "</tr>" ;
                }
        }
        $html=$html .  "</table>" ;
        return $html ;
}

function rolesetup($val)  /* This table is can be for future relational table */
{
        $sql="insert into I_MYROLES (ID, Roletypes) values ('$val','USER;ADMIN;READER;OWNER') ;" ;
        $result=executeSQL($sql,"false");
}

function adminuser($USER,$PASSWORD)  /* Create admin uswer */
{       
        $sql="select * from I_MYUSER where Name='$USER' ;" ;
        $result=executeSQL($sql,"false");
        $i = mysqli_num_rows($result);
        if ($i==1)
        {       
                echo "User already exists!" ;
                return ;
        }
        $sql="insert into I_MYUSER (Name,Password,Authorized,Roles) values ('$USER','$PASSWORD','Yes','USER;ADMIN;READER;OWNER') ;" ;
        $result=executeSQL($sql,"false");
}
;
function authorizeuser($USER)
{
        $sql="update I_MYUSER set Authorized='Yes' where Name='$USER' ;" ;
        $result=executeSQL($sql,"false");
}

function deauthorizeuser($USER)
{
        $sql="update I_MYUSER set Authorized='No' where Name='$USER' ;" ;
        $result=executeSQL($sql,"false");
}

function userauthstate($state)
{
	$myusers=array() ;
	$sql= "select * FROM I_MYUSER where Authorized='$state'; ";
	$result=executeSQL($sql,"false");
	$i = mysqli_num_rows($result);
	if ($i > 0)
	{
        	while ($row = mysqli_fetch_assoc($result))
        	{
                	array_push($myusers,$row["Name"]) ;
        	}
	}
	return $myusers ;
}

function allusers()
{
	$myusers=array() ;
	$sql= "select * FROM I_MYUSER ; ";
	$result=executeSQL($sql,"false");
	$i = mysqli_num_rows($result);
	if ($i > 0)
	{
        	while ($row = mysqli_fetch_assoc($result))
        	{
                	array_push($myusers,$row["Name"]) ;
        	}
	}
	return $myusers ;
}

function getuserroles($USER)
{
	$sql= "select Roles  from I_MYUSER where Name='$USER'; ";
        $result=executeSQL($sql,"false");
	$row = mysqli_fetch_assoc($result);
	return($row["Roles"]);
}

function getallroles($val)
{
	$sql= "select Roletypes from I_MYROLES where ID='$val' ; ";
        $result=executeSQL($sql,"false");
	$row = mysqli_fetch_assoc($result);
	return($row["Roletypes"]);
}

function updateroles($USER,$ROLES)
{       
        $sql="update I_MYUSER set Roles='$ROLES' where Name='$USER' ;" ;
        $result=executeSQL($sql,"false");
}
function addnewrole($ID,$newrole)
{       
	$sql= "select Roletypes from I_MYROLES where ID='$ID'; ";
        $result=executeSQL($sql,"false");
	$row = mysqli_fetch_assoc($result);
	$str=$row["Roletypes"];
	$str=$str . ";" . $newrole ;
     	$sql="update I_MYROLES set Roletypes='$str' where ID='$ID' ;" ;
        $result=executeSQL($sql,"false");
}

?>

