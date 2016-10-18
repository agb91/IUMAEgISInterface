<!DOCTYPE html>
<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <script src="JS/editConfigReadImages.js"></script>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="CSS/editConfig.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="configurator"> 
        <div class="row">
            <h1 class="col-xs-6"> Welcome to the ReadImagesConfigurator</h1>
            <div class="col-xs-3"></div>
            <div class="col-xs-3">
                <button onclick="window.location.href='index.php'" type="button" class="lower btn btn-primary btn-lg">
                    Back to Home
                </button>
            </div>
        </div>   
        <br>
        <h3> In this page you can link the name of a group to the name of an image (if different)</h3> 
        <br>

        <form action="PHP/writeIdentifierFunctions.php" method="post">
            <div class="row">
                <div class="col-xs-12">
                    <label class="form-control-label">Insert for each group the corrisponding image-name</label>
                </div>
            </div> 
            <?php
                include 'Globals.php';
                include 'PHP/editConfigFunctionsCommons.php';

                $fileString = fileIniReader($iniFilePath);
                //echo "read file with comments " . $fileString;
                /* divide into rows, and toggle the row which starts with '#'
                 * beacuse they are only comments*/
                $fileString =getRowContents($fileString);
                /* now in $filestring there is a cleaned version of the readed file,
                 * without comments
                 */

                $refinedObjects = menageGroupsForGlobals($fileString);
                //print_r($refinedObjects);

                for ($i = 0; $i < count($refinedObjects); $i++) 
                {
                    echo '<div class="row">';
                    echo '<div class="col-xs-1"></div>';
                    echo '<div class="col-xs-1"> <h4>' . $refinedObjects[$i] . ': </h4></div>';
                    echo '<div class="col-xs-4" >';
                    echo '<input type="text" id="identifiers' . $i . '" name="identifiers' . $i . '" class="form-control" placeholder="Insert a image-name">';
                    echo '</div>';   
                    echo '</div>';  
                }  
            ?>
            <div class="col-xs-2">
                <button id="sendIdentifiersButton" type="submit" class="red btn btn-secondary"> 
                    Write
                </button>
            </div>
        </form>


    </body>
</html>
