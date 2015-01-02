/* global WikiaForm, UserSignupAjaxForm */
(function () {
	'use strict';

	var UserSignup = {
		inputsToValidate: ['userloginext01', 'email', 'userloginext02', 'birthday'],
		notEmptyFields: ['userloginext01', 'email', 'userloginext02', 'birthday', 'birthmonth', 'birthyear'],
		captchaField: window.wgUserLoginDisableCaptcha ? '' : 'recaptcha_response_field',
		invalidInputs: {},

		/**
		 * Enable user signup form with ajax validation
		 */
		init: function () {
			this.wikiaForm = new WikiaForm('#WikiaSignupForm');
			this.submitButton = this.wikiaForm.inputs.submit;
			this.signupAjaxForm = new UserSignupAjaxForm({
				wikiaForm: this.wikiaForm,
				inputsToValidate: this.inputsToValidate,
				submitButton: this.submitButton,
				notEmptyFields: this.notEmptyFields,
				captchaField: this.captchaField
			});

			this.initOptIn();
			this.setCountryValue();
			this.setupValidation();
			this.termsOpenNewTab();
		},

		/**
		 * Applying ajax validation to the form fields that have been cached via WikiaForm
		 */
		setupValidation: function () {
			var inputs = this.wikiaForm.inputs;

			inputs.userloginext01
				.add(inputs.email)
				.add(inputs.userloginext02)
				.on('blur.UserSignup', this.signupAjaxForm.validateInput.bind(this.signupAjaxForm));

			inputs.birthday
				.add(inputs.birthmonth)
				.add(inputs.birthyear)
				.on('change.UserSignup', this.signupAjaxForm.validateBirthdate.bind(this.signupAjaxForm));

			if (
				window.wgUserLoginDisableCaptcha !== true &&
				inputs.recaptcha_response_field // jshint ignore:line
			) {
				inputs.recaptcha_response_field // jshint ignore:line
					.on('keyup.UserSignup', this.signupAjaxForm.activateSubmit.bind(this.signupAjaxForm));
			}
		},

		/**
		 * Duplicating target=_blank functionality for link that is part of core and created via wikitext
		 */
		termsOpenNewTab: function () {
			$('.wikia-terms > a').on('click', function (event) {
				var url = $(this).attr('href');
				event.preventDefault();
				window.open(url, '_blank');
			});
		},

		/**
		 * Handle marketing email opt-in for different locales
		 */
		initOptIn: function () {
			var self = this;

			require(['usersignup.marketingOptIn'], function (optIn) {
				optIn.init(self.wikiaForm);
			});
		},
		/**
		 * Send country code upon signup
		 */
		setCountryValue: function () {
			var country = Wikia.geo.getCountryCode();
			this.wikiaForm.inputs.wpRegistrationCountry.val(country);
		}
	};

	// expose global
	window.UserSignup = UserSignup;

	$(window).on('load', function () {
		UserSignup.init();
	});
})();
