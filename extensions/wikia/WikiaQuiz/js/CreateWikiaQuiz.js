var CreateWikiaQuiz = {

	init: function() {
        var node = $("#CreateWikiaQuiz");
        node
			.on('mousedown', '.drag', function(event) {
                event.preventDefault();
            })
            .on('click', '.trash', CreateWikiaQuiz.remove)
            .on('click', '.add-new a', CreateWikiaQuiz.addNew)
            .on('click', '.create', CreateWikiaQuiz.onSave)
            .find("ul").sortable({
				axis: "y",
				handle: ".drag",
				opacity: 0.8,
				stop: CreateWikiaQuiz.renumber
			});

		if( node.closest(".modalWrapper") ) {
			// Presented in modal. Do specific modal stuff
            node.find(".cancel").click(function(event) {
				event.preventDefault();
				$(this).closest(".modalWrapper").closeModal();
			});
		}
	},

	addNew: function(event) {
		event.preventDefault();
		$("#CreateWikiaQuiz .new-item").clone().removeClass("new-item").appendTo("#CreateWikiaQuiz ul");
		CreateWikiaQuiz.renumber();
	},

	remove: function() {
		$(this).closest("li").slideUp("fast", function() {
			$(this).remove();
			CreateWikiaQuiz.renumber();
		});
	},

	renumber: function() {
		$("#CreateWikiaQuiz li:not('.new-item') label.order").each(function(i) {
			$(this).text("#" + (i + 1));
		});
		$("#CreateWikiaQuiz input.correct").each(function(i) {
			$(this).val(i);
		});
	},

	editExisting: function(placeholder) {
		var quizData = $(placeholder).getData(),
			index;

		// add hidden form element for quizId
		$("#CreateWikiaQuiz").find("form").append('<input type="hidden" name="quizId" value="' + quizData.quizId + '">');

		// store data in main dom element for use when saving
		$("#CreateWikiaQuiz").data(quizData);

		// populate question field
		$("#CreateWikiaQuiz").find("input[name='question']").val(quizData.question);

		// remove 3 empty answer fields from the default template
		$("#CreateWikiaQuiz li:not('.new-item')").remove();

		// generate answer list elements
		for (index in quizData.answers) {
			var li = $("#CreateWikiaQuiz .new-item").clone().removeClass("new-item").appendTo("#CreateWikiaQuiz ul");
			li.find("input").val(quizData.answers[index]);
		}

		// properly number the answers
		CreateWikiaQuiz.renumber();

	},

	onSave: function(event) {
		event.preventDefault();

		if ($("#CreateWikiaQuiz").data('quizid')) {
			// editing existing quiz
			$.get(wgScript + '?action=ajax&rs=WikiaQuizAjax&method=updateQuiz', $("#CreateWikiaQuiz").find("form").serialize(), function(data) {
				if ($("#CreateWikiaQuiz").closest(".modalWrapper").exists()) { // in modal
					if (data.success) {
						$("#CreateWikiaQuiz").closest(".modalWrapper").closeModal();
					}
				} else { // Special:Quiz
					if (data.success) {
						document.location = data.url;
					} else if (data.error) {
						$("#CreateWikiaQuiz").find(".errorbox").remove().end().prepend(data.error);
					}
				}
			});
		} else {
			// saving new quiz
			$.get(wgScript + '?action=ajax&rs=WikiaQuizAjax&method=createQuiz', $("#CreateWikiaQuiz").find("form").serialize(), function(data) {
				if ($("#CreateWikiaQuiz").closest(".modalWrapper").exists()) { // in modal
					if (data.success) {
						RTE.mediaEditor._add("[[" + data.question + "]]");
						$("#CreateWikiaQuiz").closest(".modalWrapper").closeModal();
					} else if (data.error) {
						$("#CreateWikiaQuiz").find(".errorbox").remove().end().prepend(data.error);
					}
				} else { // Special:Quiz
					if (data.success) {
						document.location = data.url;
					} else if (data.error) {
						$("#CreateWikiaQuiz").find(".errorbox").remove().end().prepend(data.error);
					}
				}
			});
		}
	}
};

$(function() {
	if (wgAction != "edit" && wgAction != "submit"){
		// only init on special page
		mw.loader.using('jquery.ui.sortable').done( CreateWikiaQuiz.init );
	}
});
