<!DOCTYPE html>
<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <script src="JS/editRootPathJs.js"></script>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="CSS/editConfig.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="configurator">  
        <div class="row">
            <p><h1 class="col-xs-6"> Set the New Root Path</h1></p>
            <div class="col-xs-3"></div>
            <div class="col-xs-3">
                <button onclick="window.location.href='index.php'" type="button" class="lower btn btn-primary btn-lg topRight">
                    Back to Home
                </button>
            </div>
        </div>  
        <br>
        <?php
            include 'Globals.php';
            include 'PHP/editConfigFunctionsCommons.php';
            include 'PHP/editRootPathFunctionsCommons.php';
          
            $rootPath = fileIniReader($rootPathFile);
           
            echo "<div><p><h3> Old root path value: " . $rootPath . "</h3></p></div><br><br>";
            echo "<p hidden id = 'allRoot'>" . $allRoots . "</p>";
            echo "<div><p><h3> Possible roots installations: </h3></p> <br>";

            $output = runAllRoots($allRoots); //splitted in pieces (rows)

            echo '<div class="row">';
            echo '<h4 class="col-xs-12"> Possible roots installations:</h4>';
            echo '<div class="dropdown col-xs-4">';
            echo '<button id="verboseButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Root existing installations:';
            echo '<span class="caret"></span></button>';
            echo '<ul class="dropdown-menu">';
            for ($i = 0; $i < count($output)-1; $i++) {//last is empty
                echo '<li><a href="#" onclick="changeRoot' . '(' . $i . ')' . '">' . $output[$i] . '</a></li>';
                echo '<p hidden id = "roots'. $i .'" >' . $output[$i] . '</p>';
            }
            echo '</ul>';
            echo '</div></div>';

            echo "</div>";
        ?>
        <br><br>

        <div class="row">
            <div class="col-xs-2">
                <label for="newRoot" class="form-control-label"><p> Selected Root version: </p></label>
            </div>
            <div class="col-xs-4" >
                <input readonly type="text" id="newRoot" name="newRoot" class="form-control" placeholder="Root Version in use">
            </div>
        </div>    
        
        <button id="configConfirmationButton" onclick="writeNewRoot()" type="button" class="btn btn-primary btn-lg bottomRight">
            Confirm changes to Root Path
        </button>
    </body>
</html>    