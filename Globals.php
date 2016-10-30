<?php

/*! \brief This script contains global parameters (related to on which machine is gAn installed)
 *         and some very common functions
 *
 */

$xmlConfigFilePath = "/opt/lampp/htdocs/test-interChangeble/gAn-NEWWAY/AEgSettings.xml"; // path of the ini file
$sourceRootPath = "/home/andrea/Downloads/buildRoot/bin/thisroot.sh"; //path of thisroot.sh
//$gAnPath = "/opt/lampp/htdocs/Tesi/gAn/gAn-dev/"; //path of gAn
$gAnPath = "/opt/lampp/htdocs/test-interChangeble/gAn-NEWWAY"; //new path of gAn
$imagesPath = "/opt/lampp/htdocs/Tesi/gAn/gAn-dev/output/"; // where are the images?
//$baseFolder = "/opt/lampp/htdocs/test-interChangeble/gAn-web"; //basic folder that includes the project
$baseFolder = "/opt/lampp/htdocs/test-interChangeble/gAn-webIUM"; //basic folder that includes the project
$dirRawFiles = "/opt/lampp/htdocs/Tesi/gAn/gAn-dev/data/";
$rootPathFile = "/opt/lampp/htdocs/test-interChangeble/gAn-web/rootPath.txt"; // here there is a file that containt the root path (to thisroot.sh)
$allRoots = "/home/andrea/Downloads/";
$gAnPathFile = "/opt/lampp/htdocs/test-interChangeble/gAn-web/gAnPath.txt";
$gAnChose = "/opt/lampp/htdocs/test-interChangeble/gAn-NEWWAY";
$allAnalyzesSingle = "/opt/lampp/htdocs/test-interChangeble/gAn-NEWWAY/analyses/single_run";

static $groups = array();

/*! \brief cleanRuns($row)
 *
 *  this function takes a raw input string and cleans it: standardizes the separators,
 *  trims it, toggles duplicates, returns a clean string 
 */
function cleanRuns($row)
{
	$result = "";
	$row = str_replace(",", ";",$row);
    $row = str_replace("-", ";",$row);
    $row = str_replace(".", ";",$row); //. is quite horrible: can pass through isNumeric and set it to true, is better to avoid the risk
	$piecesOfRun = explode(";", $row);
	$piecesOfRun = array_map('trim',$piecesOfRun);// toggle white spaces
	$piecesOfRun = array_unique($piecesOfRun);// toggle duplicates if there are
	for ($i = 0; $i < count($piecesOfRun); $i++) //return a clean string
	{
		if( strlen($piecesOfRun[$i])!=0 )
		{
		    $result = $result . $piecesOfRun[$i] . ";";
		}
	}   
	//echo $result;
	return $result;
}


/*! \brief setGroups($arrayGroups)
 *
 *  seems to be useful store here the objects group read from inifile.
 *  This function is to store (a setter)
 */
function setGroups($arrayGroups)
{
	$groups = $arrayGroups;	
}

/*! \brief getGroups()
 *
 *  seems to be useful store here the objects group read from inifile.
 *  This function is to read after store (a getter)
 */
function getGroups()
{
	return $groups;
}


?>
