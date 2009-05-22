function WidgetAnswers_load(data) {
	if(data.query.wkpagesincat) {
		for(var recent_q in data.query.wkpagesincat ) {
			var page = data.query.wkpagesincat[recent_q];
			var text = page.title.replace(/_/g," ") + "?";
			if(text.length > 100) {
				text = text.substring(0,100) + "...";
			}
			WidgetAnswers_html += "<li><a href=\"" + page.url + "\" target=\"_blank\">" + text + "</a></li>";
		}
	}
}
var widget_answers_placeholder = 'Ask a question';
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
			window.open('http://answers.wikia.com/index.php?title=Special:CreateQuestionPage&questiontitle=' + encodeURIComponent(e.target.value) + '&categories=' + wgSitename, 'wikianswers');
			e.target.value = widget_answers_placeholder;
			e.target.style.color = '#999';
		}
	}
}
function WidgetAnswers_init(id) {
	jQuery('#widget_' + id+'_content').css('max-height', '400px').children('form').children('input').val(widget_answers_placeholder).focus(WidgetAnswers_handler).blur(WidgetAnswers_handler).keypress(WidgetAnswers_handler);
}
