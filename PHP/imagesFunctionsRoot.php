<?php

	function echoRootLike($runs, $allAnalyzesSingle)
	{
		$cleanAnalyzes = getGroupsFromFolder( $allAnalyzesSingle );
		for ($i = 0; $i < count($runs); $i++) 
		{
			for ($a = 0; $a < count( $cleanAnalyzes ); $a++)
			{
				echo "<div id='image" . $runs[$i] . "-" . $cleanAnalyzes[ $a ] ."' style='width: 100% height: 100%'>";
				echo "</div><br>";	
			}			
		}
	}
	
?>