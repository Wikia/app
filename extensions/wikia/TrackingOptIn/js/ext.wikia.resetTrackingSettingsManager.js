/*global require*/
require(['wikia.trackingOptIn', 'mw'], function (trackingOptIn, mw) {
	'use strict';

	function createTrackingSettingsButton() {
		var trackingSettingsButton = document.createElement('button');

		trackingSettingsButton.classList.add('privacy-settings-button', 'wds-button');

		if (mw.config.get('wgCookieDomain') === '.' + mw.config.get('wgWikiaBaseDomain')) {
			trackingSettingsButton.textContent = mw.message('privacy-settings-button-toggle').text();
		} else {
			trackingSettingsButton.textContent = mw.message('privacy-settings-button-toggle-fandom').text();
		}
		trackingSettingsButton.addEventListener('click', function () {
			trackingOptIn.reset();
		});

		var articleContent = document.getElementById('mw-content-text');
		articleContent.appendChild(trackingSettingsButton);
	}

	if (document.readyState !== 'loading') {
		createTrackingSettingsButton();
	} else {
		document.addEventListener('DOMContentLoaded', createTrackingSettingsButton);
	}
});
