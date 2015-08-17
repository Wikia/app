(function () {
	'use strict';

	var UserSignupMixin = function () {
		/**
		 * Handle marketing email opt-in for different locales
		 */
		this.initOptIn =  function (wikiaForm) {
			require(['usersignup.marketingOptIn'], function (optIn) {
				optIn.init(wikiaForm);
			});
		};
		/**
		 * Send country code upon signup
		 */
		this.setCountryValue = function (wikiaForm) {
			var country = Wikia.geo.getCountryCode();
			wikiaForm.inputs.wpRegistrationCountry.val(country);
		};
	};

	window.UserSignupMixin = UserSignupMixin;
})();
