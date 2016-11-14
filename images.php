<html>
    <head>
        <title>gAn web interface </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.js"></script>
        <script src="JSROOTlibraries/scripts/JSRootCore.js" type="text/javascript"></script>
        <script src="jquerySVG/jquery.svg.package-1.5.0"></script>
        <script src="JS/imagesJs.js"></script>
        <link rel="stylesheet" href="CSS/images.css" media="screen">
    </head>
    <body class= "imagesGeneral">
        <?php
            include 'PHP/imagesFunctions.php';
            include 'Globals.php';
            include 'PHP/genericFunctions.php';
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
                $runs = $_GET['runs'];
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
        <div class = "row" >
            <ul class="nav nav-tabs navbarColor">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:history.back()">
                        <h1> Textual Output </h1>    
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="Look at the images created by running gAn">
                    <a class="nav-link" href="#">
                        <h1> Images </h1>    
                    </a>
                </li>
                <li class="nav-item" data-toggle='tooltip' title='Download the .root file related to the selected run'>
                    <a class="nav-link" onclick="rootDownload()">
                        <h1> Download .root File 
                            <?php
                                echo "<div hidden id='rootFileRun'> " . $runs[ 0 ] . "<div>";    
                            ?>
                        </h1>    
                    </a>
                </li>
                <li class="nav-item right">
                    <a class="nav-link" href="index.php">
                        <h1> Back to Home </h1>    
                    </a>
                </li>
            </ul>
        </div>    
        <!--<button onclick="window.location.href='index.php'" type="button" 
                class="btn btn-primary btn-lg fixedTopRight">
            Back to Home
        </button>-->
        <button data-toggle="tooltip" title="Download automatically on your hard disk (in the default download folder) all the images related created by gAn" onclick="download()" type="button" 
                class="btn btn-lg fixedUnderTopRight green">
            Download All Images
        </button>
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
            <div class= "col-xs-2"></div>
            <div class= "col-xs-8">
                <div id = "verticalBlock" style = "display:block" class = "center" >

                        <?php
                            include "PHP/imagesFunctionsRoot.php";
                            //echo "alive3";
                            //generate the structure of images disposed vertically, filtered by run and group
                            echoRootLike($runs, $allAnalyzesSingle);
                            //echo "alive4";
                        ?>
                </div>
            </div>
            <div class= "col-xs-2"></div>    
        </div>
        <!-- just to set the default configuration when the user enters in this page -->        
        <!--<script src="JS/imagesInitializer.js"></script>-->
    </body>
</html>