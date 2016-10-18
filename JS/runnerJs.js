$(function () {
   $("#navBlock").draggable({
       cancel: false
   });

});


//hide all, except the rus that the user selected (more order)    
 function navClick(n)
 {
 	//hide all the divs that contains the semi-word disappearing
 	$('div[name*=disappearing]').each(function () {
		$(this).hide();
	});
 	var id = "#run"+n; 
 	$("#rootFileRun").text(n);
 	//alert("you clicked: " + id);
 	$(id).show();//show what the user asked for
 }

 function rootDownload()
 {
 	var run = "run_" + $("#rootFileRun").text().trim() + "_gAnOut.root";
 	//alert(run);
 	toHref = 'downloadRootFile.php/?file='  + run;
    window.location.href = toHref;
 }





