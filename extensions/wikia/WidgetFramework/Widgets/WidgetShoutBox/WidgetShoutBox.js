function WidgetShoutBoxSend(widgetId) {

	var messageBox = $('#widget_' + widgetId + '_message');

	if (!messageBox.length || messageBox.attr('value') == '') {
		return false;
	}

	// get message
	var message = encodeURIComponent( messageBox.attr('value') );

	$('#widget_' + widgetId + '_content').html('').addClass('widget_loading').log('msg: ' + message, 'WidgetShoutBox');

	$.getJSON(wgScript + '?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&message='+message, function(res) {
		if(res.success) {
			$('#widget_' + res.id +'_content').removeClass('widget_loading').html(res.body);
			if(res.title) {
				$('#widget_' + res.id +'_header').html(res.title);
			}

			// focus on message input
			$('#widget_' + res.id + '_message').focus();
		}
	});

	return true;
}

function WidgetShoutBoxRemoveMsg(widgetId, msgId) {
	var chatTab = $('#widget_' + widgetId + '_chat');

	if (!chatTab || !msgId) {
		return false;
	}

	$('#widget_' + widgetId + '_content').html('').addClass('widget_loading').log('removing msg #' + msgId, 'WidgetShoutBox');

	$.getJSON(wgScript + '?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&msgid='+msgId, function(res) {
		if(res.success) {
			$('#widget_' + res.id +'_content').removeClass('widget_loading').html(res.body);
			if(res.title) {
				$('#widget_' + res.id +'_header').html(res.title);
			}

			// focus on message input
			$('#widget_' + res.id + '_message').focus();
		}
	});
}
