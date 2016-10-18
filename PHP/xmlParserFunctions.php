<?php
    /*! \brief This is a test script, just to evaluate how can PHP read an xml file
     *
     *  The xml file read is not a vector, but a "tree". Also, the informations that we need are
     *  not in leaves, but in attritutes. Following there is a working solution to read 
     *  the needed data correctly
     */
    $xml=simplexml_load_file("../testXml.xml") or die("Error: Cannot create object");
    //print_r($xml);
    foreach($xml->children() as $c) 
    {
        //echo $c;
        //echo "<br> cycle outside";
        foreach($c->children() as $cin) 
        {
            echo $cin["from"] ."<br>";
            echo $cin["to"] ."<br>";
            echo $cin["entry"] ."<br>";
        }

    } 

?>
