/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function changeVerbose(n)
{
    readValues[0] = n;
    $("#labelVerbose").text("Verbose now: "+n);
    $("#VerboseButton").text("Verbose " +n); 
    $("#configConfirmationButton").toggleClass("btn-primary",false);
    $("#configConfirmationButton").addClass("green");
} 

function changer(position, newValue)
{
    group = readGroupValues[position];
    readValues[position] = newValue;
    if(newValue==1)
    {
        $("#label"+group).text(group + " now: "+"Yes");
        $("#" + group + "Button").text(group + " " +"Yes"); 
    }
    else
    {
        $("#label"+group).text(group + " now: "+"No");
        $("#" + group + "Button").text(group + " " +"No"); 
    }
    $("#configConfirmationButton").toggleClass("btn-primary",false);
    $("#configConfirmationButton").addClass("green");
}

//send to the apposite php file the chosen parameters, using GET (if I use
// post it is the same...)
function writeToFile(file)
{
    var toPrintValues = [];
    for (i = 0; i < readGroupValues.length; i++)
    {
        if(readValues[i]==1)
        {
            toPrintValues.push("yes");
        }
        else
        {
            toPrintValues.push("no");
        }
    }

    var toAlert = "";
    toAlert = "you 've inserted: \n " + readGroupValues[0] + ": " + readValues[0] + " \n ";
    for (i = 1; i < readGroupValues.length; i++)
    {
        toAlert+= readGroupValues[i] + " : " + toPrintValues[i] + " \n ";
    }
    alert(toAlert);

    var toHref = "";
    toHref = 'PHP/editConfigFunction.php/?'  + readGroupValues[0] + '='+readValues[0];
    for (i = 1; i < readGroupValues.length; i++)
    {
        toHref+='&' + readGroupValues[i] + '=' + readValues[i];
    }
    toHref+="&path=" + file;

    window.location.href = toHref;
}


