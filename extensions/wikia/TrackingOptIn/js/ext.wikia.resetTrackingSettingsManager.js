/*global require*/
require(['wikia.cmp', 'wikia.trackingOptInModal', 'mw'], function (cmp, trackingOptInModal, mw) {
	'use strict';

	function createTrackingSettingsButton() {
		var trackingSettingsButton = document.createElement('button');

		trackingSettingsButton.classList.add('privacy-settings-button', 'wds-button');

		trackingSettingsButton.textContent = mw.message('privacy-settings-button-toggle-fandom').text();
		trackingSettingsButton.addEventListener('click', function () {
			cmp.reset();
			trackingOptInModal.init({ zIndex: 9999999 }).reset();
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
