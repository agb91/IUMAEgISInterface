<?php

include "editConfigFunctionsCommons.php";




function echoGroupList($allAnalyzesSingle)
{
    $cleanAnalyzes = getGroupsFromFolder( $allAnalyzesSingle );
    echo "<p hidden id='hereTheGroups'>";
    for ($i = 0; $i < count( $cleanAnalyzes ); $i++) 
    {
        echo '-' . $cleanAnalyzes[ $i ];
    } 
    echo "</p>";
    for ($i = 0; $i < count( $cleanAnalyzes ); $i++) 
    {
        echo '<li><a href="#" id="' . "groupButton". $i . '" onclick="selectImageType(' . ($i) . ')">' . $cleanAnalyzes[$i] . '</a></li>';
    } 
}

/*! \brief showRuns($runs)
 *
 *  only shows possible runs (runs requested by the user)
 */
function showRuns($runs)
{
    for ($i = 0; $i < count($runs); $i++) //the -1 is because the last is empty...
    {
        echo "<li><a href='#'' onclick='selRun(" . $runs[$i] . ")'>" . $runs[$i] . "</a></li>";    
    }
    //echo "<li><a href='#'' onclick='selRun(" . $runs . ")'>All</a></li>";    
}


?>
