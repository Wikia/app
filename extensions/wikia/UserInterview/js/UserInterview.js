var UserInterview = {
	init: function() {
		UserInterview.attachListeners();
	},

	attachListeners: function() {
		$('.addInterviewQuestion').click(function() {
			UserInterview.addQuestion(this);
		});
		
		
		$('.user-interview-container .remove').live('click', function() {
			UserInterview.removeColumn(this);
		});		
		
		$('#user-interview-form').submit(function() {
			UserInterview.saveQuestionValues();
			return false;
		});
	},
	
	removeColumn: function(obj) {
		var colunn = $(obj).parent().parent();
		$(colunn).hide('fast', function() {
			$(colunn).remove();
		});
	},
	
	addQuestion: function() {
		var newDate = new Date();
		var uniqueID = newDate.getTime();
		$('.user-interview-container tr:first-child input').attr('name', uniqueID);
		$('.user-interview-container tr:first-child').clone().insertBefore('.submit-column');
		$('.user-interview-container td:last-child input[type=text]').focus();	
	},
	
	saveQuestionValues: function() {
		var values = $('.user-interview-container td input').not('.user-interview-container .submit-column td input').not('.user-interview-container td:first-child');
		
		var ids = new Array();
		jQuery.each(values, function() {
			var val = $(this).attr('name');
			if (val != '' && jQuery.inArray(val, ids) == -1) {
				ids.push(val);
			}
		});

		$('#user-interview-questions').val(ids.join(","));
		
		UserInterview.saveForm();
	},
	
	saveForm: function() {
		var data = $('#user-interview-form').serialize();

		$.post(wgScript, {
			action: 'ajax',
			rs: 'UserInterviewAjax',
			method: 'submitAdminForm',
			outputType: 'data',
			data: data
		 },
		 function(res) {
			if (res.status == 'saved') {
				window.location.reload();
			}
			if (res.error) {
				alert(res.error);
			}
		});
	}
};

$(function() {
    UserInterview.init();
});