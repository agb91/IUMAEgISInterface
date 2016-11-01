//when jquery is loaded and document is ready (we can't do nothing before): 
$( document ).ready(function() {
    $( "#datepicker" ).datepicker();
    lastDate = $( "#lastTime" ).text();
    dd = lastDate.split( "/" )[0];
    mm = lastDate.split( "/" )[1];
    yy = lastDate.split( "/" )[2];
    $( "#datepicker" ).datepicker( 'setDate' , mm + '/' + dd + "/" + yy );

    //to use the tooltip we have to initialize it here
    $('[data-toggle="tooltip"]').tooltip();

    //the following commands are always are executed sometimes in single
    //version of the interface, some other times in multiple 
    //validate the inserted runs
    //first of all, disable the run-send-button (until the run number isn't correct)
    $("#sendRunButtonSingle").prop("disabled",true);
    $("#warningRunNumberSingle").hide();
    $("#sendRunButtonMultiple").prop("disabled",true);
    $("#warningRunNumberMultiple").hide();

    //check if the run-number make sense, and at that moment unlock the send-run-button
    //validate( 0 );
    //validate( 1 );

    $( "#whichRunSingle" ).keyup(function() {//check every time the user uses the keyboard 
        validate( 0 );
    });  
    $( "#whichRunsMultiple" ).keyup(function() {//check every time the user uses the keyboard 
        validate( 1 );
    });

    $( "#buttonSelectAnalysisSingle" ).click(function() {//check every time the user click this button
        validate( 0 );
    });
    $( "#buttonSelectAnalysisMultiple" ).click(function() {//check every time the user click this button
        validate( 1 );
    });
    
    $( "#whichRunSingle" ).click(function() {//check every time the user clicks with the mouse on the input form
        validate( 0 );
    });  
    $( "#whichRunsMultiple" ).click(function() {//check every time the user clicks with the mouse on the input form
        validate( 1 );
    });

    $( "#whichRunSingle" ).mouseover(function() {//check also only if the mouse pass on the input form
        //it make sense because if you insert by range when the form is empty this check and only this 
        // allows the green button 
        validate( 0 );
    });
    $( "#whichRunMultiple" ).mouseover(function() {//check also only if the mouse pass on the input form
        //it make sense because if you insert by range when the form is empty this check and only this 
        // allows the green button 
        validate( 1 );
    })
});

//select if you want to work with single or multiple runs
function selectSingleVsMultiple( n )
{
    $( "#chooseModality" ).hide();
    $( "#changeModality" ).show();
    if( n == 0)//and the other red
    {
        $( "#nowSingle" ).show();
        $( "#nowMultiple" ).hide();    
    }
    else
    {
        
        $( "#nowMultiple" ).show();
        $( "#nowSingle" ).hide();
    }
    showOtherObject(n);    
}

function setGreen(n)
{
    var dates = $( "#allDates" ).text();
    var dates = dates.split( ";-;" );
    for( var i = 0; i < dates.length ; i++)
    {
        $( "#link" + i ).toggleClass( "green" , false );
        $( "#link" + i ).addClass("white");
    }
    $( "#link" + n ).toggleClass( "white" , false );
    $( "#link" + n ).addClass("green");
}

function changeModality()
{
    location.reload();//simple reload the page and re-propose the choice
}

//show all the rest of the page
function showOtherObject( n )
{
    $( "#workBlock" ).show();
    if( n == 0)
    {
        $( "#multiple" ).hide();
        $( "#single" ).show();
    }
    else
    {
        $( "#multiple" ).show();
        $( "#single" ).hide();
    }
    
}

