define('ext.createNewWiki.communityBuilderOptIn', [], function() {
	'use strict';

	var currentLanguage,
		optInPrompts,
		sectionWrapper,
		optInModal,
		viewedOptInModal = false,
		PROMPT_ENABLED_WRAPPER_CLASS = 'with-optin',
		ENABLED_ON_LANGUAGES = ['en'],
		SHOW_MODAL_ON_HUBS = ['1'],
		SHOW_MODAL_ON_CATEGORIES = ['anime', 'tv'];

	function init($sectionWrapper, $languageInput, $hubInput) {
		if (!window.AllowCommunityBuilderOptIn) {
			return;
		}

		sectionWrapper = $sectionWrapper;
		optInPrompts = $('.optin-prompt');

		updateLanguage($languageInput.val());

		$languageInput.on('change', onLanguageInputChange);
		$hubInput.on('change', onHubInputChange);
		bindCategoryCheckboxes();
	}

	function bindCategoryCheckboxes() {
		var selector = SHOW_MODAL_ON_CATEGORIES
			.map(function(c) {
				return 'input[data-short='+c+']';
			})
			.join(',');

		$(selector).on('change', onShowModalCategoryChanged);
	}

	function onLanguageInputChange(event) {
		updateLanguage(event.currentTarget.value);
	}

	function onHubInputChange(event) {
		if (SHOW_MODAL_ON_HUBS.indexOf(event.currentTarget.value) !== -1) {
			showModal();
		}
	}

	function onShowModalCategoryChanged(event) {
		if (event.currentTarget.checked) {
			showModal();
		}
	}

	function updateLanguage(language) {
		currentLanguage = language;

		if (isCurrentLanguageAllowed()) {
			sectionWrapper.addClass(PROMPT_ENABLED_WRAPPER_CLASS);
			optInPrompts.show();
		} else {
			sectionWrapper.removeClass(PROMPT_ENABLED_WRAPPER_CLASS);
			optInPrompts.hide();
		}
	}

	function isCurrentLanguageAllowed() {
		return ENABLED_ON_LANGUAGES.indexOf(currentLanguage) !== -1;
	}

	function showModal() {
		if (viewedOptInModal || !isCurrentLanguageAllowed()) {
			return;
		}

		viewedOptInModal = true;
		console.log('look at this modal!');
	}

	return {
		init: init
	};
});
