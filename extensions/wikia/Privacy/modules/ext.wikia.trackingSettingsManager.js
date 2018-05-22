require(['wikia.trackingOptInModal', 'mw'], function (trackingOptInModal, mw) {
	'use strict';

	function createPrivacySettingsButton() {
		var privacySettingsButton = document.createElement('button');

		privacySettingsButton.id = 'privacy-settings-button';
		privacySettingsButton.classList.add('wds-button');

		privacySettingsButton.addEventListener('click', function () {
			trackingOptInModal.init({ zIndex: 9999999 }).reset();
		});
		privacySettingsButton.textContent = mw.message('privacy-settings-button-toggle').text();

		var mwArticleContent = document.getElementById('mw-content-text');
		mwArticleContent.appendChild(privacySettingsButton);
	}

	if (document.readyState !== 'loading') {
		createPrivacySettingsButton();
	} else {
		document.addEventListener('DOMContentLoaded', createPrivacySettingsButton);
	}
});
