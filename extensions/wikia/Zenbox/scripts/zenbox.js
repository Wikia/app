$(function(){
	'use strict';
	// async load of Zendesk

	var c = document.createElement('link'),
		h = document.getElementsByTagName('head')[0];
	c.rel = 'stylesheet';
	c.type = 'text/css';
	c.href = '//asset.zendesk.com/external/zenbox/v2.6/zenbox.css';
	h.appendChild(c);

	$.ajax({
		url: '//asset.zendesk.com/external/zenbox/v2.6/zenbox.js',
		dataType: 'script',
		cache: true,
		success: function() {
			Zenbox.init({
				dropboxID: '20200050',
				url: 'https://wikia.zendesk.com',
				tabTooltip:  'Feedback',
				tabImageURL: '//p2.zdassets.com/external/zenbox/images/tab_feedback_right.png',
				tabColor: 'black',
				tabPosition: 'Right'
			});
		}
	});
});
