<!DOCTYPE html>
<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <script src="JS/index.js"></script>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="CSS/index.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="indexGeneral">  
        <h1>Read some info from Aegis Log-page</h1>
        <?php
            /*! \brief This script aims to test if php can read from the runlog page of aegis some information
             *
             *   We try to read from the runlog pages some info using curl. After we want to elaborate these
             *   information to check which run are empty (we search the words 'empty' and 'bad' in the 
             *   row related to the run). it seems to work but we need to authenticate. It is feasible, BUT
             *   it is not a good idea use the user-pass of aegis in the code in clear, so we need to find 
             *   another solution
             *   
             */

            // create curl resource
            echo "point 0 works";
            $ch = curl_init();
            echo "point 1 works";
            // set url
            $url = "https://aegisgateway.cern.ch:8443/elog/RunLog/2886";
            curl_setopt($ch, CURLOPT_URL, $url);
            echo "point 2 works";

            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            echo "point 3 works";

            // $output contains the output string
            $output = curl_exec($ch);
            echo "point 4 works";

            // close curl resource to free up system resources
            curl_close($ch); 
            echo $output;
        ?>
    </body>
</html>