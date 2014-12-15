/* global WikiaForm, UserSignupAjaxForm, Wikia */
(function () {
	'use strict';

	var UserSignup = {
		inputsToValidate: ['userloginext01', 'email', 'userloginext02', 'birthday'],
		notEmptyFields: ['userloginext01', 'email', 'userloginext02', 'birthday', 'birthmonth', 'birthyear'],
		captchaField: window.wgUserLoginDisableCaptcha ? '' : 'recaptcha_response_field',
		invalidInputs: {},
		init: function () {
			var country;

			$('.wikia-terms > a').on('click', function (event) {
				var url = $(this).attr('href');
				event.preventDefault();
				window.open(url, '_blank');
			});

			this.wikiaForm = new WikiaForm('#WikiaSignupForm');
			this.signupAjaxForm = new UserSignupAjaxForm(
				this.wikiaForm,
				this.inputsToValidate,
				this.wikiaForm.inputs.submit,
				this.notEmptyFields,
				this.captchaField
			);
			this.wikiaForm.el
				.find('input[name=userloginext01], input[name=email], input[name=userloginext02]')
				.on('blur.UserSignup', $.proxy(UserSignup.signupAjaxForm.validateInput, this.signupAjaxForm));
			this.wikiaForm.el
				.find('select[name=birthday], select[name=birthmonth], select[name=birthyear]')
				.on('change.UserSignup', $.proxy(UserSignup.signupAjaxForm.validateBirthdate, this.signupAjaxForm));

			country = this.wikiaForm.el.find('input[name=wpRegistrationCountry]');
			country.val(Wikia.geo.getCountryCode());

			// dom pre-cache
			this.submitButton = this.wikiaForm.inputs.submit;
			if (
				window.wgUserLoginDisableCaptcha !== true &&
				this.wikiaForm.inputs.recaptcha_response_field // jshint ignore:line
			) {
				this.wikiaForm.inputs.recaptcha_response_field // jshint ignore:line
				.on('keyup.UserSignup', $.proxy(UserSignup.signupAjaxForm.activateSubmit, this.signupAjaxForm));
			}
		}
	};

	// expose global
	window.UserSignup = UserSignup;

	$(window).on('load', function () {
		UserSignup.init();
	});
})();
