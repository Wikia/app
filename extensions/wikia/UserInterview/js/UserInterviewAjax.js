$(function() {
	UserInterviewHeader.init();
});


var UserInterviewHeader = {
	init: function() {
		UserInterviewHeader.attachEventListeners();
		UserInterviewHeader.addTrackclicking();
	},
	
	attachEventListeners: function() {
		$('a.toggle-user-interview').click(function() {
			 $("#user-interview-form").slideToggle(400, function () {
             });
			return false;
		});
		
		$('#user-interview-form').submit(function() {
			var data = $('#user-interview-form').serialize();

			$.post(wgScript, {
				action: 'ajax',
				rs: 'UserInterviewAjax',
				method: 'submitUserForm',
				outputType: 'data',
				data: data
			 },
			 function(res) {
				if (res.status == 'saved') {
					$("#user-interview-form").slideToggle(200, function () {
						window.location.reload();
					});
				
				}
				if (res.error) {
					alert(res.error);
				}
			});
	
			return false;
		});
	},
	
	addTrackclicking: function() {
		$('.toggle-user-interview').trackClick('userinterview/togglebutton');
		$('#UserInterviewSave').trackClick('userinterview/saveinterviewbutton');
	},
}
