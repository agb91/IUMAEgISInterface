<?php

	include "Globals.php";
	include "PHP/genericFunctions.php";

	echo "alive <br>";

	$file = trim($_GET['file']);
	$gAn = trim( fileReaderGeneral($gAnPathFile) );
	echo "gAn: " . $gAn . "<br>";
	echo "file: " . $file . "<br>";

	if( validateFile($file) == 0 )
	{
		echo "good <br>";
		//$file = 'root' . $gAn . '/'.$file;
		echo $file . "<br>";
		if(!$file){ // file does not exist
		    die('file not found');
		} else {
			echo "Location: http://localhost/Tesi/gAn/". $gAn ."/root/".$file;
			header("Location: http://localhost/Tesi/gAn/". $gAn ."/root/".$file);
		}
	}
	else
	{
		echo "bad";
	}
	

	function validateFile($file)// 0 good 1 bad
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

?>