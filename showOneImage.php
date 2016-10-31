<!-- 
    This page exists, but in this moment I prefer to skip it and go directly to the root-like image 
    page. This solution seems to be more convenient for the users, but I don't delete this page, in 
    case of changes. 
-->

<!DOCTYPE html>
<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="../JS/jquery.js"></script>
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="../CSS/showOneImage.css" rel="stylesheet" media="screen">
        <link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="../bootstrap/js/bootstrap.js"> </script>
    </head>
    <body>
        <div class="showImageGeneral">
            <div class="row">
                <div class="col-xs-3 fixedUpLeft">
                    <?php
                        // we need to know the runs used in the previous page to return to this page
                        // in a consistent state
                        $runs = $_GET["runs"];  
                        
                        echo '<button onclick="window.location.href=\'../images.php?runs=' . $runs . '\'" type="button" class="lower btn btn-primary btn-lg">';
                        echo 'Back to All Images';    
                        echo '</button>';
                    ?>
                </div>
            </div>
	        <!-- if this page is skipped, this button is useless
            <div class="row">
                <div class="col-xs-3 fixedUpRight">
                    <button onclick="window.location.href='../index.php'" type="button" class="lower btn btn-primary btn-lg">
                        Back to Home
                    </button>
                </div>
            </div>-->
            <div class="row">
                <div class="col-xs-3 fixedUpCenter">
                    <?php 
                        /*! \brief This script manage the image in the root sending the information to 
                         *         the readImageRoot.php file
                         *
                         *  this is used to see the image in a root-like dynamic format
                         *  (it uses the JSRoot library)
                         *  it is necessary do this little formatting work on the imageName string
                         *  because actually the input is a pathname. We need to obtain an imageName
                         *  and concatenate it to another pathname.
                         *  in test it is possible to make a confrontation with echo between before and after
                         */
                    
                        $thisImage = explode('?',$_GET["whichImage"])[1];
                        //echo 'before: ' . $thisImage . '<br>';      
                        $thisRun = explode('=',explode('_' ,$thisImage)[0])[1];
                        $thisImage =  explode('.',explode('=', $thisImage)[1])[0];;
                        //echo $thisImage;

                        echo '<button id="showRootLikeImage" onclick="window.location.href=\'../readImageRoot.php?image=' . $thisImage . '&whichRun=' . $thisRun . '&runs=' . $runs . '\'" type="button" class="lower btn btn-primary btn-lg">';
                        echo "Show dynamic root-like image";
                        echo "</button>";
                    ?>
                </div>
            </div>

            <?php
                /*include 'Globals.php';
                $imageName = $_GET["whichImage"];
		        $imageName = substr($imageName,2);
                //echo "<br><h1>" . $imageName . "</h1><br>"; 
                echo '<img src="'.$imageName.'" / style="width:100%"><br>';*/
            ?>

            <script src="../JS/showOneImageJS.js"></script>
        </div>    
    </body>
</html>    
