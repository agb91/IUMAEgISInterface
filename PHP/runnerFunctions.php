<?php

/*
 * in this php file all the functions used in:
 * - runner.php
 */

//include 'editConfigFunctionsCommons.php';
//include 'PHP/editgAnBranchFunctionsCommons.php';
include 'genericFunctions.php';




/*
 * Run the bash command that starts gAn (external c file that uses root).
 * The function is prepared to read the errors log 
 * The function return the output of the bash.
 */
function run($wr, $sourceRootPath, $rootPathFile, $gAnPathFile, $gAnChose)
{
    //echo 'path now: '. $gAnPath . ' <br> ';
    //echo 'source: '. $sourceRootPath . '<br>';

    if (!is_numeric($wr))
    {
        echo "Inserted run is not acceptable";
        $wr = 0;
    }

    //echo "rootPathFile: " . $rootPathFile . "<br>";
    $sourceRootPathNew = fileReaderGeneral($rootPathFile); 
    $whichgAn = fileReaderGeneral($gAnPathFile);
    

    if( isgAnSafe($whichgAn) == 1 )
    {
        $whichgAn = "gAn-dev";
        echo "I return to the standard gAn path...";
    }

    if( isPathSafe($sourceRootPathNew) == 1 )
    {
        $sourceRootPathNew = "root";
        echo "I return to the standard root path...";
    }
    //echo $sourceRootPathNew . "<br>";

    //echo "gAn used : " . $whichgAn . "<br>"; 
    //echo "base gAns folder : " . $gAnChose . "<br>";
    echo "gAn path before : " . $gAnPath . "<br>";
    $gAnPath = $gAnChose . trim($whichgAn);
    echo "gAn path after : " . $gAnPath . "<br>";


    $output="";
    try 
    {
        //call the rooc data analisys program with the correct arguments by running a bash file
        $command = "./gAnShStarter.sh " . $wr . " " .$sourceRootPathNew. " " . $gAnPath;
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            2 => array("pipe", "w")  // stderr is a file to write to
        );
        //proc_open is considered insicure (but php doesn't deprecate it): 
        //but there is no other solution to run a root program from php
        $process = proc_open ($command , $descriptorspec , $pipes);
        fclose($pipes[0]);
        $output =  "--" ;
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
        $dim = count($pieces);
        $output="";
        for ($i = 0; $i < $dim; $i++) {
            $output .= $pieces[$i] . "<br>";
        }
    }
    catch (Exception $e)//is it necessary? this part of program never crashes ultil today
    {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        proc_close ( $process );// kill if killable..
        fclose($pipes[0]);
        fclose($pipes[1]);
    }
    
    return $output;
}



/*
 * this function want to find all the existing Root processes: the aim is to
 * be sure of the cleaning of the system after the Root-gAn running. Thi function
 * return the array of the IDs 
 */

function findRoot()//used only on Andrea's pc, just for tests (the goal of this tests is check if
// this program can in special situazione summon "root-zombie" process that can occupy ram. it cannot).
// Ignore this function, it is useless
{
    $command = "./findRoot.sh ";
    $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
        1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        2 => array("pipe", "w")  // stderr is a file to write to
    );
    $process = proc_open ($command , $descriptorspec , $pipes);
    fclose($pipes[0]);
    $output =  "" ;
    while(!feof($pipes[1])) 
    {
        $output .= stream_get_contents($pipes[1]) . "<br>";
    }    
    fclose($pipes[1]);
    /*while(!feof($pipes[2])) 
    {
        $output .= stream_get_contents($pipes[2]) . "<br>";
    }   
    fclose($pipes[2]);*/
    proc_close ( $process );
    // example: 3281 pts/18 00:00:00 root 3282 pts/18 00:00:00 root.exe 
    // now I split the string to return only the vector of the IDs
    $pieces = explode("\n", $output);
    $dim = count($pieces);
    $result = "";
    for ($i = 0; $i < $dim; $i++) {
        $added = explode(" ", $pieces[$i]);
        if(count($added)>1)//if the vector isn't empty
        {
            $result .= $added[1] . ";";
        }
    }
    return explode(";", $result);
}


/*
 * this function want to kill all the found Root processes, to clean the system .
 * As input this function want the ID of the process to kill,
 */
/*function killRoot($id)//only for test, other useless function
{
    $command = "./killRoot.sh " . $id;
    $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
        1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        2 => array("pipe", "w")  // stderr is a file to write to
    );
    $process = proc_open ($command , $descriptorspec , $pipes);
    fclose($pipes[0]);
    $output =  "" ;
    while(!feof($pipes[1])) 
    {
        $output .= stream_get_contents($pipes[1]) . "<br>";
    }    
    fclose($pipes[1]);
    while(!feof($pipes[2])) 
    {
        $output .= stream_get_contents($pipes[2]) . "<br>";
    }   
    fclose($pipes[2]);
    proc_close ( $process );
    // example: 3281 pts/18 00:00:00 root 3282 pts/18 00:00:00 root.exe 
    // now I split the string to return only the vector of the IDs
    return $output;
}
*/
/*
 * with the paradigm haystack-needle, search if in the first string(haystack) there is
 * the second string (needle) and return from where to where it is
 */
/* dismissed
function finder ($haystack, $needle)
{
    $start = strpos($haystack, $needle);
    $length = strlen($needle);
    return [$start,$length];
}*/


?>