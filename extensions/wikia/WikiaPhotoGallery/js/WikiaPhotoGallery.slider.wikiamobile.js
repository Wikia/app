$(function () {
	var sliders = document.getElementsByClassName('wkSlider'),
		i = sliders.length,
		track = require('track'),
		click = function (ev) {
			if (ev.target.tagName === 'IMG') {
				track.event('slider', track.CLICK);
			}
		};

	if (i) {
		while (i--) {
			sliders[i].addEventListener('tap', click, true);
		}
	}
});
