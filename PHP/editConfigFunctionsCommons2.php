<?php

	function getAllGroups( $path )
	{
		$parentGroups = getParentGroups($path);
		//print_r($parentGroups);
     	$groups = [];
        for( $i = 0 ; $i < count( $parentGroups ) ; $i++ )
        {
            $stack = getGroupsFromXml($path, $parentGroups[ $i ] );
            for( $a = 0 ; $a < count( $stack ) ; $a++ )
            {
                array_push( $groups, $stack[ $a ] );    
            }            
        }

        return $groups ;
	}

	function getAllValues( $path )
	{
		$parentGroups = getParentGroups($path);
		$ris = [];
		for( $i = 0 ; $i < count( $parentGroups ) ; $i++ )
        {
            $stack = getGroupsFromXml($path, $parentGroups[ $i ] );
            for( $a = 0 ; $a < count( $stack ) ; $a++ )
            {
            	$newValue = readValue( $path , $parentGroups[ $i ] , $stack[ $a ]);
                array_push( $ris, $newValue );    
            }            
        }
        return $ris;

	}

	function getParentGroups( $path ) //parentGroup exists because the groups 
	//(like mimito, scint etc) are not directly under the xml tag.. 
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

		$ris = $xml->$parent->$valueName["v"];
	    return $ris; 
	}


?>
