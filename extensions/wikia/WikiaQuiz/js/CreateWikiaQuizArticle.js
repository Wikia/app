var CreateWikiaQuizArticle = {

	init: function() {
		$("#CreateWikiaQuizArticle")
			.find("ul").sortable({
				axis: "y",
				handle: ".drag",
				opacity: .8,
				stop: CreateWikiaQuizArticle.renumber
			}).end()
			.find(".drag").live("mousedown", function(event) {
				event.preventDefault();
			}).end()
			.find(".trash").live("click", CreateWikiaQuizArticle.remove).end()
			.find(".add-new a").click(CreateWikiaQuizArticle.addNew).end()
			.find(".create").click(CreateWikiaQuizArticle.onSave);
		if ($("#CreateWikiaQuizArticle").closest(".modalWrapper")) {
			// Presented in modal. Do specific modal stuff
			$("#CreateWikiaQuizArticle").find(".cancel").click(function(event) {
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
		})
	},
	
	renumber: function() {
		$("#CreateWikiaQuizArticle li:not('.new-item') label.order").each(function(i) {
			$(this).text("#" + (i + 1));
		});
		$("#CreateWikiaQuizArticle input.correct").each(function(i) {
			$(this).val(i);
		});
	},
	
	showEditor: function(event) {
		var self = CreateWikiaQuizArticle;
	
		// load CSS for editor popup and jQuery UI library (if not loaded yet) via loader function
		$.getResources([
			$.loadJQueryUI,
			$.getSassCommonURL('/extensions/wikia/WikiaQuiz/css/WikiaQuizBuilder.scss'),
			wgExtensionsPath + '/wikia/WikiaQuiz/js/CreateWikiaQuizArticle.js?' + wgStyleVersion
		], function() {
			$.get(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=WikiaQuiz&actionName=SpecialPage&outputType=html', function(data) {
				$(data).makeModal({width: 600});
				CreateWikiaQuizArticle.init();
				
				// editing an existing quiz?
				if ($(event.target).hasClass("placeholder-quiz")) {
					CreateWikiaQuizArticle.editExisting(event.target);
				}
			});
		});
	},
	
	editExisting: function(placeholder) {
		var quizElementData = $(placeholder).getData();

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

		// track number of options in quizElement
		var optionCount = 0;
		$("#CreateWikiaQuizArticle li:not('.new-item') input[type='text']").each(function() {
			if ($(this).val().length > 0) {
				optionCount++;
			}
		});
		CreateWikiaQuizArticle.track('/optioncount/' + optionCount);

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
						CreateWikiaQuizArticle.track('/insertNewQuizElement');
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
	},

	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('quiz' + fakeUrl);
	}
};

$(function() {
	if (wgAction != "edit" && wgAction != "submit"){
		// only init on special page
		CreateWikiaQuizArticle.init();
	}
});