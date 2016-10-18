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
        /*
         * the goal of this class is to create a graphical interface to the classes that edit 
         the file named gUser.ini, that configure the program
         */
        $fileString = fileIniReader($iniFilePath);
        //echo "read file with comments " . $fileString;
        /* divide into rows, and toggle the row which starts with '#'
         * beacuse they are only comments*/
        $fileString = getRowContents($fileString);
        /* now in $filestring there is a cleaned version of the readed file,
         * without comments
         */

        $refinedObjects = menageGroupsForGlobals($fileString);
        //echo $fileString;
        $offSets = getOffsets($fileString, $refinedObjects);// list of the offsets (position in the string of the starting charachter of the object) 

        //echo "<br> offsets:";
        //print_r($offSets);
       
        $readValues = array();
        $fileString = substr($fileString, 0, 400);
        for ($i = 0; $i < count($refinedObjects); $i++) 
        {
            $thisValue = substr($fileString, $offSets[$i], 1);
            array_push($readValues,$thisValue);
        }
        //echo "<br> read values: <br>";
        //print_r($readValues);
        ?>
        
        <!-- il seguente script esporta le variabili per javascript, 
            per poter inizializzare la grafica con i valori attuali-->
        <script>
            var readValues = [];
            var readGroupValues = [];

            var phpValuesArrayLength = '<?php echo count($readValues); ?>';
            var phpGroupArrayLength = '<?php echo count($refinedObjects); ?>';
            //alert(phpArrayLength);
            readQuery = [];
            readGroupQuery = [];
            //why this horrible construction? because javacript is not very happy to use php code like
            //dynamic variables
            readQuery.push('<?php echo $readValues[0]; ?>');
            readQuery.push('<?php echo $readValues[1]; ?>');
            readQuery.push('<?php echo $readValues[2]; ?>');
            readQuery.push('<?php echo $readValues[3]; ?>');
            readQuery.push('<?php echo $readValues[4]; ?>');
            readQuery.push('<?php echo $readValues[5]; ?>');
            readQuery.push('<?php echo $readValues[6]; ?>');
            readQuery.push('<?php echo $readValues[7]; ?>');
            readQuery.push('<?php echo $readValues[8]; ?>');
            readQuery.push('<?php echo $readValues[9]; ?>');
            readQuery.push('<?php echo $readValues[10]; ?>');
            readQuery.push('<?php echo $readValues[11]; ?>');

            //is this structure the best possible? to change it, it is better wait the last modifications
            //of gAn
            readGroupQuery.push('<?php echo $refinedObjects[0]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[1]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[2]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[3]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[4]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[5]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[6]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[7]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[8]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[9]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[10]; ?>');
            readGroupQuery.push('<?php echo $refinedObjects[11]; ?>');


            for (i = 0; i < phpValuesArrayLength; i++) 
            { 
                readValues.push(readQuery[i]);
            }
            for (i = 0; i < phpGroupArrayLength; i++) 
            { 

                readGroupValues.push(readGroupQuery[i]);
            }
            //alert(readValues);
            var verbose = '<?php echo $readValues[0]; ?>';
            var mimito = '<?php echo $readValues[1]; ?>';
            var scint = '<?php echo $readValues[2]; ?>';
            var hdetccd = '<?php echo $readValues[3]; ?>';
            var pmt = '<?php echo $readValues[4]; ?>';
            var farcup = '<?php echo $readValues[5]; ?>';
            var file = '<?php echo $iniFilePath; ?>';
            //alert("read: " + verbose + mimito+scint+hdetccd+pmt+farcup);
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

        <div class="col-xs-8">
            <div class="row">
                <h4 class="col-xs-12"> Verbose possible values: (0 = no verbose; 1 = low verbosity; 2 = mid verbosity; 3 = high verbosity)</h4>
                <div class="dropdown col-xs-4">
                    <button id="verboseButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Verbose possible values:
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      <li><a href="#" onclick="changeVerbose(0)">0</a></li>
                      <li><a href="#" onclick="changeVerbose(1)">1</a></li>
                      <li><a href="#" onclick="changeVerbose(2)">2</a></li>
                      <li><a href="#" onclick="changeVerbose(3)">3</a></li>
                    </ul>
                </div> 
                <div class="col-xs-8">
                    <label id="labelVerbose"> Verbose now:  </label>
                </div>
            </div>
            <?php
                $groups = $refinedObjects;
                for ($i = 1; $i < count($refinedObjects); $i++) 
                {
                    echo '<div class="row">';
                    echo '<h4 class="col-xs-12"> ' . $groups[$i] . ' possible values: </h4>';
                    echo '<div class="dropdown col-xs-4">';
                    $name = $refinedObjects[$i];
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
            <button id="configConfirmationButton" onclick="writeToFile(file)" type="button" class="btn btn-primary btn-lg bottomRight">
                Confirm changes and write to file
            </button>
        </div>
        <!-- initialize the radiobuttons-->
        <script src="JS/editConfigInitializer.js"></script>
    </body>
</html>    



