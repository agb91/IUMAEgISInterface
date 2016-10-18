<?php
/*! \brief TEST SCRIPT FOR FIND ALL THE EXISTING GRUOP OF IMAGES. NOT USED
 *
 *  IS THIS SCRIPT WORKING? YES
 *  IS THE PROGRAM USING THIS SCRIPT? NO
 *  WHY IT EXISTS? BECAUSE IT CONTAINS AN INTERESTING ALTERNATIVE SOLUTION TO FIND WHICH ARE 
 *  THE GROUPS OF OUTPUT IMAGES
 *  WHAT DOES THIS SCRIPT DO?
 *  This page aims to search images in the output folder (the path of this folder
 *  is a paramether) and take the names of these images. The group-name part of each
 *  name (group-name part means that in each name part of the name is obtained by
 *  the group) is the name of the group (example: mimito, hdetccd ecc) in this way this
 *  script can create a vector with the names of all the existing groups. This
 *  vector can be used to populate the dropdown menus dinamically. If in the feature
 *  the groups will change the program can in this way regulate himself automatically 
 */
 


//


print_r(getDinamicallyGroup("/opt/lampp/htdocs/test-interChangeble/gAn-web/output2"));//!< the echo (print_r is the 'echo' for vectors) is just to test if the script work

function getDinamicallyGroup($path)
{
    $namesRow = scandir ($path);
    $names = array();
    //print_r($names);
    for ($i = 0; $i < count($namesRow); $i++) {
        //!<for each name I toggle the extension, and maybe other parts (work in progress)
        if(strlen($namesRow[$i])>3)
        {
            $thisName = explode(".", $namesRow[$i])[0];
            array_push($names, $thisName);
        }
    }
    return $names; 
}
