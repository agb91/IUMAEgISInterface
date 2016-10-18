<!DOCTYPE html>
<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="CSS/showOneImage.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.js"> </script>
        <script src="JS/rootJsIndex.js"></script>
        <script src="JSROOTlibraries/scripts/JSRootCore.js" type="text/javascript"></script>
        <script src="JS/readImageRootJs.js"></script>
    </head>
    <body>
        <div class="showImageGeneral">
            <div class="fixedUpLeft">
                <?php
                    /*! \brief dynamically creates the 'back to all images' button
                     *
                     *  Back to all images. Remember that we need to know the selected runs to return in the allImages page
                     *  in a consistent page (otherwise the program doesn't crash, simply doesn't show the images)
                     */
                    $runs = $_GET["runs"];  
                    echo '<button onclick="window.location.href=\'images.php?runs=' . $runs . '\'" type="button" class="lower btn btn-primary btn-lg">';
                    echo 'Back to All Images';    
                    echo '</button>';
                ?>
            </div>
            <?php
                include "PHP/genericFunctions.php";
                include "Globals.php";

                $whichgAn = fileReaderGeneral($gAnPathFile);
                //echo "alive";
                echo "<p hidden id='whichgAn'>$whichgAn</p>";
                //echo "alive";
            ?>
            <div class="fixedUpRight">
                <button onclick="window.location.href='index.php'" type="button" class="lower btn btn-primary btn-lg">
                    Back to Home
                </button>
            </div>
            <div class="fixedUpCenter">
                <?php
                    echo '<button onclick="window.location.href=\'downloadRootFile.php?file=run_' . $_GET["whichRun"] . '_gAnOut.root\'" type="button" class="center-block lower btn btn-primary btn-lg">';
                    echo 'Download .root File';
                    echo '</button>';
                ?>
            </div>
            <div class="space"></div><!-- just to insert a little space here -->

            <?php
                /*! \brief hidden part for communication from php to js 
                 *
                 *  This part is only to send informations from php to javascript, in a simple way and avoiding
                 *  problems. JS needs to know on which run and on which image we are working, and
                 *  cannot takes these information from GET (javascript cannot use get, because is a client side 
                 *  language....) 
                 */
                $whichRun = $_GET["whichRun"];
                $whichImage = $_GET["image"];
                echo "<p id='getRun' style='display: none;'>" . $whichRun . "</p>";
                echo "<p id='getImage' style='display: none;'>" . $whichImage . "</p>";
            ?> 
            <div class="row">
                <div class= "col-xs-1"></div>
                <div class= "col-xs-10">
                    <!-- 
                        there is space for 12 images. For a know run, and a known group 
                        probably a lot less would be enough
                    -->
                    <div id="object_draw1" style="width: 100%"></div><br>
                    <div id="object_draw2" style="width: 100%"></div><br>
                    <div id="object_draw3" style="width: 100%"></div><br>
                    <div id="object_draw4" style="width: 100%"></div><br>
                    <div id="object_draw5" style="width: 100%"></div><br>
                    <div id="object_draw6" style="width: 100%"></div><br>
                    <div id="object_draw7" style="width: 100%"></div><br>
                    <div id="object_draw8" style="width: 100%"></div><br>
                    <div id="object_draw9" style="width: 100%"></div><br>
                    <div id="object_draw10" style="width: 100%"></div><br>
                    <div id="object_draw11" style="width: 100%"></div><br>
                    <div id="object_draw12" style="width: 100%"></div><br>
                </div>
                <div class= "col-xs-1"></div>
            </div>
       </div>
    </body>
</html>