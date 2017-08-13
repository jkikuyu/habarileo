function disp_err(errMess){
	
	
	var errDiv=document.getElementById("error");

	errMess = "<span style='color:red'>" + errMess + "</span>";

	errDiv.style.display="block";
}
function userLinkHide(){
	var anchor =document.getElementById("adduser");
	anchor.style.display='none';
}
