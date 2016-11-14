<?php

/*
 * in this php file all the functions used in:
 * - runner.php
 */

//include 'editConfigFunctionsCommons.php';
//include 'PHP/editgAnBranchFunctionsCommons.php';
//include 'genericFunctions.php';


/*
 * Print the blocks that contain the results in an ordered way
 */
function printBlocks( $blocks )
{
    for ( $i = 1 ; $i < ( count( $blocks ) - 1 ) ; $i++ ) 
    // does block 0 contain interesting information? ask to Germano,
    // at the moment I skip them. The last block is related to 
    // error messages.   
    {
        echo "<br><br>";
        printSingleBlock( $blocks[ $i ] );
    }
}

/*
 *   print a single block in an organized way
 */
function printSingleBlock( $thisBlock )
{
    $allRows = explode("<br>", $thisBlock);
    //echo "rows are: " . count( $allRows );
    
    // the 0 and the last are empty
    // the 1 is the title of the block, need a different treatment
    writeTitleRow( $allRows[ 1 ] );
    for ( $i = 2 ; $i < ( count( $allRows ) - 1 ) ; $i++ ) 
    {
        printSingleRow( $allRows[ $i ] );
        //echo $i . " " . $allRows[ $i ] ."<br>";
    }
    //echo $thisBlock;
}

/*
 * Check if the row is simple or complex (with an equal or an arrow)
 */
function printSingleRow( $thisRow )
{
    $delimiters = array("=", 
        "->");
    $thisRow = str_replace( $delimiters, "&&&", $thisRow );
    //now i split the strig using &&& as delimiter
    $rowPieces = explode("&&&", $thisRow);
    $dim = count( $rowPieces );
    if( $dim === 1)
    {
        writeSimpleRow( $thisRow );
    } 
    else
    {
        writeComplexRow( $rowPieces );
    }
}

function writeTitleRow( $row )
{
    echo "<h2>" . $row . ": </h2>";
}

function writeSimpleRow( $row )
{
    echo "<br><span class = 'singleRow' >" . $row . "</span>";
}

function writeComplexRow( $row )
{
    echo "<br><span class = 'leftEqual' >" . $row[ 0 ] . "</span>";
    echo "  =  ";
    echo $row[ 1 ];    
}



/*
 * Split the output in blocks (selected by different separators) to 
 * show them easily in the future 
 */
function getBlocks( $text )
{
    $delimiters = array("--------------------------------------", 
        "=================================================================================",
        "====================================== oOo ======================================");
    $text = str_replace( $delimiters, "&&&", $text );
    //now i split the strig using &&& as delimiter
    $textPieces = explode("&&&", $text);
    return $textPieces;
}


/*
 * Run the bash command that starts gAn (external c file that uses root).
 * The function is prepared to read the errors log 
 * The function return the output of the bash.
 */
function run($wr, $analisys, $sourceRootPath, $rootPathFile, $gAnPath, $gAnChose)
{
    //echo 'path now: '. $gAnPath . ' <br> ';
    //echo 'source: '. $sourceRootPath . '<br>';

    if ( !is_numeric($wr) )
    {
        echo "inserted run: " . $wr;
        echo "Inserted run is not acceptable";
        $wr = 0;
    }

    //echo "rootPathFile: " . $rootPathFile . "<br>";
    //$sourceRootPathNew = fileReaderGeneral($rootPathFile); 
    //$whichgAn = fileReaderGeneral($gAnPathFile);
    $whichgAn = "gAn-dev";
    
    if( isAnalysisSafe( $analisys ) == 1 )
    {
        echo "selected analysis is not acceptable";
        $analisys = "---";
    }

    if( isPathSafe($sourceRootPathNew) == 1 )
    {
        $sourceRootPathNew = "root";
        echo "I return to the standard root path...";
    }
    
    //echo "gAn path before : " . $gAnPath . "<br>";
    //$gAnPath = $gAnChose . trim($whichgAn);
    //echo "gAn path after : " . $gAnPath . "--<br>";

    $output="";
    try 
    {
        //call the rooc data analisys program with the correct arguments by running a bash file
        $command = "./gAnShStarter.sh " . $wr . " " . $analisys . " " . $sourceRootPathNew. " " . $gAnPath;
        //echo "<br><br><br>the inserted command: --> " . $command . "<br><br>";
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
/*
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
*/

?>