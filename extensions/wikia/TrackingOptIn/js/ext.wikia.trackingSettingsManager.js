/*global require*/
require(['wikia.trackingOptIn', 'mw'], function (trackingOptIn, mw) {
	'use strict';

	function createTrackingSettingsButton() {
		var trackingSettingsButton = document.createElement('button');

		trackingSettingsButton.classList.add('privacy-settings-button', 'wds-button');

		trackingSettingsButton.textContent = mw.message('privacy-settings-button-toggle').text();
		trackingSettingsButton.addEventListener('click', function () {
			trackingOptIn.reset();
		});

		var articleContent = document.getElementById('mw-content-text');
		articleContent.appendChild(trackingSettingsButton);

		var fandomResetCookieForm = document.createElement('form');
		fandomResetCookieForm.setAttribute('method', 'post');
		fandomResetCookieForm.setAttribute('action','https://migration.fandom.com/wiki/Special:ResetTrackingPreferences');

		var trackingSettingsButtonFandom = document.createElement('input');
		trackingSettingsButtonFandom.setAttribute('type', 'submit');
		trackingSettingsButtonFandom.classList.add('privacy-settings-button', 'wds-button');
		trackingSettingsButtonFandom.value = mw.message('privacy-settings-button-toggle-fandom').text();

		fandomResetCookieForm.appendChild(trackingSettingsButtonFandom);
		articleContent.appendChild(fandomResetCookieForm);
	}

	if (document.readyState !== 'loading') {
		createTrackingSettingsButton();
	} else {
		document.addEventListener('DOMContentLoaded', createTrackingSettingsButton);
	}
});
