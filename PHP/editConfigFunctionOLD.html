<?php
include '../Globals.php';
include 'editConfigFunctionsCommons.php';

session_start(); // Starting Session
if (!strcmp($_SESSION['logged'], "logged") == 0)
{
    echo "not logged";
    header("location: logPage.php");
} 
else
{
    /*! \brief This script aims to modify the gUser.ini file
     *
     *  First of all the script reads the file, after splits it in rows and comments, finds the 
     *  groups of images (sends it to Globals). it finds where in the file the old values are 
     *  located, it modifies them (it works using the file like a string). 
     */


    //I read the gUser.ini file
    $fileContent = fileIniReader($_GET["path"]);
    //echo "first read: " . $fileContent;


    $comments = getCommentContents($fileContent);//read only the comments, in a string
    $fileContent = getRowContents($fileContent);// read only the file rows, in a string
    $comments = explode("<<<>>>",$comments); //comments in a vector, divided by blocks

    //echo "<br> file pulito: " . $fileContent;
    //echo "<br><br><br>  commenti" ;
    //print_r($comments);


    $refinedObjects = menageGroupsForGlobals($fileContent); //read existing groups (and inform about that Globals.php)

    //echo " <br>list of read groups: <br>";
    //print_r($refinedObjects); 

    // find where in the file we have to write the new values (we do this finding the offSet of each group)
    $offSets = getOffsets($fileContent, $refinedObjects);// list of the offsets (position in the string of the starting charachter of the object) 
    //of the groups

    //echo " <br>offsets array: <br>";
    //print_r($offSets);



    //echo ' <br>opening: '.$_GET["path"] . '<br>';
    $myfile = fopen($_GET["path"], "w") or die("Unable to open file! (part2) ");

    //read and validate from the GET method the new values to insert
    $newValues = array();
    for ($i = 0; $i < count($refinedObjects); $i++) //why 0 is different? because verbose can have values >1...
    {
        //echo "<br>this: (". $refinedObjects[$i]. ") " . $_GET[$refinedObjects[$i]];
        if($i==0)//if verbose, that allows valuse from 0 to 3 included
        {
            $newv = "".checkLimits($_GET[$refinedObjects[$i]],0,3);
            array_push($newValues,$newv);
        }
        else //if not verbose, all the others objects allow values 0 or 1 (false or true)
        {
            $newv = "".checkLimits($_GET[$refinedObjects[$i]],0,1);
            array_push($newValues,$newv);
        }
    }

    //echo "<br>new values to insert: <br>";
    //print_r($newValues);

    //replace the old values with the new values; re-insert the comments in the 
    // right places
    for ($i = 1; $i < count($refinedObjects); $i++) //why from 1 to (count)? because the first element
    //has comments that must be re-inserted before and after we have to manage
    // it outside the for-cycle
    {
        $fileContent = substr_replace($fileContent, $newValues[$i], ($offSets[$i]), 1);
    }

    $fileContent = substr_replace($fileContent, $newValues[0]."\n".$comments[1], ($offSets[0]), 1);
    $fileContent = $comments[0]."".$fileContent;


    // is this echo visible for the user? no, because the last row "header" changes the page immediatly
    // so it is usefull only for testing and only with header commented
    echo "<br><br><br> after the change, before writing on file: <br>" . $fileContent;

    // write the updated file
    fwrite($myfile, $fileContent);
    fclose($myfile);


    // return to homepage authomatically
    header ("LOCATION: ../../index.php");
}



?>