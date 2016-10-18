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
    $("img[name*='n']").hide(); //firstly we hide all images (all images have names that begin with 'n')
    $("item[name*='n']").hide(); //exactly the same with the item (is a contain) of the carousel
    $("img[name*=" + run+  " ]").show(); // after we show the group that interest us
    $("item[name*=" + run+  " ]").show(); //exactly the same with the li of the carousel
}



//this function allow to chose what kind of images shown (there are some groups:
// mimito, scint ecc)
function selectImageType(n)
{
    //alert("n: " +n);
    var groups = $("#groupList").text();
    groups = groups.split("-");
    thisGroup = groups[n]; 
    //alert(groups);
    var typeSelected="none";

    for (i = 0; i < groups.length; i++)
    {
        $("#" + groups[i] + "PartVertical").hide();
        $("#" + groups[i] + "PartCarousel").hide();
    }

    $("#groupToShowButton").text("Group: "+thisGroup);
    $("#" + thisGroup + "PartCarousel").show();
    $("#" + thisGroup + "PartVertical").show();
    typeSelected = thisGroup;
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
        $("#imageDimensionButton").text("Image: Little");
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
        $("#imageDimensionButton").text("Image: Medium");
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
        $("#imageDimensionButton").text("Image: Big");
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
    imgSources = document.getElementsByName("toSaveImage");
    for (i = 0; i < imgSources.length; i++) 
    { 
        imgSources[i].click();
    }
    //console.log(imgSources.length);
}
