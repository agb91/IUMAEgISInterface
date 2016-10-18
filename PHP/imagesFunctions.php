<?php

/*! \brief This script contains functions for the visualisation in html of the images, organized in different
 *         frameworks
 *
 *  it allows to use vertical layout (more common) and carousel layout (taken from bootstrap, 
 *  maybe useless? to decide). The functions doesn't work with static groups but with the groups
 *  read from the inifile 
 */

/*! \brief echoCarouselParts($imagesPath, $runs, $iniFilePath)
 *
 *  write all the images of some runs(received in input) in the carousel layout
 */
function echoCarouselParts($runs, $iniFilePath)
{
    $whichgAn = fileReaderGeneral("gAnPath.txt");
    //echo $whichgAn . "<br>"; 
    //echo $sourceRootPathNew . "<br>";
    //echo "alive<br>";

    /*if( isgAnSafe($whichgAn) == 1 )
    {
        $whichgAn = "gAn-dev";
        echo "I return to the standard gAn path...";
    }*/

    //echo "IMAGES: " . $whichgAn;
    //echo "imagePath before: " . $imagesPath . "<br>";
    $imagesPath = "/opt/lampp/htdocs/Tesi/gAn/" . trim($whichgAn) . "/output/";
    //echo "imagePath after:  " . $imagesPath . "<br>";


    $groups = menageGroupsForGlobals(getRowContents(fileIniReader($iniFilePath)));
    for ($i = 1; $i < count($groups); $i++) 
    {    
        echo '<div id="' . $groups[$i] . 'PartCarousel" style="display:block">';
        echo '<h4>' . $groups[$i] . ' Group</h4>';
        showOutputImages($groups[$i],0, $imagesPath, $runs);
        echo '</div>';
    }
}

/*! \brief echoVerticalParts($imagesPath, $runs, $iniFilePath)
 *
 *  write all the images of some runs(received in input) in the vertical layout
 */
function echoVerticalParts($runs, $iniFilePath)
{

    $whichgAn = fileReaderGeneral("gAnPath.txt");
    //echo $whichgAn . "<br>"; 
    //echo $sourceRootPathNew . "<br>";
    //echo "alive<br>";

    /*if( isgAnSafe($whichgAn) == 1 )
    {
        $whichgAn = "gAn-dev";
        echo "I return to the standard gAn path...";
    }*/

    //echo "IMAGES: " . $whichgAn;
    //echo "imagePath before: " . $imagesPath . "<br>";
    $imagesPath = "/opt/lampp/htdocs/Tesi/gAn/" . trim($whichgAn) . "/output/";
    //echo "imagePath after:  " . $imagesPath . "<br>";

    $groups = menageGroupsForGlobals(getRowContents(fileIniReader($iniFilePath)));
    for ($i = 1; $i < count($groups); $i++) 
    {
            echo '<div id="' . $groups[$i] . 'PartVertical" style="display:block" class="row">';
            showOutputImages($groups[$i],1,$imagesPath, $runs);
            echo '</div>';
    }
}

/*! \brief echoGroupList($iniFilePath)
 *
 *  show in a dropdown menu the existing groups the existing groups are the groups readed from the inifile 
 */
function echoGroupList($iniFilePath)
{
    //these 3 functions from Global.php allow us to extract an array of groups from the iniconfig file
    $groups = menageGroupsForGlobals(getRowContents(fileIniReader($iniFilePath)));
    for ($i = 1; $i < count($groups); $i++) 
    {
        echo '<li><a href="#" id="' . "groupButton". $i . '" onclick="selectImageType(' . ($i-1) . ')">' . $groups[$i] . '</a></li>';
    }  
    echo '<div id="groupList" style="display:none">';
    for ($i = 1; $i < count($groups); $i++) 
    {
        echo $groups[$i] . "-";
    }
    echo '</div>';
}

/*! \brief showRuns($runs)
 *
 *  only shows possible runs (runs requested by the user)
 */
function showRuns($runs)
{
    //print_r($runs);
    for ($i = 0; $i < count($runs)-1; $i++) //the -1 is because the last is empty...
    {
        echo "<li><a href='#'' onclick='selRun(" . $runs[$i] . ")'>" . $runs[$i] . "</a></li>";    
    }
    //echo "<li><a href='#'' onclick='selRun(" . $runs . ")'>All</a></li>";    
}


/*! \brief generalCarouselOneGroup($group, $images, $imagesPath, $identifiers ,$runs)
 *
 *  build the framework for a group
 *  this is based of the public example provided by bootstrap userguide
 */
