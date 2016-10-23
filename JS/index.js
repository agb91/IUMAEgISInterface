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

    //validate the inserted runs
    //first of all, disable the run-send-button (until the run number isn't correct)
    $("#sendRunButton").prop("disabled",true);
    $("#warningRunNumber").hide();
    //check if the run-number make sense, and at that moment unlock the send-run-button
    validate();

    $( "#whichRun" ).keyup(function() {//check every time the user uses the keyboard 
        validate();
    });  

    $( "#whichRun" ).click(function() {//check every time the user clicks with the mouse on the input form
        validate();
    });  

    $( "#whichRun" ).mouseover(function() {//check also only if the mouse pass on the input form
        //it make sense because if you insert by range when the form is empty this check and only this 
        // allows the green button 
        validate();
    });
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
    showOtherObject();    
}

function setGreen(n)
{
    var dates = $( "#allDates" ).text();
    var dates = dates.split( ";-;" );
    for( var i = 0; i < dates.length ; i++)
    {
        //alert("#link" + i);
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
function showOtherObject()
{
    $( "#workBlock" ).show();
}

//it is a good idea if we standardize comma and '-' with semicolon
function readCleanRun()
{
    var insertedRun = $("#whichRun").val();
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
function validate() 
{
    var insertedRun = readCleanRun();
    var insertedArray = insertedRun.split(";"); 
    var singleRun;
   
    var noNumeric = 0;
    for (i in insertedArray) {
        insertedArray[i] = insertedArray[i].trim();
        if ( acceptable ( insertedArray[ i ] ) == 1 )
        {
            noNumeric++;
        }
    }
    //alert("not numeric objects: " + noNumeric);
    if(noNumeric==0)
    {
        $("#sendRunButton").prop("disabled",false);
        $("#sendRunButton").removeClass( "red" ).addClass( "green" );
        $("#warningRunNumber").hide();
    }
    else
    {
        $("#sendRunButton").prop("disabled",true);
        $("#sendRunButton").removeClass( "green" ).addClass( "red" );
        $("#warningRunNumber").show();
    }
    if(insertedRun.length=="0")
    {
        $("#warningRunNumber").hide();
    }
}

function manageWait() {
    w = document.getElementById("wait");
    w.style.display = 'block';//show the label with "wait until...."
}

/* 
 * open the modal that add a run through a prompt 
 */
function addRun(){
    $("#addRunModal").modal();
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
function checkAlreadyExist(needle)
{
    needle = " " + needle; //javascript wants a string or it will crash with the trim....
    //alert("needle: " + needle);
    haystack = $("#whichRun").val().split(";");
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
    //alert("answer: " + alreadyExist);
    return alreadyExist;
}

/* 
 * add the new run, written in the modal, in the input form 
 */
function addNumber()
{
    var newNumber = $("#newRun").val().trim();
    if(acceptable(newNumber)==0 && !checkAlreadyExist(newNumber))//if it is acceptable and unique
    {            
        old = $("#whichRun").val();    
        if(old.length!==0)
        {
            var newNumber = old + "; " + newNumber;
        }        
        newNumber = newNumber.replace(";;", ";"); //avoid little (harmless) bugs related to 
        //double semicolon 
        $("#whichRun").val(newNumber);
    }
    else
    {
        if(checkAlreadyExist(newNumber))
        {
            alert("This run number already exists");
        }
        else
        {
            alert("Only numeric values admitted");
        }
    }   
    $("#modalClose").click();//exit the modal, return to home.
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
                old = $("#whichRun").val();    
                if(old.length!==0)
                {
                    var newNumber = old + "; " + r;
                }      
                else
                {
                    newNumber = r;
                }  
                newNumber = newNumber.replace(";;", ";"); 
                $("#whichRun").val(newNumber);
            }
        }
    }
    $("#modalCloseRange").click();//exit the modal, return to home.
    validate(); // recheck the send button (is the input acceptable?)
}

function setAnalysis( n )
{
    alert(n);
}

//has this run number some problems? (not unique, not a number, not empty)
// 0=good;      1=bad
function acceptable(r)
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



