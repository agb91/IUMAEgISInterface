/* 
this is just for initialize the radiobuttons when the old gUser.ini file
is read, using the file's values
 */

$( document ).ready(function() {
	
    for( i = 0 ; i < groups.length ; i++ )
    {
        if( values[i] == '0' )
        {
            $( "#label" + groups[i] ).text( groups[i] +  "now: No" );
        }
        else
        {
            $( "#label" + groups[i] ).text( groups[i] +  "now: Yes" );
        }
    }
    
})