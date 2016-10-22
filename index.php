<!DOCTYPE html>
<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <script src="jqueryUI/jquery-ui.js"></script>
        <script src="JS/index.js"></script>
        <link rel="stylesheet" href="jqueryUI/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="CSS/index.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="indexGeneral">  
        <?php
            session_start(); // Starting Session
            if (!strcmp($_SESSION['logged'], "logged") == 0)
            {
                header("location: logPage.php");
            } 
        ?>
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-3"></div>
                <div class="col-xs-6">
                    <img src="images/aegisLogo-black.gif" class="logoImage">
                </div>
                <div class="col-xs-3"></div>
            </div>
        </div>
        <div class="row releaseAegis">
            <?php
                include "PHP/indexFunctions.php";
                writeInitialOptions(); 
            ?>
        </div>
        <div hidden id="workBlock" >    
            <div class="row">
                <div class="col-xs-6">    
                    <div class="row"><!-- run row -->
                        <h3> Choose a run. Last existing run: 
                            <?php
                                include "Globals.php";
                                include "PHP/genericFunctions.php";
                                $whichgAn = fileReaderGeneral($gAnPathFile);
                                //echo $whichgAn . "<br>"; 
                                //echo $sourceRootPathNew . "<br>";

                                if( isgAnSafe($whichgAn) == 1 )
                                {
                                    $whichgAn = "gAn-dev";
                                    //echo "I return to the standard gAn path...";
                                }
                                //echo "dirRaw before :" . $dirRawFiles;
                                $dirRawFiles = "/opt/lampp/htdocs/Tesi/gAn/gAn-dev/data/";
                                //echo "dirRaw after: " . $dirRawFiles;
                                lastRun($dirRawFiles);
                                //echo "<div hidden id='rootPath'>";
                                //echo $sourceRootPath;
                                //echo "</div>"; 
                            ?>
                        </h3>
                    </div>
                    
                    <form action="runner.php" method="post">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="whichRun" data-toggle="tooltip" title="You can also separate with '-' and ',', it is not a problem" class="form-control-label">Insert Run: (you can insert multiple runs separated by semicolon)</label>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-xs-8" >
                                <input type="text" id="whichRun" name="whichRun" class="form-control" placeholder="example: 30000; 30001; 30003">
                            </div>
                            <div class="col-xs-2">
                                <button id="sendRunButton" data-toggle="tooltip" title="Start the program with the inserted runs" onclick="manageWait()" type="submit" class="red btn btn-secondary"> Send </button>
                            </div>
                            <div class="col-xs-2">
                                <h4 id="thisgAn">
                                    <?php
                                        echo '<div title="You can change it by the button chose gAn Branch" class="fixedTopRight well"> You are using: ' . $whichgAn . '</div>';
                                    ?>
                                </h4>
                            </div>
                            <div class="col-xs-4">
                                <h4 id="warningRunNumber">
                                    <div style="color: red;"><span class="glyphicon glyphicon-remove"></span> Only numbers </div>
                                </h4>
                            </div>
                        </div>    
                    </form>
                    <br><br>
                    <div id="wait" style="display:none">
                        <!--<h1>Just a moment i'm starting...</h1>-->
                        <div class="container">
                            <h1>Just a moment i'm starting...</h1>
                            <div class="progress progress-striped active">
                                <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-2">
                            <button onclick="addRangeModal()" data-toggle="tooltip" title="Insert a list of runs selecting the first and the last of the list" type="submit" class="moveAdder btn btn-secondary"> Add runs by range</button>
                        </div>
                        <div class="modal fade" id="addRangeModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" id="modalCloseRange">&times;</button>
                                        <h4><span class="glyphicon"></span> Add runs by range </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="newRun"><span class="glyphicon"></span> First run </label>
                                            <input type="text" class="form-control" id="first"></input>
                                            <label for="newRun"><span class="glyphicon"></span> Last run </label>
                                            <input type="text" class="form-control" id="last"></input>
                                        </div>
                                        <button class="btn btn-default btn-success btn-block" onclick="addRange()"> Add </button>
                                    </div>
                                </div>
                            </div>    
                        </div>   
                    </div>            

                    <br><br>
                    <div>
                        <form>
                            <?php 
                                //echo "WhichGan: " . $whichgAn . "<br>";
                                echo '<input type="button" data-toggle="tooltip" title="Modify the gUser.ini file" class="btn btn-primary" value="Edit Configuration File" onclick="window.location.href=\'editConfig.php\'" />';
                            ?>
                        </form>
                    </div>    
                    <br><br>

                    <div>
                        <form>
                            <input type="button" data-toggle="tooltip" title="Change the path to the thisroot.sh file needed to identify the correct Root intallation (you have to chose between existing Root installations)" class="btn btn-primary" value="Chose Root Version" onclick="window.location.href='editRootPath.php'" />
                        </form>
                    </div> 

                    <br><br> 

                    <div>
                        <form>
                            <input type="button" data-toggle="tooltip" title="Chose which branch of gAn do you want to use" class="btn btn-primary" value="Chose gAn branch" onclick="window.location.href='editgAnBranch.php'" />
                        </form>
                    </div>
                </div>    
                
                <div class="col-xs-6 moveDown">
                    <p>Chose the date around which to search: <input type="text" id="datepicker"></p>
                    <pre class="scrollable">
                        <?php
                            $url = "http://localhost/test-interChangeble/gAn-webIUM/dataLog.php";
                            $rawText = readText( $url );
                            $chunks = splitText( $rawText );
                            $dates = getDates( $chunks );
                            echo "<div class='container logBlock'>";
                            writeDates( $dates );
                            echo "<p>";
                            writeChunks( $chunks );
                            echo "</p>"; 
                            echo "</div>";
                        ?>
                    </pre>                    
                <div>    
            </div>        
        </div>
    </body>
</html>