//it is a good idea if we standardize comma and '-' with semicolon
function readCleanRun( n )
{
    var insertedRun = " ";
    if( n == 0)
    {
        insertedRun = $("#whichRunSingle").val();
    }
    else
    {
        insertedRun = $("#whichRunsMultiple").val();
    }
    insertedRun = insertedRun.replace(new RegExp(",", "g"), ";");// we want to allow the user to separate the run numbers 
    //also with comma and '-' and point
    insertedRun = insertedRun.replace(new RegExp("-", "g"), ";");
    insertedRun = insertedRun.replace(new RegExp(" ", "g"), "");
    if( insertedRun.substr( insertedRun.length - 1 ) == ";" )
    {
        insertedRun = insertedRun.substr( 0 , insertedRun.length - 1 );
    }
    //alert( insertedRun + "---");
    return insertedRun;
}

function selectDate( thisDate )
{
    var dates = $( "#allDates" ).text();
    var dates = dates.split( ";-;" );
    //var rex = /\S/;
    //dates = dates.filter(rex.test.bind(rex));
    //alert(dates[0]);
    for( var i = 0; i < dates.length ; i++)
    {
        $( "#run" + i ).hide();    
    }
    $( "#run" + thisDate ).show();
    //alert($("#run"+thisDate);
}

//divide the string by semi-colon, point, comma (all accepted divisors), check if the chucks are numbers
function validate( n ) 
{
    if( n == 0)
    {
        var insertedRun = readCleanRun( 0 );
        var insertedArray = insertedRun.split(";"); 
        var singleRun;
       
        var numberProblems = 0;
        var analysisProblems = 0;
        if ( insertedArray.length > 1 )
        {
            numberProblems++;
        }
        //have you selected an analysis?
        if( $("#buttonSelectAnalysisSingle").text() == "Select an Analysis Tools:"  )
        {
            analysisProblems++;
            //alert("analysis problems");
        }
        for (i in insertedArray) {
            insertedArray[i] = insertedArray[i].trim();
            if ( acceptable ( insertedArray[ i ] ) == 1 )
            {
                numberProblems++;
            }
        }

        if (numberProblems == 0)        {
            $("#warningRunNumberSingle").hide();
        }
        else
        {
            $("#warningRunNumberSingle").show();
        }

        if (analysisProblems == 0)        {
            $("#warningSelectAnalysisSingle").hide();
        }
        else
        {
            $("#warningSelectAnalysisSingle").show();
        }

        //alert("not numeric objects: " + noNumeric);
        if(numberProblems==0 && analysisProblems == 0)
        {
            $("#sendRunButtonSingle").prop("disabled",false);
            $("#sendRunButtonSingle").removeClass( "red" ).addClass( "green" );        }
        else
        {
            $("#sendRunButtonSingle").prop("disabled",true);
            $("#sendRunButtonSingle").removeClass( "green" ).addClass( "red" );
        }
        if(insertedRun.length=="0")
        {
            $("#warningRunNumberSingle").hide();
        }
    }  
    else
    {
        var insertedRun = readCleanRun( 1 );
        var insertedArray = insertedRun.split(";"); 
        var MultipleRuns;
       
        var numberProblems = 0;
        var analysisProblems = 0;

        //have you selected an analysis?
        if( $("#buttonSelectAnalysisMultiple").text() == "Select an Analysis Tools:"  )
        {
            analysisProblems++;
            alert("analysis problems");
        }
        for (i in insertedArray) {
            insertedArray[i] = insertedArray[i].trim();
            if ( acceptable ( insertedArray[ i ] ) == 1 )
            {
                numberProblems++;
            }
        }

        if (numberProblems == 0)        {
            $("#warningRunNumberMultiple").hide();
        }
        else
        {
            $("#warningRunNumberMultiple").show();
        }

        if (analysisProblems == 0)        {
            $("#warningSelectAnalysisMultiple").hide();
        }
        else
        {
            $("#warningSelectAnalysisMultiple").show();
        }

        //alert("not numeric objects: " + noNumeric);
        if(numberProblems==0 && analysisProblems == 0)
        {
            $("#sendRunButtonMultiple").prop("disabled",false);
            $("#sendRunButtonMultiple").removeClass( "red" ).addClass( "green" );        }
        else
        {
            $("#sendRunButtonMultiple").prop("disabled",true);
            $("#sendRunButtonMultiple").removeClass( "green" ).addClass( "red" );
        }
        if(insertedRun.length=="0")
        {
            $("#warningRunNumberMultiple").hide();
        } 
    }  
}

