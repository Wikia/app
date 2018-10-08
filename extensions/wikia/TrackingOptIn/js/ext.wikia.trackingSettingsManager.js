/*global require*/
require(['wikia.cmp', 'wikia.trackingOptInModal', 'mw'], function (cmp, trackingOptInModal, mw) {
	'use strict';

	function createTrackingSettingsButton() {
		var trackingSettingsButton = document.createElement('button');

		trackingSettingsButton.classList.add('privacy-settings-button', 'wds-button');

		trackingSettingsButton.textContent = mw.message('privacy-settings-button-toggle').text();
		trackingSettingsButton.addEventListener('click', function () {
			cmp.reset();
			trackingOptInModal.init({ zIndex: 9999999 }).reset();
		});

		var articleContent = document.getElementById('mw-content-text');
		articleContent.appendChild(trackingSettingsButton);

		var trackingSettingsButtonFandom = document.createElement('button');

		trackingSettingsButtonFandom.classList.add('privacy-settings-button', 'wds-button');

		trackingSettingsButtonFandom.textContent = mw.message('privacy-settings-button-toggle-fandom').text();
		trackingSettingsButtonFandom.addEventListener('click', function () {
			// Go to migration page
		});

		articleContent.appendChild(trackingSettingsButtonFandom);
	}

	if (document.readyState !== 'loading') {
		createTrackingSettingsButton();
	} else {
		document.addEventListener('DOMContentLoaded', createTrackingSettingsButton);
	}
});
