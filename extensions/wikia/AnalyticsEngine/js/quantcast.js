require(['wikia.window', 'mw', 'wikia.trackingOptOut'], function (context, mw, trackingOptOut) {

	if (trackingOptOut.isOptedOut()) {
		return;
	}

	var config = mw.config.get('wgQuantcastConfiguration'), quantcastLabels = '';

	if (context.wgWikiVertical) {
		quantcastLabels += wgWikiVertical;
		if (window.wgDartCustomKeyValues) {
			var keyValues = wgDartCustomKeyValues.split(';');
			for (var i = 0; i < keyValues.length; i++) {
				var keyValue = keyValues[i].split('=');
				if (keyValue.length >= 2) {
					quantcastLabels += ',' + wgWikiVertical + '.' + keyValue[1];
				}
			}
		}
	}

	context._qevents = context._qevents || [];
	context._qevents.push( { qacct: config.account, labels: quantcastLabels } );

	var tag = document.createElement('script');
	tag.src = config.url;

	document.head.appendChild(tag);
});
