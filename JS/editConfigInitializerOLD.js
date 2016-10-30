/* 
this is just for initialize the radiobuttons when the old gUser.ini file
is read, using the file's values
 */

$( document ).ready(function() {
	$("#labelVerbose").text("Verbose now: " + verbose);
	if(mimito=='0')
	{
		$("#labelmimito").text("Mimito now: No");
	}
	else
	{
		$("#labelmimito").text("Mimito now: Yes");
	}

	if(scint==0)
	{
		$("#labelscint").text("Scint now: No");
	}
	else
	{
		$("#labelscint").text("Scint now: Yes");
	}
    
    if(hdetccd==0)
    {
    	$("#labelhdetccd").text("Hdetccd now: No");
    }
    else
    {
    	$("#labelhdetccd").text("Hdetccd now: Yes");
    }
    
    if(pmt==0)
    {
    	$("#labelpmt").text("Pmt now: No");
    }
    else
    {
    	$("#labelpmt").text("Pmt now: Yes");
    }
    
    if(farcup==0)
    {
    	$("#labelfarcup").text("Farcup now: No");	
    }
    else
    {
    	$("#labelfarcup").text("Farcup now: Yes");	
    }
    
})