function manageWait( n ) {
    if( n == 0)
    {
        w = document.getElementById("waitSingle");
        w.style.display = 'block';//show the label with "wait until...."
    }
    else
    {
        w = document.getElementById("waitMultiple");
        w.style.display = 'block';//show the label with "wait until...."
    }
}

/*
open the modal that allows to insert multiple runs by range (from run .. to run ..)
*/
function addRangeModal(){
    $("#addRangeModal").modal();
}
/*
function changeRootModal(){
    $("#changeRootModal").modal();
}

function changeRootPath()
{
    var newRootFile = $("#newRoot").val();
    //alert("new rootPath is:" + newRootFile);
}*/

//check if there is another chunk with the same name, (double runs are useless)
function checkAlreadyExist(needle , n)
{
    if( n == 0)
    {
        needle = " " + needle; //javascript wants a string or it will crash with the trim....
        //alert("needle: " + needle);
        haystack = $("#whichRunSingle").val().split(";");
        //alert("haystack: " + haystack);
        var alreadyExist = false;
        for (i in haystack) 
        {
            //console.log("needle " + needle);
            if(haystack[i].trim()==needle.trim())
            {
                alreadyExist = true;
            }
        }
        return alreadyExist;
    }
    else
    {
        needle = " " + needle; //javascript wants a string or it will crash with the trim....
        //alert("needle: " + needle);
        haystack = $("#whichRunMultiple").val().split(";");
        //alert("haystack: " + haystack);
        var alreadyExist = false;
        for (i in haystack) 
        {
            //console.log("needle " + needle);
            if(haystack[i].trim()==needle.trim())
            {
                alreadyExist = true;
            }
        }
        return alreadyExist;
    }
}

/*
add the range of runs written in the modal to the input form
*/
function addRange()
{
    var first = $("#first").val().trim();
    var last = $("#last").val().trim();
    if(parseInt(first)>=parseInt(last))//the first run obviously cannot have a value < the last run..
    {
        alert("Fist must be less than Last..");
        $("#modalCloseRange").click();
    }
    else
    {
        for (r = first; r <= last; r++) 
        { 
            //console.log("r: " + r);
            if(acceptable(r)==0 && !checkAlreadyExist(r))
            {            
                //console.log("thiscase");
                old = $("#whichRunMultiple").val();    
                if(old.length!==0)
                {
                    var newNumber = old + "; " + r;
                }      
                else
                {
                    newNumber = r;
                }  
                newNumber = newNumber.replace(";;", ";"); 
                $("#whichRunMultiple").val(newNumber);
            }
        }
    }
    $("#modalCloseRange").click();//exit the modal, return to home.
    validate(); // recheck the send button (is the input acceptable?)
}

//write which analysis the user chooses 
function setAnalysis( i , n )
{
    if( n == 0)
    {
        var analyzes = $("#analyzesSingle").text();
        var analyzesVector = analyzes.split("--");
        var selectedAnalysis = analyzesVector[ i ];
        $("#selectedAnalysisSingle").val(selectedAnalysis);
        $("#buttonSelectAnalysisSingle").text("Selected: " + selectedAnalysis);
    }
    else
    {
        var analyzes = $("#analyzesMultiple").text();
        var analyzesVector = analyzes.split("--");
        var selectedAnalysis = analyzesVector[ i ];
        $("#selectedAnalysisMultiple").val(selectedAnalysis);
        $("#buttonSelectAnalysisMultiple").text("Selected: " + selectedAnalysis);
    }
    //alert(selectedAnalysis);
    validate( n );
}

//has this run number some problems? (not unique, not a number, not empty)
// 0=good;      1=bad
function acceptable( r )
{
    //alert(r);
    //console.log(r);
    var risp = 1;
    if($.isNumeric(r) )
    {  
        risp = 0;
    }
    //console.log(risp);
    return risp;
}



