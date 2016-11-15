<?php

function findLastRunAndTime($dirRawFiles)
{
	//echo $dirRawFiles;
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
	return $lastNow . "-" . $lastTime;
}

function getLastTime( $dirRawFiles )
{
	$dataLast = findLastRunAndTime( $dirRawFiles );
	$splittedDataLast = explode ( "-" , $dataLast );
	return $splittedDataLast[ 1 ]; //and I write it
}

function lastRun( $dirRawFiles , $n)
{
	$dataLast = findLastRunAndTime( $dirRawFiles );
	$splittedDataLast = explode ( "-" , $dataLast );
	echo $splittedDataLast[ 0 ]; //and I write it
	echo ", from: <text id = 'lastTime'>" . $splittedDataLast[ 1 ] . "</text>";	
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
    echo "<ul class='nav nav-tabs moveUp'>";
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
		echo "<li onclick='selectDate(" . $i .")' ><a id='link" . $i ."' onclick='setGreen(" . $i .")' class='white' href='#''> " . $dates[ $i ] .  "</a></li>" ;
	}
	echo "</ul>";
                    
}

function writeInitialOptions()
{
	//the row that asks the user what modality (single vs multiple run) he prefers
	echo "<div id='chooseModality' class='row'>";
	echo "<h3 class = 'center' > Choose your modality: Single Runs vs Multiple Runs</h3>";
	echo "<div class='col-xs-4'></div>";
	echo "<div class='col-xs-4'>";
	
	/*echo "<ul class='nav navbar-nav full'>";
    echo "<li id='choice0' class='well well-sm greenWell half' onclick='selectSingleVsMultiple(0)'><div class='blackText'>Work with a Single Run</div></li>";
    echo "<li id='choice1' class='well well-sm greenWell half' onclick='selectSingleVsMultiple(1)'><div class='blackText'>Work with Multiple Runs</div></li>";
    echo "</ul>";*/
    echo "<div class='row'>";
    echo "<div class = 'col-xs-6' >";
    echo "<button id='choice0' class='btn btn-primary center' onclick='selectSingleVsMultiple(0)'> Work with a Single Run </button>";
  	echo "</div>";
  	echo "<div class = 'col-xs-6' >";
  	echo "<button id='choice1' class='btn btn-primary center' onclick='selectSingleVsMultiple(1)'> Work with Multiple Runs </button>";
    echo "</div>";
    echo "</div>";
    
    echo "</div>";
    echo "<div class='col-xs-4'></div>";
    echo "</div>";

    // the rows that allows the user to change modality (single vs multiple run)
    echo "<div hidden id='changeModality' class='row' >";
    echo "<div class='col-xs-4'></div>";
	echo "<div class='col-xs-4'>";
	echo "<button id='nowSingle' class='btn btn-primary center' onclick='changeModality()'>Return to \"Choose Modality\" Single vs Multiple</button>";
  	echo "<button id='nowMultiple' class='btn btn-primary center' onclick='changeModality()'>Return to \"Choose Modality\" Single vs Multiple</button>";
    echo "</div>";
    echo "<div class='col-xs-4'></div>";
    echo "</div>";
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

function readAnalyzes( $allAnalyzesSingle , $n)
{
	//echo "---" . $allAnalyzesSingle . "---";
	$analyzes = scandir( $allAnalyzesSingle );
	$cleanAnalyzes = [];
	
	if( $n == 0 )
	{
		echo "<div id='analyzesSingle' hidden>";
    }
    else
    {
    	echo "<div id='analyzesMultiple' hidden>";
    }
    for ( $i = 0 ; $i < count( $analyzes ) ; $i++ )
	{
		if ( substr( $analyzes[ $i ] , -2 ) == ".C")
		{
			$toAdd = $analyzes[ $i ];
			$toAdd = substr( $toAdd , 0 , ( strlen( $toAdd ) - 2 ) );
			array_push( $cleanAnalyzes , $toAdd );
			echo $toAdd . "--";
		}
	}
	echo "</div>";
	echo "<div class='dropdown col-xs-12'>";
	if( $n == 0 )
	{
		echo "<button id='buttonSelectAnalysisSingle' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Select an Analysis Tools:";
	}
	else
	{
		echo "<button id='buttonSelectAnalysisMultiple' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Select an Analysis Tools:";
	}
    echo "<span class='caret'></span></button>";
    echo "<ul class='dropdown-menu'>";
    for ( $i = 0 ; $i < count( $cleanAnalyzes ) ; $i++ )
	{
		echo "<li><a href='#' onclick='setAnalysis(" . $i . " , " . $n . ")'>" . $cleanAnalyzes[ $i ] . "</a></li>";    
	}
    echo "</ul>";
    echo "</div>"; 
    echo "<p hidden>";
    if( $n == 0 )
    {
    	echo "<input type='text' id='selectedAnalysisSingle' name='selectedAnalysisSingle' class='form-control'>";
    }
    else
    {
    	echo "<input type='text' id='selectedAnalysisMultiple' name='selectedAnalysisMultiple' class='form-control'>";	
    }
    echo "</p>";
    

}

?>