function generalCarouselOneGroup($group, $images, $imagesPath, $identifiers ,$runs)
{
    $identifier = "";
    //print_r($identifiers);
 
    for ($i = 0; $i < count($identifiers); $i++)
    {
        //echo "group: " . $group . ";    id=" . explode("-",$identifiers[$i])[1] . "<br>";
        if($group==explode("-",$identifiers[$i])[1]  )
        {
            $identifier = explode("-",$identifiers[$i])[0];
        }
    }
    //first part: the round little icons of the carousel
    echo '<div id="myCarousel'.$group.'" class="carousel slide" data-ride="carousel">';
    echo '<ol class="carousel-indicators">';
    $sliderCarusel=0;
    foreach($images as $curimg){
        $imageRun = end(explode('/',$curimg)); //the last part because this is a complete path
        //echo $imageRun . "<br>";
        $imageRun = explode('_',$imageRun)[0];//the first part of the name is the run of the image
        //echo $imageRun . "<br>";

        if(strpos($curimg,  $identifier) !== false && in_array($imageRun, $runs))
        {
            //echo $imageRun . "<br>";
            if($sliderCarusel==0)//if is the preselected image (not important..)
            {
                echo '<li name = "n' . $imageRun .'" data-target="#myCarousel'.$group.'" data-slide-to="' . $sliderCarusel. '" class="carousel-index active"></li>';  
            }
            else 
            {
                echo '<li name = "n' . $imageRun .'" data-target="#myCarousel'.$group.'" data-slide-to="' . $sliderCarusel. '" class="carousel-index"></li>';
            }
            $sliderCarusel++;
        }
    }
    echo '</ol>';

    //second part, the images itself
    echo '<div class="carousel-inner" role="listbox">';
    $index = 0;
    $foundImages = 0;
    foreach($images as $curimg){
        $imageRun = end(explode('/',$curimg)); //the last part because this is a complete path
        //echo $imageRun . "<br>";
        $imageRun = explode('_',$imageRun)[0];//the first part of the name is the run of the image
        //echo $imageRun . "<br>";
        if(strpos($curimg, $identifier) !== false && in_array($imageRun, $runs))
        {
            //echo $imageRun . "<br>";
            if($index==0)//if is the pre-selected image 
            {
                echo '<div name = "n' . $imageRun .'" class="item active">';
            } 
            else
            {
                echo '<div name = "n' . $imageRun .'" class="item">';    
            }  
                $pieces = explode("/", $curimg); // i take only the last part of the pathname
                $imageName=$pieces[count($pieces)-1];
                $path = "../gAn/testReadImage.php?image=".$imageName;
                echo '<img name = "n' . $imageRun .'" onclick = imageClicked("'.$path.'","' . $sRuns .'") src="'.$path.'">';
            echo '</div>';
            $index++;
            $foundImages++;
        }
    }        
    echo '</div>';
    if($foundImages==0)
    {
        echo '<br><br><br><h4> No found images with this group for the selected runs </h4>';
    }

    //go forward and go back icons
    echo '<a class="left carousel-control" href="#myCarousel'.$group.'" role="button" data-slide="prev">';
    echo '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
    echo '<span class="sr-only">Previous</span>';
    echo '</a>';
    echo '<a class="right carousel-control" href="#myCarousel'.$group.'" role="button" data-slide="next">';
    echo '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
    echo '<span class="sr-only">Next</span>';
    echo '</a>';
    echo "</div>";
}

/*! \brief showImagesCarousel($dirname, $images, $identifiers, $whichGroup, $runs)
 *
 *  create the framework in which insert the images in the "carousel" case
 */
function showImagesCarousel($dirname, $images, $identifiers, $whichGroup, $runs)
{
    //print_r($runs);
    for ($i = 0; $i < count($identifiers); $i++)//for each identifiers
    {
        //for clearness: identifiers structure=    "NameInTheImage-NameOfTheGroup"
        if($whichGroup==explode("-",$identifiers[$i])[1])//on the right side of the identifiers the
        //name of the group, we check if this is the group that we search
        {   
            $v = explode("-",$identifiers[$i])[1];
            generalCarouselOneGroup($v , $images, $dirname, $identifiers, $runs);
        }
    }
}


/*! \brief showImagesVertical($dirname, $images, $identifiers, $whichGroup, $runs)
 *
 *  shows the images in vertical (the second under the first, the third under the second
 *  ecc). The dimension of the image can be decided using the apposite dropdown menu
 */
