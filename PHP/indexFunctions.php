<?php

function lastRun($dirRawFiles)
{
	$rawFiles = glob($dirRawFiles . "run_" ."*.*");
	//echo count($rawFiles);
	$lastNow = 0; //it is a number.. but printable by echo without problems
	$lastTime = ""; //it is better manage the time as a string
	for ($i = 0; $i < count($rawFiles); $i++) 
	{
		$thisFile = $rawFiles[$i]; //the structure is like: run_40883-20-07-2016
		// we take the part on the right of '_'
		$firstExploded = explode ( "_" , $thisFile)[1];
		// and after the first chuck splitted by -, that is the run number
		$chuncksVector = explode ( "-" , $firstExploded);
		$runNumberChunck = $chuncksVector[0];
		$timeChunck = $chuncksVector[1] . "/" . $chuncksVector[2] . "/" . $chuncksVector[3];
		//I search for the biggest number
		
		if (($runNumberChunck>$lastNow) == 1)
		{
			$lastNow = $runNumberChunck;
			//echo $lastNow;
			$lastTime = $timeChunck;
		}
	}
	echo $lastNow; //and I write it
	echo ", from: " . $lastTime;
}	

function readText( $url )
{
	$text = file_get_contents( $url );
	return $text;                    
}

function splitText( $rawText )
{
	$result = [];
	$pieces = explode( "date:" , $rawText );
	for ( $i = 1 ; $i < count( $pieces ) ; $i++ )
	{
		array_push( $result , $pieces[$i] );		
	}
	//print_r($pieces);
	return $result;
}

function writeOneChunk( $text )
{
	$rows = explode( ";" , $text );
	for( $i = 0 ; $i < count( $rows ) ; $i++ )
	{
		echo trim( $rows[ $i ] ) . "<br>";
	}
}

function writeDates( $dates )
{
	//first I write all the dates in an hidden space to let javascript see them
	echo "<p id='allDates' hidden>";
	for( $i = 0 ; $i < count( $dates ) ; $i++ )
	{
		echo $dates[$i] . ";-;";
	}
	echo "</p>";
	//after I prepare the navbar that show the dates and allows the users to select them
	for( $i = 0 ; $i < count( $dates ) ; $i++ )
	{
		if( $i == 0 )
		{
			echo "<li onclick='selectDate(" . $i .")' class='active'><a href='#''> " . $dates[ $i ] .  "</a></li>" ;
			//echo "<li onclick='selectDate(" . $i .")'><a href='#'>" . $dates[ $i ] . "</a></li>";
   		}
   		else
   		{
   			echo "<li onclick='selectDate(" . $i .")' class='active'><a href='#''> " . $dates[ $i ] .  "</a></li>" ;
			//echo "<li onclick='selectDate(" . $i .")'><a href='#'>" . $dates[ $i ] . "</a></li>";
   		}
	}
}

function writeChunks( $chunks )
{
	for ( $i = 0 ; $i < count( $chunks ) ; $i++ )
	{
		echo "<p class = 'logBlock' hidden id = 'run" . $i . "' >";
		writeOneChunk( $chunks[ $i ] );
		//echo $chunks[ $i ]; 
		echo "</p>";
	}
}

function getDates( $chunks )
{
	$results = [];
	for ( $i = 0 ; $i < count( $chunks ) ; $i++ )
	{
		$token = substr( $chunks[ $i ] , 0 , 10 );
		array_push( $results , $token );
	}	
	return $results;
}

?>
