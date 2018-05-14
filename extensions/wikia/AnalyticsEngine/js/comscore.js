require(['wikia.window', 'mw', 'wikia.trackingOptOut'], function (context, mw, trackingOptOut) {

	if (!mw.config.has('wgComscoreConfiguration') || trackingOptOut.isOptedOut()) {
		return;
	}

	var config = mw.config.get('wgComscoreConfiguration');

	context._comscore = context._comscore || [];
	context._comscore.push({
		c1: '2',
		c2: config.partnerId,
		options: {
			url_append: 'comscorekw=' + config.c7value
		}
	});

	var comscoreTag = document.createElement('script');
	comscoreTag.src = config.url;

	document.head.appendChild(comscoreTag);
});
