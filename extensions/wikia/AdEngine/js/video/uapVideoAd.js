/* global define */
define('ext.wikia.adEngine.video.uapVideoAd', [
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.document'
], function (DOMElementTweaker, doc) {
	'use strict';

	function toggle(showAd) {
		if (showAd) {
			DOMElementTweaker.hide(this.video, false);
			DOMElementTweaker.removeClass(this.image, 'hidden');
		} else {
			DOMElementTweaker.hide(this.image, false);
			DOMElementTweaker.removeClass(this.video, 'hidden');
		}
	}

	function registerImageContainer(imageContainer) {
		this.image = imageContainer;
	}

	return function (container, url) {
		var videoElement = doc.createElement('video');

		videoElement.src = url;
		DOMElementTweaker.hide(videoElement, false);
		container.appendChild(videoElement);

		videoElement.addEventListener('ended', function() {
			if (this.image) {
				this.toggle(true);
			}
		});

		return {
			image: null,
			registerImageContainer: registerImageContainer,
			toggle: toggle,
			video: videoElement
		};
	};
});
