function changeBranch(n)
{
	var branch = $("#branch"+n).html();
	//alert(branch);
	$("#branch").text(branch);
}

function registerBranch()
{
	var newBranch = $("#branch").html()
	//alert (newBranch);
	//alert("alive: I read: " + $("#newRoot").val())
	var toHref = "PHP/editgAnBranchFunctions.php/?newBranch="+newBranch;
	window.location.href = toHref;
}