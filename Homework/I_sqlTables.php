<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once 'include/DeploymentDB.php' ;

date_default_timezone_set('America/Los_Angeles');
$today= date("Y-m-d H:i:s" );
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 300);
echo "Hello world";

/// Establish a DB Connection.   This assumes that the MYSQL daemeon is running.
/// Passed parmaters:  Show DEBUG information = 'true' or 'false'
intializeConnection('true') ;  
selectDatabase('true');

$sql="drop table I_MYUSER;" ;
$result=executeSQL($sql,"true");
$sql ="CREATE TABLE I_MYUSER (
	Name VARCHAR(80) NOT NULL ,
	Password varchar(80)  NOT NULL, 
	Authorized ENUM ('Yes', 'No') default 'No' ,
	Roles VARCHAR (512) default 'USER'
) ;" ;
$result=executeSQL($sql,"true");
$sql="drop table I_MYROLES;" ;
$result=executeSQL($sql,"true");
$sql ="CREATE TABLE I_MYROLES (
	ID TINYINT NOT NULL,
	Roletypes VARCHAR(512)  default 'USER;ADMIN;READER;OWNER' 
);";
$result=executeSQL($sql,"true");

adminuser("Admin", "Admin123") ;
rolesetup("1");
?>
