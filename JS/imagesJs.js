//OLD VERSION OF SELRUN:
//the user selects one run (or all), this function shows him only what he selected.
// This function do this simply recharging this page, but with the new parameters 
//(in this case the parameters are the selected runs).
/*function selRun(runs)
{
    //alert(runs);
    var toSend = "images.php?runs="; 

    if (runs.isArray)
    {
        alert(runs[0]);
        //for (var i = 0; i <(runs.length - 1); i++)
        //{
         //   toSend = toSend + runs[i] + ';';
        //};
        //alert('array');
    }
    else
    {
        //alert('not array');
        toSend = toSend + runs + ';';
    }
    window.location.href =  toSend;
}*/

// The user selects one run, this function shows him only what he selected.
// This function does this checking the names of the images, these names contain 
// the run-numbers
function selRun(run)
{
    $( "#runToShowButton" ).text( "Selected Run: " + run );
    /*$("img[name*='n']").hide(); //firstly we hide all images (all images have names that begin with 'n')
    $("item[name*='n']").hide(); //exactly the same with the item (is a contain) of the carousel
    $("img[name*=" + run+  " ]").show(); // after we show the group that interest us
    $("item[name*=" + run+  " ]").show(); //exactly the same with the li of the carousel
    */
}



//this function allow to chose what kind of images shown (there are some groups:
// mimito, scint ecc)
function selectImageType(n)
{
    //alert("n: " +n);
    var groups = $("#hereTheGroups").text();
    groups = groups.split("-");
    //alert( groups );
    var thisGroup = groups[ (n + 1) ];
    $( "#groupToShowButton" ).text( "Selected group: " + thisGroup );
    //alert(thisGroup);
    var typeSelected="none";
    images = $( '[id*="image"]' )
    for ( i = 0; i < images.length; i++ )
    {
        thisImage = images[ i ];
        thisImage.style.display = 'none';
        //alert( thisImage.id );
        id = thisImage.id;
        //alert( id );
        if( id.indexOf(thisGroup) !== -1 )
        {
            thisImage.style.display = 'block';
        }
    }
}

//this function allows the changing of the layout of the images (vertical or 
//carousel)
function selectSlideImage(n)
{
    $("#carouselBlock").hide();
    $("#verticalBlock").hide();
    if(n==0)
    {
        $("#layoutButton").text("Vertical Layout Images");
        //$("#labelImagesLayout").text("Now: Layout Images Vertical");
        $("#verticalBlock").show();
    }
    if(n==1)
    {
        $("#layoutButton").text("Carousel Layout Images");
        //$("#labelImagesLayout").text("Now: Layout Images Carousel");
        $("#carouselBlock").show();
    }
}


//when I click on an image I expect that it opens a new window with the image
//shown
function imageClicked(n, runs)
{
    window.location.href =  'showOneImage.php/?whichImage='+n + '&runs=' + runs; 
}


//this function allows to change the images dimensione according to the choice 
//taken in the dropdown menu 
function setImageDimension(n)
{
    var groups = $("#groupList").text();
    groups = groups.split("-");
    thisGroup = groups[n]; 
    if(n==0)//little (is this usefull? maybe is too little?)
    {
        $("#dimensionButton").text("Selected dimension: Little");
        for (i = 0; i < groups.length; i++)
        {
            $("#" + groups[i] + "PartVertical").children().toggleClass("col-xs-6",false);
            $("#" + groups[i] + "PartVertical").children().toggleClass("col-xs-12",false);
            $("#" + groups[i] + "PartVertical").children().addClass("col-xs-3");
        }     
        $("#carouselBlock").toggleClass("col-xs-12", false);
        $("#carouselBlock").toggleClass("col-xs-6", false);
        $("#carouselBlock").addClass("col-xs-3");
    }
    if(n==1)//medium
    {
        $("#dimensionButton").text("Selected dimension: Medium");
        for (i = 0; i < groups.length; i++)
        {
            $("#" + groups[i] + "PartVertical").children().toggleClass("col-xs-3",false);
            $("#" + groups[i] + "PartVertical").children().toggleClass("col-xs-12",false);
            $("#" + groups[i] + "PartVertical").children().addClass("col-xs-6");
        }
        $("#carouselBlock").toggleClass("col-xs-3", false);
        $("#carouselBlock").toggleClass("col-xs-12", false);        
        $("#carouselBlock").addClass("col-xs-6");
    }
    if(n==2)//large
    {
        $("#dimensionButton").text("Selected dimension: Big");
        for (i = 0; i < groups.length; i++)
        {
            $("#" + groups[i] + "PartVertical").children().toggleClass("col-xs-3",false);
            $("#" + groups[i] + "PartVertical").children().toggleClass("col-xs-6",false);
            $("#" + groups[i] + "PartVertical").children().addClass("col-xs-12");
        }
        $("#carouselBlock").toggleClass("col-xs-3", false);
        $("#carouselBlock").toggleClass("col-xs-6", false);
        $("#carouselBlock").addClass("col-xs-12");
    }
}

function img_find() {
    var imgs = document.getElementsByTagName("img");
    var imgSrcs = [];

    for (var i = 0; i < imgs.length; i++) {
        imgSrcs.push(imgs[i].src);
    }

    return imgSrcs;
}

function download()
{
    var list = document.getElementsByTagName("svg");
    //alert( list[0] );
    for( i = 0; i < list.length; i++)
    {
        var svgData = list[ i ].outerHTML;
        if( svgData.indexOf( '<svg class="jsroot root_canvas"' ) !== -1)
        {
            //alert( svgData );
            var svgBlob = new Blob([svgData], {type:"image/svg+xml;charset=utf-8"});
            var svgUrl = URL.createObjectURL(svgBlob);
            var downloadLink = document.createElement("a");
            downloadLink.href = svgUrl;
            downloadLink.download = "rootImageAegis.svg";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);    
        }        
    }
}

function updateGUI() 
{
    var runs = $( "#getRuns" ).text();
    var runsArray = runs.split("-");
    var groups = $( "#hereTheGroups").text();
    var groupsArray = groups.split("-");
    //alert( groupsArray );

    for( var a = 1; a < runsArray.length ; a++ )
    {
        var thisRun = runsArray[ a ];
        //alert( thisGroup );
        var filename = "output/gAnOut_" + thisRun + ".root";
        //tipical error: filename doesn't exist. If error check this before. (maybe too many slash or no slash)
        JSROOT.OpenFile(filename, function(file) {
            for ( var i = 1; i < ( file.fKeys.length - 1 ); i++ )//for all the keys in the file
            {
                var name = file.fKeys[i].fName;
                file.ReadObject(name, function(obj) {
                    for( var k = 1; k < groupsArray.length; k++ )
                    {
                        var thisGroup = groupsArray[ k ];
                        var whereToDraw = 'image' + thisRun + "-" + thisGroup;
                        //alert (whereToDraw);
                        JSROOT.redraw( whereToDraw , obj, "colz" );//draw the object, in the div object_drawCNT
                    }   
                });
            }
        });  
    }
   
    

    
}

$( document ).ready(function() {// start only when the page is already charged, to avoid all problems
  updateGUI();
});

