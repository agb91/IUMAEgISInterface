<?php

include '../Globals.php';
include 'genericFunctions.php';

session_start(); // Starting Session
if (!strcmp($_SESSION['logged'], "logged") == 0)
{
    header("location: logPage.php");
} 
else
{
	$branch = $_GET["newBranch"];
	$branch = cleanString( $branch );
	//echo $branch;
	// return to homepage authomatically
	//header ("LOCATION: ../../index.php");

	if( strlen($branch) < 20 )
	{
		echo $branch;

		$myfile = fopen($gAnPathFile, "w") or die("Unable to open file! (gAn) ");

		// write the updated file
		fwrite($myfile, $branch);
		fclose($myfile);
		header ("LOCATION: ../../index.php");
	}
	else
	{
		echo "this is not a valid path to gAn... " . substr($newRoot, 1,4);
	}
}




?>