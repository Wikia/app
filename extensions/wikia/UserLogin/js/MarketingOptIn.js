define('usersignup.marketingOptIn', ['wikia.geo'], function (geo) {
	'use strict';

	/**
	 * Set up marketing opt-in checkbox for different locales
	 * Canada sees the checkbox unchecked
	 * Europe sees the checkbox checked
	 * Everywhere else is opted in automatically
	 * @param {WikiaForm} wikiaForm
	 */
	function init(wikiaForm) {
		var $optInField = wikiaForm.inputs.wpMarketingOptIn,
			$optInGroup = wikiaForm.getInputGroup('wpMarketingOptIn'),
			isEurope = geo.getContinentCode() === 'EU',
			isCanada = geo.getCountryCode() === 'CA',
			isJapan = geo.getCountryCode() === 'JP';

		if (!$optInField.length || !$optInGroup.length) {
			throw 'Wikia Form must contain a field called wpMarketingOptIn';
		}

		if (!isCanada && !isJapan) {
			$optInField.attr('checked', true);
		}

		if (isEurope || isCanada || isJapan) {
			$optInGroup
				.add($optInField)
				.removeClass('hidden');
		}
	}

	return {
		init: init
	};
});
