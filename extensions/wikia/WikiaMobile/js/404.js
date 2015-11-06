$(function () {
	var link = document.getElementById('wk404'),
		track = require('track');

	if (link) {
		link.addEventListener('click', function (ev) {
			track.event('error-page', track.CLICK, {
					label: 'random-image',
					href: this.href
				},
				ev);
		});
	}
});
