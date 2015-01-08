/* global WikiaForm, UserSignupAjaxForm */
(function () {
	'use strict';

	var UserSignup = {
		inputsToValidate: ['userloginext01', 'email', 'userloginext02', 'birthday'],
		notEmptyFields: ['userloginext01', 'email', 'userloginext02', 'birthday', 'birthmonth', 'birthyear'],
		invalidInputs: {},
		useCaptcha: !window.wgUserLoginDisableCaptcha,

		/**
		 * Enable user signup form with ajax validation
		 */
		init: function () {
			this.wikiaForm = new WikiaForm('#WikiaSignupForm');
			this.captchaField = this.useCaptcha ? 'recaptcha_response_field' : '';
			if (this.captchaLoadError()) {
				this.handleCaptchaLoadError();
				return;
			}

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
		 * Check if the captcha solution fails to load, possibly due to google being blocked (UC-202)
		 * @returns {boolean}
		 */
		captchaLoadError: function () {
			var $captchaInput;

			// if we don't need captcha on this form, there's nothing to fail
			if (!this.useCaptcha) {
				return false;
			}

			$captchaInput = $('#' + this.captchaField);
			return !$captchaInput.length;
		},

		/**
		 * Captcha is required for signup, so if it fails to load, disable the form
		 * fields and inform the user. Note, this is different from when a user
		 * fails to match the blurry word.
		 */
		handleCaptchaLoadError: function () {
			this.wikiaForm.disableAll();

			require(['wikia.ui.factory'], function (uiFactory) {
				$.when(uiFactory.init('modal'))
					.then(function (uiModal) {
						var modalConfig = {
							vars: {
								id: 'catchaLoadErrorModal',
								classes: ['captcha-load-error-modal'],
								size: 'medium',
								title: $.msg('usersignup-page-captcha-load-fail-title'),
								content: $.msg('usersignup-page-captcha-load-fail-text')
							}
						};

						uiModal.createComponent(modalConfig, function (captchaErrorModal) {
							captchaErrorModal.show();
						});
					});
			});

			Wikia.tracker.track({
				action: Wikia.tracker.actions.ERROR,
				category: 'user-sign-up',
				label: 'captcha-load-fail',
				trackingMethod: 'both'
			});
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
