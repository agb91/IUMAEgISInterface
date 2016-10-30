<?php
/*! \brief This script contains the common functions related to the modifications of the ini file(s)
 *
 *  it can extract dynamically rows and comments, validate values, communicate with globals, 
 *  find the position of the objects in the file (offset)
 */



/*! \brief checkLimits
 *
 *  this function validates the values checking if they respect the minimum and maximum bounds
 */
function checkLimits($value, $min, $max)
{
    $value = intval($value);
    if(!is_numeric ( $value ))
    {
        $value = 0;
    }
    if(intval($value)<intval($min))
    {
        $value=$min;
    }
    if(intval($value)>intval($max))    
    {
        $value=$max;
    }
    return $value;
}

/*! \brief getRowContents
 *
 *  for each row read only if is a standard part of the file, not a comment (return contents in a stirng)
 */
function getRowContents($fileContent)
{
    $result = "";
    $rowsVector = explode("\n", $fileContent);
    for ($i = 0; $i < count($rowsVector); $i++) {
        $in = substr($rowsVector[$i], 0, 1);
        if($in!="#")
        {
            $result.=$rowsVector[$i]."\n";
        }
    }
    return $result;
}

/*! \brief getCommentContents
 *
 *  get only comments from the file, divided in blocks by a '<<<>>>' symbol, in a string
 */
function getCommentContents($fileContent)
{
    $previous = 1; //0 if previous object is a normal row, 1 if it is a comment
    $comments = "";
    $rowsVector = explode("\n", $fileContent);
    for ($i = 0; $i < count($rowsVector); $i++) {
        $in = substr($rowsVector[$i], 0, 1);
        if($in=="#")
        {
            if($previous==0)//if it is a new block of comments it starts with the delimitation symbol.. 
            //to divide the comments in blocks
            {
                $comments.="<<<>>>";
            }
            $previous = 1;
            //echo "<br> i=" . $i . ";  row= " . $rowsVector[$i]; 
            $comments.=$rowsVector[$i];
            if($i!=11 and $i!=5)
            {
                $comments.="\n";
            }
        }
        else
        {
            $previous = 0;
        }
    }
    return $comments;
}

/*! \brief getOffsets($fileContent, $refinedObjects)
 *
 *  get the offsets (the position in the string) of alla the values related to all the known groups
 *  of objects. Return the offsets in an array
 */
function getOffsets($fileContent, $refinedObjects)
{
    $offSets = array();// list of the offsets (position in the string of the starting charachter of the object) 
    //of the groups
    for ($i = 0; $i < count($refinedObjects); $i++) 
    {
        //thisOff = find the word in the file, sum the position of the first character, the length of the character, +2
        //+2 is because the number to change is 2 space right the end of the word
        $thisOff = strpos($fileContent, $refinedObjects[$i]) + strlen($refinedObjects[$i]) +2;
        array_push($offSets,$thisOff);
    }
    return $offSets;
}

/*! \brief fileIniReader($path)
 *
 * read the file as a raw string 
 */
function fileIniReader($path)
{
    $file = $path;
    //echo "opening: ".$file.'<br>';
    $myfile = fopen($file, "r") or die("Unable to open file! (part1) ");
    $fileContent = fread($myfile,filesize($file));
    fclose($myfile);
    return $fileContent;
}

/*! \brief menageGroupsForGlobals($fileContent)
 *
 *  this function can understand which are the groups of objects in the inifile
 *  it can send them to Globals, and return them as an array of strings
 */
function menageGroupsForGlobals($fileContent)
{
    //now the program extract the names of the groups. selrun seems to be useless... so we don't read it
    // the program sends this informations to Globals, and each time we need to know what are the groups we use
    // this informations
    $objects = preg_split('/\s+/', $fileContent);// it means split by space or big spaces
    $refinedObjects = array();
    for ($i = 0; $i < count($objects); $i++) 
    {
        if($objects[$i] !== "" && !is_numeric($objects[$i]) && strcmp($objects[$i],"selrun"))
        //we search the not empty, not selrun, and not numeric objects    
        {
            array_push($refinedObjects,$objects[$i]);
        }
    }
    //echo "<br> refined readed objects: <br>";
    //print_r($refinedObjects); 
    setGroups($refinedObjects);// write this info to globals
    return $refinedObjects;
}

?>