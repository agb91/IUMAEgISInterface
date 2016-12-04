<?php

	include "Globals.php";
	include "PHP/genericFunctions.php";

	//echo "alive <br>";

	$file = trim($_GET['run']);
	//echo "file: " . $file . "<br>";
	//commit1
	//commiut2
	//commit3

	$file = 'output/gout_' . $file . ".root";
	echo $file;
	if(!$file){ // file does not exist
	    die('file not found');
	} else {
		echo "Location: ".$file;
		header("Location: ".$file);
	}


/*	function validateFile($file)// 0 good 1 bad
	{
		$ris = 0;
		$start = substr($file,0,4);
		$end = substr($file,-12);
		$center = substr($file,5,-12);
		//echo $center."<br>";
		if(strcmp($start, "run_") !== 0 )
		{
			echo $start . "<br>";
			$ris = 1;	
		}
		if(strcmp($end, "_gAnOut.root") !== 0 )
		{
			echo $end . "<br>";
			$ris = 1;	
		}
		if( !is_numeric( $center ) )
	    {
	    	echo $center;
	        $ris = 1 ;    
	    }    
		return $ris;
	}
*/
?>