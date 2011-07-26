var InterviewSpecialPage = {
		ajaxEntryPoint: '/wikia.php?controller=InterviewSpecialPage&format=json',

		init: function() {
			// Bind "submit" to button
			$('#UPPSubmitQuestion button').click(function() {
				InterviewSpecialPage.addOrModifyQuestion($('#UPPQuestionBody').val(), 0);
			});
			InterviewSpecialPage.bindEditAndDeleteButtons();
		},

		addOrModifyQuestion: function( questionBody, questionId ) {
			$.getJSON( InterviewSpecialPage.ajaxEntryPoint, { method: 'addOrModifyQuestion', questionBody: questionBody, questionId: questionId }, function(data) {
				InterviewSpecialPage.renderQuestionList(data);
			}).error(function(data) {
				var response = JSON.parse(data.responseText);
				$.showModal('Error', response.exception.message);
			});
		},

		removeQuestion: function( questionId ) {
			$.getJSON( InterviewSpecialPage.ajaxEntryPoint, { method: 'removeQuestion', questionId: questionId }, function(data) {
				InterviewSpecialPage.renderQuestionList(data);
			});
		},

		renderQuestionList: function( data ) {
			$('#UPPQuestionList').html(data.questionList);
			if(data.isAddingAllowed) {
				$('#UPPQuestionBody').val('');
			}
			else {
				$('#UPPAddQuestionBox').html('<span>'+data.noMoreQuestionsAllowedMsg+'</span>');
			}
			// re-attach edit buttons
			InterviewSpecialPage.bindEditAndDeleteButtons();
		},

		bindEditAndDeleteButtons: function() {
			$('.question-edit-button').click(function() { 
				var questionId = $(this).attr('data-question-id');
				var questionBody = $('#UPPQuestionBodyContainer-'+questionId).text();
				var questionTextarea = '<textarea id="UPPQuestionBody-'+questionId+'">'+questionBody+'</textarea>';
				var questionSaveButton = '<button class="question-save-button" id="UPPQuestionSaveButton-'+questionId+'" data-question-id="'+questionId+'">save</button>';

				$('#UPPQuestionBodyContainer-'+questionId).html(questionTextarea+questionSaveButton);
				InterviewSpecialPage.bindSaveButtons();
			});
			$('.question-delete-button').click(function() { 
				var questionId = $(this).attr('data-question-id');
				InterviewSpecialPage.removeQuestion(questionId);
			});
		},

		bindSaveButtons: function() {
			$('.question-save-button').click(function() {
				var questionId = $(this).attr('data-question-id');
				InterviewSpecialPage.addOrModifyQuestion($('#UPPQuestionBody-'+questionId).val(), questionId);
			});
		}

	};

$(function() {
	InterviewSpecialPage.init();
});