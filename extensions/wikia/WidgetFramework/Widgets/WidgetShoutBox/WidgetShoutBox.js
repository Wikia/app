function WidgetShoutBoxSend(widgetId) {
	var messageBox = $('#widget_' + widgetId + '_message');

	if (!messageBox.length || messageBox.attr('value') == '') {
		return false;
	}

	WidgetFramework.update(widgetId, {message: messageBox.attr('value')}, function(id, widget) {
		$('#widget_' + id + '_message').focus();
	});

	return true;
}

function WidgetShoutBoxRemoveMsg(widgetId, aElem) {
	var chatTab = $('#widget_' + widgetId + '_chat');
	var msgId = aElem.parentNode.getAttribute('msgid');

	if (!chatTab || !msgId) {
		return false;
	}

	WidgetFramework.update(widgetId, {msgid: msgId}, function(id, widget) {
		$('#widget_' + id + '_message').focus();
	});
}
