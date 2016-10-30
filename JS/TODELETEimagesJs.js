
function updateGUI() {

    var filename = "TODELETEoutput/gAnOut_31111.root";
    
    JSROOT.OpenFile(filename, function(file) {
        for (var i=0;i<file.fKeys.length;i++)//for all the keys in the file
        {
            var cnt = 1;//in which div the image will be positioned
            var name = file.fKeys[i].fName;
            console.log( file.fKeys[0] );

            /*file.ReadObject(name, function(obj) {
            	var thisDraw = obj.fLeaves.arr[0];
                console.log(thisDraw)
                file.ReadObject(thisDraw.fName, function(obj2) {//read the object in the file
                    console.log( obj2 );
                    JSROOT.redraw('object_draw', obj2, "colz");
                });
            });*/

        }
    });    
}



$( document ).ready(function() {// start only when the page is already charged, to avoid all problems
  updateGUI();
});



