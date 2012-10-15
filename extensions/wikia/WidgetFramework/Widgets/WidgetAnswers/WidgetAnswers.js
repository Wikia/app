function WidgetAnswers_load(data) {
	if (data.query == "undefined") { return; }
	if(data.query.categoriesonanswers) {
		for(var recent_q in data.query.categoriesonanswers ) {
			var page = data.query.categoriesonanswers[recent_q];
			var url  = page.title.replace(/_/g," ");
			var text = page.title.replace(/_/g," ") + "?";
			if(text.length > 100) {
				text = text.substring(0,100) + "...";
			}
			WidgetAnswers_html += "<li><a href=\"http://" + WidgetAnswers_domain + '/index.php?title=' + encodeURIComponent(url) + "\" target=\"_blank\">" + text + "</a></li>";
		}
	}
}
function WidgetAnswers_load2(data) {
	if (data.query == "undefined") return;
	if(data.query.categorymembers) {
		for(var recent_q in data.query.categorymembers ) {
			var page = data.query.categorymembers[recent_q];
			var url  = page.title.replace(/_/g," ");
			var text = page.title.replace(/_/g," ") + "?";
			if(text.length > 100) {
				text = text.substring(0,100) + "...";
			}
			WidgetAnswers_html += "<li><a href=\"http://" + WidgetAnswers_domain + '/index.php?title=' + encodeURIComponent(url) + "\" target=\"_blank\">" + text + "</a></li>";
		}
	}
}
var widget_answers_placeholder = '';
function WidgetAnswers_handler(e) {
	if(e.type == 'focus') {
		if(e.target.value == widget_answers_placeholder) {
			e.target.value = '';
			e.target.style.color = '#000';
		}
	} else if (e.type == 'blur') {
		if(e.target.value == '') {
			e.target.value = widget_answers_placeholder;
			e.target.style.color = '#999';
		}
	} else if (e.type == 'keypress') {
		var keycode = e.which || window.event.keyCode;
		if(keycode == 13 && e.target.value != '' ) {
			window.open('http://' + WidgetAnswers_domain + '/index.php?title=Special:CreateQuestionPage&questiontitle=' + encodeURIComponent(e.target.value) + '&categories=' + encodeURIComponent(WidgetAnswers_category), 'wikianswers');
			e.target.value = widget_answers_placeholder;
			e.target.style.color = '#999';
		}
	}
}

function WidgetAnswers_init(id) {
	widget_answers_placeholder = ask_a_question_msg;
	jQuery('#widget_' + id+'_content').css('max-height', '400px').children('form').children('input').val(widget_answers_placeholder).focus(WidgetAnswers_handler).blur(WidgetAnswers_handler).keypress(WidgetAnswers_handler);
}
