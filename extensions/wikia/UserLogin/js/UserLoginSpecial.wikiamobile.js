$(function(){
	var msgBox = document.getElementById('wkLgnMsg'),
		msg = msgBox && msgBox.innerText;

	if(msg){
		require('toast', function(t){
			t.show(msg);
		});
	}
});