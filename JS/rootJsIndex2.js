var cnt = 0;

function updateGUI() {
   // if getting histogram from THttpServer as JSON string, one should parse it like:
   // var histo = JSROOT.parse(your_json_string);

   // this is just generation of histogram

   var histo = JSROOT.CreateTH1(20, 20);
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
}

function startGUI() {
   updateGUI();
   setInterval(updateGUI, 3000); 
}



   