function disp_err(errMess){
	
	
	var errDiv=document.getElementById("error");

	errMess = "<span style='color:red'>" + errMess + "</span>";

	errDiv.style.display="block";
}
