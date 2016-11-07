// to deeply understant how this page works, read the short documentation about ROOTJS
// at this link: https://github.com/linev/jsroot/blob/master/docs/JSROOT.md  


function updateGUI() {
    // if getting histogram from THttpServer as JSON string, one should parse it like:
    // var histo = JSROOT.parse(your_json_string);

    // this is just generation of histogram
    var run = $("#getRun").text();//"images/run_31111_gAnOut.root";
    //console.log("read run: " + run);
    var gAn = $("#whichgAn").text();
    //alert(gAn);

    var image = $("#getImage").text();//"images/run_31111_gAnOut.root";
    //console.log("read image: " + imageGroup);

    //var filename = "/home/aegis/aegis-offline/gAn-dev/root/run_"+run+"_gAnOut.root";
    var filename = "output/gAnOut_" + run + ".root";
    //alert(filename);
    
    //console.log("filename:" + filename);
    //tipical error: filename doesn't exist. If error check this before. (maybe too many slash or no slash)
    JSROOT.OpenFile(filename, function(file) {
        //console.log(file);
        for (var i=0;i<file.fKeys.length;i++)//for all the keys in the file
        {
            var cnt = 1;//in which div the image will be positioned
            var name = file.fKeys[i].fName; 
            //use toUpperCase to have a caps insensitive confrontation 
            //console.log(name.toUpperCase() + '  vs  ' + image.toUpperCase() + ';   risp = ' + (name.toUpperCase().indexOf(image.toUpperCase())>-1)); 
            //if(name.toUpperCase().indexOf(image.toUpperCase())>-1)//if name and image are equal ignoring case
            {
                file.ReadObject(name, function(obj) {//read the object in the file
                    //console.log('object_draw'+(cnt));
                    JSROOT.redraw('object_draw'+(cnt), obj, "colz");//draw the object, in the div object_drawCNT
                    // colz means with colors
                    cnt++;
                });
            }
        }
    });    

//following the old version of the program that now is useless
  /*
    JSROOT.OpenFile(filename, function(file) {
        //console.log(file); 
        file.ReadObject("h_run_31111_mimito_122;1", function(obj) {
            JSROOT.redraw('object_draw3', obj, "colz");
        });
    }); */


/*    var histo = JSROOT.CreateTH1(20, 20);
    for (var iy=0;iy<20;iy++)
       for (var ix=0;ix<20;ix++) {
          var bin = histo.getBin(ix+1, iy+1), val = 0;
          switch (cnt % 4) {
             case 1: val = ix + 19 - iy; break;
             case 2: val = 38 - ix - iy; break;
             case 3: val = 19 - ix + iy; break;
             default: val = ix + iy; break;
          }
          //alert("val: "+val);
          //alert("bin: "+bin);
          histo.setBinContent(bin, val);
       }

    histo.fName = "generated2";
    histo.fTitle = "Drawing2 " + cnt++;

    JSROOT.redraw('object_draw2', histo, "colz");

    var npoints = 10;
    var xpts=[1,2,3,4,5,6,7,8,9,10];
    var ypts=[8,4,8,2,1,55,4,3,2,2];
    var graph = JSROOT.CreateTGraph(npoints, xpts, ypts);
    JSROOT.redraw('object_draw3', graph);

    var graph = JSROOT.CreateTList()
    JSROOT.redraw('object_draw3', graph);

    */

}



$( document ).ready(function() {// start only when the page is already charged, to avoid all problems
  updateGUI();
});



