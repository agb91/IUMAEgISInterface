<?php
include '../Globals.php';

session_start(); // Starting Session
if (!strcmp($_SESSION['logged'], "logged") == 0)
{
    header("location: logPage.php");
}
else
{
	$newRoot = $_GET["newRoot"];
	if( strcmp(strtolower(substr($newRoot, 0,4) ), "root") == 0)
	{
		echo $newRoot;

		$myfile = fopen($rootPathFile, "w") or die("Unable to open file! (root) ");

		// write the updated file
		fwrite($myfile, $newRoot);
		fclose($myfile);
		header ("LOCATION: ../../index.php");
	}else
	{
		echo "this is not a root souorce... " . substr($newRoot, 1,4);
	}

	// return to homepage authomatically
} 




?>