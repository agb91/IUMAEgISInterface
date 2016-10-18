<?php

	//include 'editConfigFunctionsCommons.php';
	//include 'PHP/editgAnBranchFunctionsCommons.php';
	
function checkForBranches()
{
    //call the rooc data analisys program with the correct arguments by running a bash file
    $command = "./showBranches.sh ";
    $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
        1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        2 => array("pipe", "w")  // stderr is a file to write to
    );
    //proc_open is considered insicure (but php doesn't deprecate it): 
    //but there is no other solution to run a root program from php
    $process = proc_open ($command , $descriptorspec , $pipes);
    fclose($pipes[0]);
    $output =  "" ;
    if(!feof($pipes[1])) //in this pipe normal expected output
    {
        $output .= stream_get_contents($pipes[1]) . "<br>";
    }    
    fclose($pipes[1]);

    if(!feof($pipes[2]))//in this pipe errors in case of crash :(
    {
       $output .= stream_get_contents($pipes[2]) . '<br>';
    }
    fclose($pipes[2]);
    proc_close ( $process );//we have finished
    $pieces = explode("\n", $output);//order the output in rows, not in a unique continuous stream
    
    return $pieces;
}
    
function fileReaderGeneral($path)
{
    $file = $path;
    //echo "opening: ".$file.'<br>';
    $myfile = fopen($file, "r") or die("Unable to open file! (general) ");
    $fileContent = fread($myfile,filesize($file));
    fclose($myfile);
    return trim($fileContent);
}


function isgAnSafe($whichgAn)// 0 is ok, 1 problems
{
    //echo "whichRun: |".$whichgAn."|";
    $ris = 0;
    if( strlen($whichgAn) > 20 )
    {
        //echo "pathname is too long to be real...";
        $ris = 1;
    }
    $acceprableBranches = checkForBranches(); // branches that actually are real branches..
    //print_r($acceprableBranches);
    
    if( !in_array( trim($whichgAn), $acceprableBranches ) )//if it is not a real path stop it
    {
        $ris = 1;
    }

    //echo "the response is: " . $ris . "<br>";

    return $ris;
}

function isPathSafe($sourceRootPathNew)// 0 is ok, 1 problems
{
    $ris = 0;

    // if it not start with root and is too long is a problem...
    if( (strcmp(strtolower(substr($sourceRootPathNew, 0,4) ), "root") !== 0) || strlen($sourceRootPathNew)>12)
    {
        $ris = 1;
    }

    //echo "<br> before: " . $sourceRootPathNew . "<br>";  

    $version = substr($sourceRootPathNew."-", 5, -1);

    //echo "<br> result: " . $version . "<br>";

    // if the version part is not empty or is not a real version is a problem..
    if( (strcmp($version, "" ) !== 0) && (isVersion($version)==1) )
    {
        $ris = 1;
    }
    return $ris;
}

function isVersion($version)// 0 yes, 1 false
{
    $ris = 0;
    $pieces = explode(".", $version);
        
    $test = trim( implode('',$pieces));
    //echo "|".$test."|";
    //$test = "123 ";

    if( !is_numeric( $test ) )
    {
        $ris = 1 ;    
    }    
    
    return $ris;
}


?>