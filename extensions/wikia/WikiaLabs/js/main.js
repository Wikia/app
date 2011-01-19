$(function() {
	$('#addProject').click(function(){
		$.ajax({
			url: wgScript + '?action=ajax&rs=WikiaLabs::getProjectModal',
			dataType: "html",
			method: "post", //post to prevent cache
			success: function(data) {
				$(data).makeModal({ width : 650}).showModal();
			}
		});
	});
});