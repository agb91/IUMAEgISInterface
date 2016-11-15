<?php
    session_start(); // Starting Session
    if (!strcmp($_SESSION['logged'], "logged") == 0)
    {
        echo "not logged";
        header("location: logPage.php");
    }
    else
    {
        include 'Globals.php';
        include 'PHP/genericFunctions.php';
        include 'PHP/imagesFunctions.php';
        include 'PHP/runnerFunctions.php';
        include "PHP/imagesFunctionsRoot.php";
        $whichRun = $_POST["whichRun"];
        $whichRun = cleanString( $whichRun );

        //echo " the run is: " . $whichRun;

        $piecesOfRun = explode(";", $whichRun);
        //print_r( $piecesOfRun );

        $whichAnalysis = $_POST["selectedAnalysisSingle"];
        $whichAnalysis = $whichAnalysis . $_POST["selectedAnalysisMultiple"];
        //print_r($_POST);
        //echo "the read analysis is : " . $whichAnalysis;
        $whichAnalysis = cleanString( $whichAnalysis );
    }
?>

<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <script src="JS/imagesJs.js"></script>
        <script src="JS/runnerJs.js"></script>
        <link rel="stylesheet" href="CSS/runner.css" media="screen">
        <link rel="stylesheet" href="CSS/images.css" media="screen">
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.js"></script>
        <script src="JSROOTlibraries/scripts/JSRootCore.js" type="text/javascript"></script>
        <link rel="stylesheet" href="jqueryUI/jquery-ui.css">
        <script src="jqueryUI/jquery-ui.js"></script>
    </head>
    <body id="body" class="general">
        <div class = "row" >
            <ul class="nav nav-tabs navbarColor">
                <li class="nav-item">
                    <a class = "nav-link active" onclick = "showTextualRunner()" >
                        <h2> Textual Output </h2>    
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="Look at the images created by running gAn">
                    <?php 
                            echo "<a class = 'nav-link' onclick = 'showImages()' >";
                    ?>    
                        <h2> Images </h2>
                    </a>
                </li>
                <li class="nav-item" data-toggle='tooltip' title='Download the .root file related to the selected run'>
                    <a class="nav-link" onclick="rootDownload()">
                        <h2> Download .root File 
                            <?php
                                echo "<div hidden id='rootFileRun'> " . $whichRun . "<div>";    
                            ?>
                        </h2>    
                    </a>
                </li>
                <li class="nav-item" data-toggle='tooltip' title='Download all images as a vector based image files'>
                    <a class="nav-link" onclick="downloadImages()" >
                        <h2> Download All Images 
                            <?php
                                echo "<div hidden id='rootFileRun'> " . $whichRun . "<div>";    
                            ?>
                        </h2>    
                    </a>
                </li>
                <li class="nav-item" data-toggle='tooltip' title='Return to the Homepage of this gAn-Web'>
                    <a class="nav-link" href="index.php">
                        <h2> Back to Home </h2>    
                    </a>
                </li>
            </ul>
        </div>







        <!-- now starts with textual runner -->






        <div id="runnerTab" class="runnerGeneral">
            <!--<button onclick="window.location.href='index.php'" type="button" 
                    class="lower btn btn-primary btn-lg fixedDownRight">
                Back to Home
            </button>-->
               
            <div class="row">
                <div class="col-xs-3">
                    <h1> Results: </h1>
                </div>
                <div class="col-xs-9"></div>
            </div>
            <div>
                <nav id="navBlock" data-toggle="tooltip" title=" Select by run which results to show " class="fixedTopLeft" aria-label="Page navigation">
                    <ul class="pagination">            
                        <?php
                            /*! \brief this script allows us to show in the navbar the chosen runs 
                            *
                            *  we can select a run in the navbar, the program will show only the output
                            *  related to the chosen run (it is very useful if we selected multiple runs)
                            */

                            // clean the read values: no white spaces, no doubles, no comma or point or '-'




                            /*for ($i = 0; $i < count($piecesOfRun)-1; $i++) //show the possible runs computed, the user can chose
                            {
                            //navclick will hide the useless information and show only the run that the user selected
                            echo "<li><a onclick='navClick(" . $piecesOfRun[$i] . ")'> run: " . $piecesOfRun[$i] . "</a></li>";
                            //echo ($i+1) . "° run: |" . $piecesOfRun[$i] .  "|<br>";
                            } */
                        ?>
                    </ul>
                </nav>
                <?php
                    /*! \brief this script show the output related to all the runs (all the runs 
                     *         not selected will be hidden)
                     *
                     *  show bash results for all (the useless parts will be covered by js)
                     *  is this solution efficient? yes, because the useless parts are already computed...
                     */
                    $whichRun = cleanRuns($_POST["whichRun"]);
                    $whichRun = cleanString( $whichRun );
                    //echo $whichRun;
                    $piecesOfRun = explode(";", $whichRun);

                    //print_r( $piecesOfRun );
                    for ($i = 0; $i < count($piecesOfRun)-1; $i++) 
                    {
                        //echo "alive";
                        if($i==0)//before the user choise show the first run as default
                        {
                            echo "<div id= 'run" . $piecesOfRun[$i] . "' style='display:block' name='disappearing'>";
                        }
                        else 
                        {
                            echo "<div id= 'run" . $piecesOfRun[$i] . "' style='display:none' name='disappearing'>";
                        }
                        
                        echo "<h4>Run selected: " . $piecesOfRun[$i] . "; ";
                        echo "Kind of analysis selected: " . $whichAnalysis . "</h4><br>";
                        //start root, run gAn and make computation
                        //echo "<h1> going to run: " . $piecesOfRun[$i] . "</h1><br>";
                        $o = run($piecesOfRun[$i], $whichAnalysis, $gAnPath); 
                        //echo $o;
                        //echo "<h1> just runned: " . $piecesOfRun[$i] . "</h1><br>";
                        $outputBlocks = getBlocks( $o );
                        printBlocks( $outputBlocks );
                        //echo "<br> outputBlocks length: " . count( $outputBlocks ) . "<br>" ;
                        echo "</div>";  
                    }
                ?>
            </div>
        </div>







        <!-- FROM HERE IMAGES! -->








        <div id = "picturesTab" class = "imagesGeneral" >
            <?php
            //echo "alive! here is alive!";
            session_start(); // Starting Session
            if (!strcmp($_SESSION['logged'], "logged") == 0)
            {
                header("location: logPage.php");
            } 
            else
            {
                //echo "alive!";
                //read runs from get method
                $runs = $whichRun;
                $runs = explode(";", $runs);
                echo "<p id='getRuns' hidden>";
                for( $i = 0; $i < count( $runs ); $i++)
                {
                    echo "-" . $runs[ $i ];
                }
                echo "</p>";
                //echo "my runs: ";
                //print_r($runs);
            }


            ?>
            <!--<button onclick="window.location.href='index.php'" type="button" 
                    class="btn btn-primary btn-lg fixedTopRight">
                Back to Home
            </button>-->
            <!--<button data-toggle="tooltip" title="Download automatically on your hard disk (in the default download folder) all the images related created by gAn" onclick="download()" type="button" 
                    class="btn btn-lg fixedUnderTopRight green">
                Download All Images
            </button>-->
            <!--<button onclick="window.history.back();" type="button" 
                    class="btn btn-primary btn-lg fixedTopLeft">
                Back Previous Page
            </button>-->        
            <div class="row">    
                <div class="col-xs-2"></div>
                <div class="col-xs-8">
                    <h1>The analyzed Runs show these images as output:</h1> 
                    <div class="row">   
                        <div data-toggle="tooltip" title="Choose between large, medium or little images"class="col-xs-4 well well-sm">
                            <h4 class="col-xs-12"> Set dimension: </h4>
                            <div class="dropdown col-xs-12">
                                <button id = "dimensionButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Images Dimension:
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                  <li><a href="#" onclick="setImageDimension(0)">Little</a></li>
                                  <li><a href="#" onclick="setImageDimension(1)">Medium</a></li>
                                  <li><a href="#" onclick="setImageDimension(2)">Big</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-4 well well-sm">
                            <h4 class="col-xs-12"> Group to show: </h4>
                            <div class="dropdown col-xs-12">
                                <button id="groupToShowButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Group to show:
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" onclick="selectImageType(0)">
                                            <?php 
                                                echoGroupList($allAnalyzesSingle);
                                            ?>
                                        </a>
                                    </li>
                                </ul>
                            </div> 
                        </div>  
                        <div class="col-xs-4 well well-sm">
                            <h4 class="col-xs-12"> Runs to show: </h4>
                            <div class="dropdown col-xs-12">
                                <button id="runToShowButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Runs to show:
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <?php

                                        //print the existing runs (the runs that the user selected in the homepage)
                                        showRuns($runs);
                                    ?>
                                </ul>
                            </div> 
                        </div> 


                    </div>    
                </div>
                <div class="col-xs-2"></div>
            </div>

            <div class = "row">
                <div class= "col-xs-1"></div>
                <div class= "col-xs-10">
                    <div id = "verticalBlock" style = "display:block" class = "center" >

                            <?php
                                //include "PHP/imagesFunctionsRoot.php";
                                //echo "alive3";
                                //generate the structure of images disposed vertically, filtered by run and group
                                echoRootLike($runs, $allAnalyzesSingle);
                                //echo "alive4";
                            ?>
                    </div>
                </div>
                <div class= "col-xs-1"></div>    
            </div>
 
            <!-- just to set the default configuration when the user enters in this page -->        
            <!--<script src="JS/imagesInitializer.js"></script>-->
        </div>    
    </body>    
</html>