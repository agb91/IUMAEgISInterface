<?php
    
    //include '../Globals.php'

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
    

?>