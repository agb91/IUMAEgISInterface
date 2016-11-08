<?php

	//include 'editConfigFunctionsCommons.php';
	//include 'PHP/editgAnBranchFunctionsCommons.php';

function getGroupsFromFolder( $allAnalyzes )
{
    $analyzes = scandir( $allAnalyzes );
    $cleanAnalyzes = [];
    for ( $i = 0 ; $i < count( $analyzes ) ; $i++ )
    {
        if ( substr( $analyzes[ $i ] , -2 ) == ".C")
        {
            $toAdd = $analyzes[ $i ];
            $toAdd = substr( $toAdd , 0 , ( strlen( $toAdd ) - 2 ) );
            array_push( $cleanAnalyzes , $toAdd );
            //echo $toAdd . "--";
        }
    }
    return $cleanAnalyzes;
}

function cleanString( $str )
{
    $str = trim( $str );
    $str = filter_var($str, FILTER_SANITIZE_STRING);
    $str = htmlspecialchars($str, ENT_IGNORE, 'utf-8');
    $str = strip_tags( $str );
    $str = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $str = htmlentities( $str );
    $str = xss_clean( $str );
    return $str;
}

function xss_clean($data)
{
    // Fix &entity\n;
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do
    {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);

    // we are done...
    return $data;
}

	
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

function isAnalysisSafe( $analisys ) //0 is ok, 1 problems
{
    $ris = 0;
    if( strlen($analisys) > 20 )
    {
        $ris = 1;
    }
    if ( strpos($analisys, " ") !== false )
    {
        $ris = 1;
    }
    if ( strpos($analisys, ";") !== false )
    {
        $ris = 1;
    }
    return $ris;
}


function isgAnSafe( $whichgAn )// 0 is ok, 1 problems
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