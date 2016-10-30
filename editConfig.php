<!DOCTYPE html>
<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <script src="JS/editConfigJs.js"></script>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="CSS/editConfig.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="configurator">  
        <?php
        include 'Globals.php';
        include 'PHP/editConfigFunctionsCommons.php';

        $groups = getAllGroups( $xmlConfigFilePath );
        //print_r( $groups );
        echo "<br>";
        $values = getAllValues( $xmlConfigFilePath , "analysis_base");
        //print_r( $values );
        //echo $values[0];
        ?>
        <script>
            //alert("ciao");

            path = '<?php echo $xmlConfigFilePath; ?>';
            
            groups = [];
            values = [];
            //why this horrible construction? because javacript is not very happy to use php code like argument..
            groups.push('<?php echo $groups[0]; ?>');
            groups.push('<?php echo $groups[1]; ?>');
            groups.push('<?php echo $groups[2]; ?>');
            groups.push('<?php echo $groups[3]; ?>');
            groups.push('<?php echo $groups[4]; ?>');
            groups.push('<?php echo $groups[5]; ?>');
            groups.push('<?php echo $groups[6]; ?>');
            groups.push('<?php echo $groups[7]; ?>');
            groups.push('<?php echo $groups[8]; ?>');
            groups.push('<?php echo $groups[9]; ?>');

            values.push('<?php echo $values[0]; ?>');
            values.push('<?php echo $values[1]; ?>');
            values.push('<?php echo $values[2]; ?>');
            values.push('<?php echo $values[3]; ?>');
            values.push('<?php echo $values[4]; ?>');
            values.push('<?php echo $values[5]; ?>');
            values.push('<?php echo $values[6]; ?>');
            values.push('<?php echo $values[7]; ?>');
            values.push('<?php echo $values[8]; ?>');
            values.push('<?php echo $values[9]; ?>');
        </script>   

        <div class="row">
            <h1 class="col-xs-6"> Welcome to the configurator</h1>
            <div class="col-xs-3"></div>
            <div class="col-xs-3">
                <button onclick="window.location.href='index.php'" type="button" class="lower btn btn-primary btn-lg topRight">
                    Back to Home
                </button>
            </div>
        </div>  
        <br>
        <h3> This is the gAn initialization file, the user here customize its analysis sequence</h3> <br>
        
        <?php
            for ($i = 0; $i < count($groups); $i++) 
            {
                echo '<div class="row">';
                echo '<h4 class="col-xs-12"> ' . $groups[$i] . ' possible values: </h4>';
                echo '<div class="dropdown col-xs-4">';
                echo '<button id="' . $groups[$i] . 'Button" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">' . $groups[$i] . ' possible values:
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li><a href="#" onclick="changer' . '(' . $i . ',0)">No</a></li>
                          <li><a href="#" onclick="changer' . '(' . $i . ',1)">Yes</a></li>
                        </ul>';
                echo '</div>'; 
                echo '<div class="col-xs-8">';
                echo '<label id="label' . $groups[$i] . '"> ' . $groups[$i] . ' now:  </label>';
                echo '</div>';
                echo '</div>';
            }

        ?>

        <br><br><br><br>
            <button id="configConfirmationButton" onclick="writeToFile(path)" type="button" class="btn btn-primary btn-lg bottomRight">
                Confirm changes and write to file
            </button>
        </div>
        <!-- initialize the dropdown menus-->
        <script src="JS/editConfigInitializer.js"></script>

   
    </body>
</html>    



