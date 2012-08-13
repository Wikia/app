var CreateWikiaQuizArticle = {

	init: function() {
        var node = $("#CreateWikiaQuizArticle");
        node
            .on('mousedown', '.drag', function(event) {
                event.preventDefault();
            })
            .on('click', '.trash', CreateWikiaQuizArticle.remove)
            .on('click', '.add-new a', CreateWikiaQuizArticle.addNew)
            .on('click', '.create', CreateWikiaQuizArticle.onSave)
            .find("ul").sortable({
				axis: "y",
				handle: ".drag",
				opacity: 0.8,
				stop: CreateWikiaQuizArticle.renumber
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
		$("#CreateWikiaQuizArticle .new-item").clone().removeClass("new-item").appendTo("#CreateWikiaQuizArticle ul");
		CreateWikiaQuizArticle.renumber();
	},

	remove: function() {
		$(this).closest("li").slideUp("fast", function() {
			$(this).remove();
			CreateWikiaQuizArticle.renumber();
		});
	},

	renumber: function() {
		$("#CreateWikiaQuizArticle li:not('.new-item') label.order").each(function(i) {
			$(this).text("#" + (i + 1));
		});
		$("#CreateWikiaQuizArticle input.correct").each(function(i) {
			$(this).val(i);
		});
	},

	editExisting: function(placeholder) {
		var quizElementData = $(placeholder).getData(),
			index;

		// add hidden form element for quizElementId
		$("#CreateWikiaQuizArticle").find("form").append('<input type="hidden" name="quizElementId" value="' + quizElementData.quizElementId + '">');

		// store data in main dom element for use when saving
		$("#CreateWikiaQuizArticle").data(quizElementData);

		// populate question field
		$("#CreateWikiaQuizArticle").find("input[name='question']").val(quizElementData.question);

		// remove 3 empty answer fields from the default template
		$("#CreateWikiaQuizArticle li:not('.new-item')").remove();

		// generate answer list elements
		for (index in quizElementData.answers) {
			var li = $("#CreateWikiaQuizArticle .new-item").clone().removeClass("new-item").appendTo("#CreateWikiaQuizArticle ul");
			li.find("input").val(quizElementData.answers[index]);
		}

		// properly number the answers
		CreateWikiaQuizArticle.renumber();

	},

	onSave: function(event) {
		event.preventDefault();

		if ($("#CreateWikiaQuizArticle").data('quizelementid')) {
			// editing existing quizElement
			$.get(wgScript + '?action=ajax&rs=WikiaQuizAjax&method=updateQuizArticle', $("#CreateWikiaQuizArticle").find("form").serialize(), function(data) {
				if ($("#CreateWikiaQuizArticle").closest(".modalWrapper").exists()) { // in modal
					if (data.success) {
						$("#CreateWikiaQuizArticle").closest(".modalWrapper").closeModal();
					}
				} else { // Special:Quiz
					if (data.success) {
						document.location = data.url;
					} else if (data.error) {
						$("#CreateWikiaQuizArticle").find(".errorbox").remove().end().prepend(data.error);
					}
				}
			});
		} else {
			// saving new quizElement
			$.get(wgScript + '?action=ajax&rs=WikiaQuizAjax&method=createQuizArticle', $("#CreateWikiaQuizArticle").find("form").serialize(), function(data) {
				if ($("#CreateWikiaQuizArticle").closest(".modalWrapper").exists()) { // in modal
					if (data.success) {
						RTE.mediaEditor._add("[[" + data.question + "]]");
						$("#CreateWikiaQuizArticle").closest(".modalWrapper").closeModal();
					} else if (data.error) {
						$("#CreateWikiaQuizArticle").find(".errorbox").remove().end().prepend(data.error);
					}
				} else { // Special:Quiz
					if (data.success) {
						document.location = data.url;
					} else if (data.error) {
						$("#CreateWikiaQuizArticle").find(".errorbox").remove().end().prepend(data.error);
					}
				}
			});
		}
	}
};

$(function() {
	if (wgAction != "edit" && wgAction != "submit"){
		// only init on special page
		CreateWikiaQuizArticle.init();
	}
});
