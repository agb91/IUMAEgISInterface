<html>
    <head>
        <title>gAn web interface </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.js"></script>
        <script src="JS/imagesJs.js"></script>
        <link rel="stylesheet" href="CSS/images.css" media="screen">
    </head>
    <body>
        <?php
            include 'PHP/imagesFunctions.php';
            include 'Globals.php';
            include 'PHP/editConfigFunctionsCommons.php';
            include 'PHP/genericFunctions.php';

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
                //echo "alive2!";
            }



        ?>
        <button onclick="window.location.href='index.php'" type="button" 
                class="btn btn-primary btn-lg fixedTopRight">
            Back to Home
        </button>
        <button data-toggle="tooltip" title="Download automatically on your hard disk (in the default download folder) all the images related created by gAn" onclick="download()" type="button" 
                class="btn btn-lg fixedUnderTopRight green">
            Download All Images
        </button>
        <button onclick="window.history.back();" type="button" 
                class="btn btn-primary btn-lg fixedTopLeft">
            Back Previous Page
        </button>        
            
        <div class="col-xs-2"></div>
        <div class="choseImage col-xs-8"><!-- images in output-->
            <h1>These Runs these images as output:</h1>    
            <div class="row">
                <div data-toggle="tooltip" title="Choose if you prefer a traditional layout for images or a carousel layout" class="col-xs-3 well well-sm">
                    <h4 class="col-xs-12"> Possible layouts: </h4>
                    <div class="dropdown col-xs-12">
                        <button id="layoutButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Layout possible values:
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li><a href="#" onclick="selectSlideImage(0)">Vertical Layout Images</a></li>
                          <li><a href="#" onclick="selectSlideImage(1)">Carousel Layout Images</a></li>
                        </ul>
                    </div> 
                </div>    
                <div data-toggle="tooltip" title="Choose between large, medium or little images"class="col-xs-3 well well-sm">
                    <h4 class="col-xs-12"> Set dimension: </h4>
                    <div class="dropdown col-xs-12">
                        <button id = "imageDimensionButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Image Dimension:
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li><a href="#" onclick="setImageDimension(0)">Little</a></li>
                          <li><a href="#" onclick="setImageDimension(1)">Medium</a></li>
                          <li><a href="#" onclick="setImageDimension(2)">Big</a></li>
                        </ul>
                    </div>
                </div>    
                <div data-toggle="tooltip" title="Choose by group which images to show: the selectable groups are the ones taken from the configuration file" class="col-xs-3 well well-sm">
                    <h4 class="col-xs-12"> Group to show: </h4>
                    <div class="dropdown col-xs-12">
                        <button id="groupToShowButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Group to show:
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" onclick="selectImageType(0)">
                                    <?php 
                                        //print in this dropdown the list of all known image groups.
                                        //we can found the existing groups in the ini configuration file
                                        echoGroupList($iniFilePath);
                                    ?>
                                </a>
                            </li>
                        </ul>
                    </div> 
                </div>   
                <div data-toggle="tooltip" title="Choose by run which image to show (default: all the runs)" class="col-xs-3 well well-sm">
                    <h4 class="col-xs-12"> Runs to show: </h4>
                    <div class="dropdown col-xs-12">
                        <button id="groupToShowButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Runs to show:
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
            <h3>Click on the images to get a detailed root-like vision</h3>   
            <div id="carouselBlock" style="display:none" class="col-xs-12">
                <?php
                    //echo "alive1";
                    //generate a bootstrap-like carousel of the images filtered by run and group
                    echoCarouselParts($runs, $iniFilePath);
                    //echo "alive2";
                ?>
            </div>
            <div id="verticalBlock" style="display:block">
                <?php
                    //echo "alive3";
                    //generate the structure of images disposed vertically, filtered by run and group
                    echoVerticalParts($runs, $iniFilePath);
                    //echo "alive4";
                ?>
            </div>
        </div>
        <!-- just to set the default configuration when the user enters in this page -->        
        <script src="JS/imagesInitializer.js"></script>
    </body>
</html>