YAHOO.util.Event.onDOMReady(function() {
	var messageDivs = YAHOO.util.Dom.getElementsByClassName('SWM_dismiss', 'span');
	for (var i=messageDivs.length-1; i>=0; i--)
	{
		var link = messageDivs[i].getElementsByTagName('span')[0].getElementsByTagName('a')[0];
		var rxId = new RegExp(/&mID=(\d+)/);
		var id = rxId.exec(link.getAttribute('href'))[1];
		if (id) {
			YAHOO.util.Event.addListener(link, 'click', SWMAjaxDismiss, id);
		}
	}
});

function SWMAjaxDismiss(e, id) {
	YAHOO.util.Event.preventDefault(e);
	var ajaxUrl = wgServer + wgScript + "?action=ajax&rs=SiteWideMessagesAjaxDismiss&rsargs=" + id;
	var request = YAHOO.util.Connect.asyncRequest('GET', ajaxUrl, {
		success: function(o) {
			if (o.responseText == '1') {
				if (messageDiv = document.getElementById('msg_' + id)) {
					messageDiv.parentNode.removeChild(messageDiv);
				}
			}
		},
		timeout: 30000
	});
}