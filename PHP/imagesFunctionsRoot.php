<?php

	function echoRootLike($runs, $allAnalyzesSingle)
	{
		for ($i = 0; $i < count($runs); $i++) 
		{
			echo "<div id='image" . $runs[$i] . "' style='width: 100%'></div><br>";
		}
	}
	
?>