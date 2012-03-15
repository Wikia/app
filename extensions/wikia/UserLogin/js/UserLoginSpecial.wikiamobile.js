$(function(){
	var msgBox = document.getElementById('wkLgnMsg'),
		msg = msgBox && msgBox.innerText;

	if(msg){
		//TODO: use toast notification when it will be completed
		alert(msgBox.innerText);
	}
});