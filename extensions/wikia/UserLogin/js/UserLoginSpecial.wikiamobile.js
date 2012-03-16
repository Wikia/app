$(function(){
	var msgBox = document.getElementById('wkLgnMsg'),
		msg = msgBox && msgBox.innerText;

	if(msg){
		WikiaMobile.toast.show(msg);
	}
});