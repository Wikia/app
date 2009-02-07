var widget_answers_placeholder = 'Ask a question';
function answers_widget_handler(e) { 
	if (e.type == 'focus') {
		if (YAHOO.util.Event.getTarget(e).value == widget_answers_placeholder) {
			YAHOO.util.Dom.removeClass('answers_ask_field', 'alt');	
			$('answers_ask_field').value = '';
		}	
	} else if (e.type == 'blur') {
		if (YAHOO.util.Event.getTarget(e).value == '') {
			YAHOO.util.Dom.addClass('answers_ask_field', 'alt');
			$('answers_ask_field').value = widget_answers_placeholder;
		}
	} else if (e.type == 'keypress') {
		var keycode = e.which || window.event.keyCode;
		if (keycode == 13 && $('answers_ask_field').value != '' ) {
			var widget_answers_question = $('answers_ask_field').value;
			window.open('http://answers.wikia.com/index.php?title=Special:CreateQuestionPage&questiontitle=' + widget_answers_question + '&categories=' + wgSitename, 'wikianswers');
			YAHOO.util.Dom.addClass('answers_ask_field', 'alt');
			$('answers_ask_field').value = widget_answers_placeholder;
		}
	}
} 
YAHOO.util.Event.addListener('answers_ask_field', "focus", answers_widget_handler); 
YAHOO.util.Event.addListener('answers_ask_field', "blur", answers_widget_handler);
YAHOO.util.Event.addListener('answers_ask_field', "keypress", answers_widget_handler);
