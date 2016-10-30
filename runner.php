<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <link rel="stylesheet" href="CSS/runner.css" media="screen">
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.js"></script>
        <script src="JS/runnerJs.js"></script>

        <link rel="stylesheet" href="jqueryUI/jquery-ui.css">
        <script src="jqueryUI/jquery-ui.js"></script>
    </head>
    <body id="body" class="runnerGeneral">
        <button onclick="window.location.href='index.php'" type="button" 
                class="lower btn btn-primary btn-lg fixedDownRight">
            Back to Home
        </button>
        <br>
        <div class="row">
            <div class="col-xs-3">
                <h1> Results: </h1>
            </div>
            <div class="col-xs-6"></div>
            <div class="col-xs-3">
               <?php
                    include 'Globals.php';
                    $whichRun = $_POST["whichRun"];
                    $whichAnalysis = $_POST["whichAnalysisSingle"];
                    echo "write here: " . $whichAnalysis;
                    echo "<button data-toggle='tooltip' title='Look at the images created by running gAn' onclick=\"window.location.href='images.php?runs=" . cleanRuns($whichRun) . "'\" type=\"button\" class=\"btn btn-primary btn-lg fixedTopRight \">";
                    echo "Look at the images";
                    echo "</button>";
                ?>
            </div>
        </div>
        <div>
            <nav id="navBlock" data-toggle="tooltip" title=" Select by run which results to show " class="fixedTopLeft" aria-label="Page navigation">
                <ul class="pagination">            
                    <?php
                        include 'PHP/runnerFunctions.php';


                        /*! \brief this script allows us to show in the navbar the chosen runs 
                         *
                         *  we can select a run in the navbar, the program will show only the output
                         *  related to the chosen run (it is very useful if we selected multiple runs)
                         */

                        // clean the read values: no white spaces, no doubles, no comma or point or '-'
                        $whichRun = cleanRuns($_POST["whichRun"]);
                        $piecesOfRun = explode(";", $whichRun);
                        for ($i = 0; $i < count($piecesOfRun)-1; $i++) //show the possible runs computed, the user can chose
                        {
                            //navclick will hide the useless information and show only the run that the user selected
                            echo "<li><a onclick='navClick(" . $piecesOfRun[$i] . ")'> run: " . $piecesOfRun[$i] . "</a></li>";
                            //echo ($i+1) . "° run: |" . $piecesOfRun[$i] .  "|<br>";
                        }  
                    ?>
                </ul>
            </nav>
            <?php
                echo "<button data-toggle='tooltip' title='Download the .root file related to the selected run' onclick=\"rootDownload()\" type=\"button\" class=\"btn btn-primary btn-lg fixedTopSecondRight \">";
                echo "Download Root File of : <div id='rootFileRun'> " . $piecesOfRun[0] . "<div>";
                echo "</button>";
            ?>

            <?php


                session_start(); // Starting Session
                if (!strcmp($_SESSION['logged'], "logged") == 0)
                {
                    echo "not logged";
                    header("location: logPage.php");
                }
                else
                {
                    /*! \brief this script show the output related to all the runs (all the runs 
                     *         not selected will be hidden)
                     *
                     *  show bash results for all (the useless parts will be covered by js)
                     *  is this solution efficient? yes, because the useless parts are already computed...
                     */
                    for ($i = 0; $i < count($piecesOfRun)-1; $i++) 
                    {
                        if($i==0)//before the user choise show the first run as default
                        {
                            echo "<div id= 'run" . $piecesOfRun[$i] . "' style='display:block' name='disappearing'>";
                        }
                        else
                        {
                            echo "<div id= 'run" . $piecesOfRun[$i] . "' style='display:none' name='disappearing'>";
                        }
                        echo "<h4>Run selected: " . $piecesOfRun[$i] . "</h4><br>";
                        //start root, run gAn and make computation
                        //echo "<h1> going to run: " . $piecesOfRun[$i] . "</h1><br>";
                        $o = run($piecesOfRun[$i], $sourceRootPath, $rootPathFile, $gAnPathFile, $gAnChose); 
                        //echo "<h1> just runned: " . $piecesOfRun[$i] . "</h1><br>";
                        echo $o . "</div>";    
                    }
                
                    
                    //the following part is not useful outside the test on my local 
                    //machine; ignore it
                    //find root (and if exists, kill the process) the job is done
                    //$found = array();
                    //$found = findRoot();
                    //it is important to kill before the more recent process (bigger id)
                    //sort($found);
                    
                    //now kill all root processes found
                    //from to ent to the start, because I want to kill before the more recent
                    // processes
                    /*$o="";
                    if(count($found)>0) //if there are root's processes still opened
                    {
                        for($i = (count($found)-1); $i>=0 ; $i--)
                        {
                            if(strlen($found[$i])!=0)//if there is an ID (sometimes the 
                            //explode of the vector create an empty cell, useless)
                            {
                                echo "<br><br> I found a zombie process root with Id: ";
                                echo "|".$found[$i] ."|". ";  I'll kill it now" ;
                                $o = killRoot($found[$i]);
                            }
                        }
                    }                
                    echo $o;*/
                } 
                

            ?>
        </div>
    </body>    
</html>