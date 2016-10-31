<?php
include '../Globals.php';
include 'editConfigFunctionsCommons.php';

function getGetArray()
{
    $ris = [];
    foreach($_GET as $key => $value)
    {
       //echo 'Key = ' . $key . '<br />';
       array_push($ris,$key);
    }
    return $ris;
}

function getCleanGetArray() //without "path" variable...
{
    $ris = [];
    $gets = getGetArray();
    for ( $i = 0; $i < ( count($gets) - 1 ) ; $i++ ) 
    {
        array_push($ris,$gets[$i]);   
    }
    return $ris;
}

function workWithVerbose($xml, $groups)
{
    $first = $groups[0];
    //echo  "<br><br><br>" .$first ;
    $xml->general->$first["v"] = $_GET[$first];
    return $xml;    
}

function workWithCommonParemeters($xml, $groups)
{
    for( $i = 0 ; $i < count($groups) ; $i++ )
    {
        //echo "cycle <br>" ;
        $actual = $groups[$i];
        $xml->analysis_base->$actual["v"] = $_GET[$actual];    
    }
    return $xml;
}

session_start(); // Starting Session
if (!strcmp($_SESSION['logged'], "logged") == 0)
{
    echo "not logged";
    header("location: logPage.php");
} 
else
{
    include "genericFunctions.php";
    //I read the path of the received config file
    $path = $_GET["path"];
    $path = cleanString( $path );
    echo "path: " . $path . "<br>";

    $groups = getCleanGetArray(); //without path
    print_r($groups);

    $xml=simplexml_load_file($path) or die("Error: Cannot create object");
    //print_r( $xml );

    //$xml = workWithVerbose($xml, $groups);
    $xml = workWithCommonParemeters($xml, $groups);
    //print_r( $xml );



    echo "<br> alive at end <br>";
    
    $xml->asXml($path);

    header ("LOCATION: ../../index.php");
    
}



?>