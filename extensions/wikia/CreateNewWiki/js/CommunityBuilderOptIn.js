define('ext.createNewWiki.communityBuilderOptIn', [], function() {
	'use strict';

	var currentLanguage,
		optInPrompts,
		sectionWrapper,
		optInModal,
		viewedOptInModal = false,
		PROMPT_ENABLED_WRAPPER_CLASS = 'with-optin';

	function init($sectionWrapper, $languageInput) {
		if (!window.AllowCommunityBuilderOptIn) {
			return;
		}

		sectionWrapper = $sectionWrapper;
		optInPrompts = $('.optin-prompt');

		updateLanguage($languageInput.val());

		$languageInput.on('change', onLanguageInputChange)
	}

	function onLanguageInputChange(event) {
		updateLanguage(event.currentTarget.value);
	}

	function updateLanguage(language) {
		currentLanguage = language;

		if (currentLanguage === 'en') {
			sectionWrapper.addClass(PROMPT_ENABLED_WRAPPER_CLASS);
			optInPrompts.show();
		} else {
			sectionWrapper.removeClass(PROMPT_ENABLED_WRAPPER_CLASS);
			optInPrompts.hide();
		}
	}

	return {
		init: init
	};
});
