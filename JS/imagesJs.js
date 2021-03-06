//alert("loaded");


function showImages()
{
    $( "#runnerTab" ).hide();
    $( "#picturesTab" ).show();    
}

function showTextualRunner()
{
    $( "#runnerTab" ).show();
    $( "#picturesTab" ).hide();    
}


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
    var groups = $("#hereTheGroups").text();
    groups = groups.split("-");
    //alert( groups );
    var thisGroup = groups[ (n + 1) ];
    //alert( thisGroup );
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
    images = $( '[id*="image"]' )
    for ( i = 0; i < images.length; i++ )
    {
        thisImage = images[ i ];
        //alert(thisImage.style);
        thisImage.style.removeProperty("height");
    }
    if(n==0)//little (is this usefull? maybe is too little?)
    {
        $("#dimensionButton").text("Selected dimension: Little");

        $("#verticalBlock").toggleClass("big", false);
        $("#verticalBlock").toggleClass("medium", false);
        $("#verticalBlock").addClass("little");
    }
    if(n==1)//medium
    {
        $("#dimensionButton").text("Selected dimension: Medium");
        
        $("#verticalBlock").toggleClass("big", false);
        $("#verticalBlock").toggleClass("little", false);
        $("#verticalBlock").addClass("medium");
    }
    if(n==2)//large
    {
        $("#dimensionButton").text("Selected dimension: Big");

        $("#verticalBlock").toggleClass("medium", false);
        $("#verticalBlock").toggleClass("little", false);
        $("#verticalBlock").addClass("big");
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

function downloadImages()
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

/*function updateGUI() 
{
    var runs = $( "#getRuns" ).text();
    //alert( runs );
    var runsArray = runs.split("-");
    //alert (runsArray);
    var groups = $( "#hereTheGroups").text();
    var groupsArray = groups.split("-");
    //alert( groupsArray );

    for( var a = 1; a < (runsArray.length - 1)  ; a++ )
    {
        var thisRun = runsArray[ a ];
        var filename = "output/gAnOut_" + thisRun + ".root";
        //tipical error: filename doesn't exist. If error check this before. (maybe too many slash or no slash)
        JSROOT.OpenFile(filename, function(file) {
            for ( var i = 1; i < ( file.fKeys.length - 1 ); i++ )//for all the keys in the file
            {
                console.log( file );
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
}*/


function updateGUI() 
{
    var runs = $( "#getRuns" ).text();
    //alert( runs );
    var runsArray = runs.split("-");
    //alert (runsArray);
    var groups = $( "#hereTheGroups").text();
    var groupsArray = groups.split("-");
    //alert( groupsArray );

    for( var a = 1; a < (runsArray.length - 1)  ; a++ )
    {
        var thisRun = runsArray[ a ];
        var filename = "output/gout_" + thisRun + ".root";
        //tipical error: filename doesn't exist. If error check this before. (maybe too many slash or no slash)
        JSROOT.OpenFile(filename, function(file) {
            for ( var i = 1; i < ( file.fKeys.length - 1 ); i++ )//for all the keys in the file
            {
                //console.log( file );
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

