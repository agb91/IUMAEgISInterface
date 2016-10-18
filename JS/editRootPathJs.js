function writeNewRoot()
{
	var newRoot = $("#newRoot").val()
	//alert("alive: I read: " + $("#newRoot").val())
	var toHref = "PHP/editRootPathFunctions.php/?newRoot="+newRoot;
	window.location.href = toHref;
}

function changeRoot(n)
{
	var thisRoot = $("#roots"+n).html();
	//console.log(thisRoot);
	//alert(thisRoot);
	var rootPath = cleanRootPath($("#allRoot").html());
	//alert(rootPath);
	$("#newRoot").val(thisRoot);
}

function cleanRootPath(rp)
{
	return rp;
}