function showImagesVertical($dirname, $images, $identifiers, $whichGroup, $runs)
{
    $sRuns = "";//runs as a string, because we must pass a string as parameter to javascript
    for ($i = 0; $i < (count($runs)-1); $i++) // -1 because the last run is empty...
    { 
        $sRuns = $sRuns . $runs[$i] . ";";
    }
    //echo "string runs: " . $sRuns;
    for ($i = 0; $i < count($identifiers); $i++)//for each identifiers
    {
        //echo "<br> whichGroup: " . $whichGroup . "   ;    " . $identifiers[$i];
        //for clearness: identifiers structure=    "NameInTheImage-NameOfTheGroup"
        if($whichGroup==explode("-",$identifiers[$i])[1] )//on the right side of the identifiers the
        //name of the group, we check if this is the group that we search
        {
            //echo "<br> in";
            $foundImages = 0;
            foreach($images as $curimg){//exactly like a normal for..
                $imageRun = end(explode('/',$curimg)); //the last part because this is a complete path
                //echo $imageRun . "<br>";
                $imageRun = explode('_',$imageRun)[0];//the first part of the name is the run of the image
                //echo $imageRun . '<br>';

                //if the name of the image contains the left part of our identifier and the run is one of the
                //runs that we saerch
                if(strpos($curimg,  explode("-",$identifiers[$i])[0]) !== false && in_array($imageRun, $runs))  
                {
                    $foundImages++;
                    $pieces = explode("/", $curimg); // i take only the last part of the pathname
                    $imageName=$pieces[count($pieces)-1];
                    //echo "imageName: " . $imageName . "<br>"; 
                    $path = "../gAn-web/testReadImage.php?image=".$imageName;
                    // create the structure of the image. Precisation: this image doesn't link to the HD but
                    // to a php page that read from hd (why? because of configuratio of this server doesn't
                    // allow to read directly from outside hdocs). ALTERNATIVE SOLUTION: use a symbolic link
                    // (it is the same..)

                    //why the image is shown before with an href around, hidden, and after nolmally?
                    // because the firse, the hidden, is just for let the image to be downlodable by click
                    // why show it two times? because in the second the click i used to open the root-like
                    // images page
                    echo '<a name = "toSaveImage" hidden href="'.$path.'" download>';
                    echo '<img name = "n' . $imageRun .'" onclick = imageClicked("'.$path.'","' . $sRuns .'") src="'.$path.'"/ class="col-xs-12">';
                    echo '</a>';

                    echo '<img name = "n' . $imageRun .'" onclick = imageClicked("'.$path.'","' . $sRuns .'") src="'.$path.'"/ class="col-xs-12">';
                    
                };
            }
            if($foundImages==0)//if no images with this group and this run..
            {
                echo '<br><br><br><h4> No found images with this group for the selected runs </h4>';
            }
        }
    }
}

/*! \brief showOutputImages($whichGroup, $layout, $path, $runs)
 *
 *  this function show all the images in the folder, if they belong to the 
 *  group $whichGroup (otherwise the function doesn't show nothing)
 */
function showOutputImages($whichGroup, $layout, $path, $runs)
{
    //echo "at the beginning the run vector is: ";
    //print_r($runs);
    //echo 'path:  '.$path.'<br>';
    $dirname = $path;
    //echo "dirname: " . $dirname . "<br>";
    $images = glob($dirname . "*.*"); //glob returns the name of all the objects that 
    //match the inserted pattern (all point all '*.*' so all the files..) in the inserted folder
    //echo "example of dimension " . count($images) . "<br>";;

    // IDENTIFIERS: FIND A BETTER SOLUTION
    // identifiers: biggest problem in this program. There is not (at now) a programmatically way to link
    // the name of the grout to the name of the imagesfile. Sometimes the name is the sime (ex pmt-pmt)
    // some othe times no (es hsc-scint) so the only way to work is using this little identifiers, that are 
    // strings in a vector with 2 values divided by a '-', on the left there is the name with we search 
    // the image, on the right the name of the group 
    $identifiers = array();
    array_push($identifiers, "mim-mimito");
    array_push($identifiers, "hSC-scint");
    array_push($identifiers, "c_hdetccd-hdetccd");
    array_push($identifiers, "pmt-pmt");
    array_push($identifiers, "fc-farcup");

    if($layout==0)//if carousel generate carousel structure (is carousel usefull? maybe, yet not dicided)
    {
        showImagesCarousel($dirname, $images, $identifiers, $whichGroup, $runs);
    }
    if($layout==1)//if vertical generate vertical structure
    {
        showImagesVertical($dirname, $images, $identifiers, $whichGroup, $runs);
    }
    

}
?>
