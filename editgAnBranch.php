<!DOCTYPE html>
<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <script src="JS/editgAnBranchJs.js"></script>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="CSS/editConfig.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="configurator">  
        <div class="row">
            <p><h1 class="col-xs-6"> Chose which gAn branch use</h1></p>
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
            include 'PHP/editgAnBranchFunctionsCommons.php';

            $branches = checkForBranches();
            
            echo '<div class="row">';
            echo '<h4 class="col-xs-12"> Existing Branches:</h4>';
            echo '<div class="dropdown col-xs-4">';
            echo '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Existing Branches:';
            echo '<span class="caret"></span></button>';
            echo '<ul class="dropdown-menu">';
            for ($i = 0; $i < count($branches)-1; $i++) {//last is empty
                if( strpos($branches[$i], 'tar') == false )
                {
                    echo '<li><a href="#" onclick="changeBranch' . '(' . $i . ')' . '">' . $branches[$i] . '</a></li>';
                    echo '<p hidden id = "branch' . $i . '" > ' . $branches[$i] . ' </p>';
                }
            }
            echo '</ul>';
            echo '</div></div>';

            echo "</div>";
            echo "<br>";
            echo 'You chose:  <p id = "branch" > </p>';
        ?>
        <br><br>

        
        <button id="configConfirmationButton" onclick="registerBranch()" type="button" class="btn btn-primary btn-lg bottomRight">
            Confirm changes to Branch
        </button>
    </body>
</html>    