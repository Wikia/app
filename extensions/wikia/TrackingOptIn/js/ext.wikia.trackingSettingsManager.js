/*global require*/
require(['wikia.cmp', 'wikia.trackingOptInModal', 'mw'], function (cmp, trackingOptInModal, mw) {
	'use strict';

	function createTrackingSettingsButton() {
		var trackingSettingsButton = document.createElement('button');

		trackingSettingsButton.id = 'privacy-settings-button';
		trackingSettingsButton.classList.add('wds-button');

		trackingSettingsButton.textContent = mw.message('privacy-settings-button-toggle').text();
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
