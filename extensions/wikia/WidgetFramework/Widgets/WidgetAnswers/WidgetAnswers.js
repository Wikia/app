function WidgetAnswers_init(id) {
	jQuery.getScript(WidgetAnswers_url);
}

function WidgetAnswers_load(data) {
	if(data.query.wkpagesincat) {
		html = '';
		for(var recent_q in data.query.wkpagesincat ) {
			var page = data.query.wkpagesincat[recent_q];
			var text = page.title.replace(/_/g," ") + "?";
			if(text.length > 100) {
				text = text.substring(0,100) + "...";
			}
			html += "<li><a href=\"" + page.url + "\" target=\"_blank\">" + text + "</a></li>";
		}
		jQuery("#recent_unanswered_questions").prepend(html);
	}
}

var widget_answers_placeholder = 'Ask a question';
function answers_widget_handler(e) {
	if (e.type == 'focus') {
		if (YAHOO.util.Event.getTarget(e).value == widget_answers_placeholder) {
			YAHOO.util.Dom.removeClass('answers_ask_field', 'alt');
			$G('answers_ask_field').value = '';
		}
	} else if (e.type == 'blur') {
		if (YAHOO.util.Event.getTarget(e).value == '') {
			YAHOO.util.Dom.addClass('answers_ask_field', 'alt');
			$G('answers_ask_field').value = widget_answers_placeholder;
		}
	} else if (e.type == 'keypress') {
		var keycode = e.which || window.event.keyCode;
		if (keycode == 13 && $G('answers_ask_field').value != '' ) {
			var widget_answers_question = $G('answers_ask_field').value;
			window.open('http://answers.wikia.com/index.php?title=Special:CreateQuestionPage&questiontitle=' + widget_answers_question + '&categories=' + wgSitename, 'wikianswers');
			YAHOO.util.Dom.addClass('answers_ask_field', 'alt');
			$G('answers_ask_field').value = widget_answers_placeholder;
		}
	}
}
YAHOO.util.Event.addListener('answers_ask_field', "focus", answers_widget_handler);
YAHOO.util.Event.addListener('answers_ask_field', "blur", answers_widget_handler);
YAHOO.util.Event.addListener('answers_ask_field', "keypress", answers_widget_handler);