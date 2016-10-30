<?php

	function getAllGroups( $path )
	{
		//echo $path . "<br>";
		$parentGroups = getParentGroups($path);
		//print_r($parentGroups);
     	$groups = [];
     	// general analyzes is the third
        $stack = getGroupsFromXml($path, $parentGroups[ 3 ] ); 
        for( $a = 0 ; $a < count( $stack ) ; $a++ )
        {
            array_push( $groups, $stack[ $a ] );    
        }        
        return $groups ;
	}

	function getAllValues( $path , $parent)
	{
		$ris = [];
		//general analyzes is the third
	    $stack = getGroupsFromXml($path, $parent );
	    //print_r( $stack );
	    for( $a = 0 ; $a < count( $stack ) ; $a++ )
        {
        	$newValue = readValue( $path , $parent ,$stack[ $a ]);
            array_push( $ris, $newValue );    
        }            
    	return $ris;

	}

	function getParentGroups( $path ) //parentGroup exists because the groups 
	//(like mimitos, scints etc) are not directly under the xml tag.. 
	{	
		$xml=simplexml_load_file($path) or die("Error: Cannot create object");
	    $ris = [];
	    foreach ($xml->children() as $child)
		{
			array_push($ris, $child->getName());
		}
		return $ris;
	}

	function getGroupsFromXml( $path, $parentGroup ) //parentGroup exists because the groups 
	//(like mimito, scint etc) are not directly under the xml tag.. 
	{
		$xml=simplexml_load_file($path) or die("Error: Cannot create object");
	    $ris = [];
		foreach ($xml->$parentGroup->children() as $child)
		{
			array_push($ris, $child->getName());
		}
		return $ris;
	}
	
	function readValue($path, $parent, $valueName)
	{
		//echo "<br> " . $path . "<br>";
		$xml=simplexml_load_file($path) or die("Error: Cannot create object");
	    //print_r( $xml );
	    //echo "parent: " . $parent;
		//echo "I read: " . $valueName . "<br>";
		$ris = $xml->$parent->$valueName["v"];
	    return $ris; 
	}


?>
