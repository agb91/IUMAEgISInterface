<?php
/*! \brief This script aim to modify the identifiers file 
 *
 *  is this script useful? it depends: before we have to see the evolution of the gAn program
 */

	/*! \brief readIds()  
	 *
	 *  simply reads FROM POST METHOD, NOT FROM A FILE the values of the identifiers
	 */
	function readIds() 
	{
		$count = count($_POST);//how many post objects?
		$ids = array(); 
		//echo $count.'<br>';
		for ($i = 0; $i < $count; $i++) 
		{
			array_push($ids,$_POST["identifiers".$i]);
		}
		return $ids;
	}

	$ids = readIds();//read the identifiers by post methods and put them in an array
	//print_r($ids);
	$ids = implode("\n", $ids);//it is better write a string, not an array

	$myfile = fopen("../identifiers.ini", "w") or die("Unable to open file! (identifiers) ");

	// write the updated file
	fwrite($myfile, $ids);
	fclose($myfile);

	// return to homepage authomatically
	//header ("LOCATION: ../../index.php");


?>	