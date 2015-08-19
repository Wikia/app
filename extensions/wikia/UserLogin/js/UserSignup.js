/* global WikiaForm, UserSignupAjaxValidation, UserSignupMixin */
(function () {
	'use strict';

	/**
	 * JS for signing up with a new account, on BOTH MOBILE and DESKTOP
	 */
	var UserSignup = {
		invalidInputs: {},

		/**
		 * Enable user signup form with ajax validation
		 */
		init: function () {
			this.wikiaForm = new WikiaForm('#WikiaSignupForm');
			this.submitButton = this.wikiaForm.inputs.submit;

			this.setupValidation();
			this.setupHumanTracking();

			// imported via UserSignupMixin
			this.setCountryValue(this.wikiaForm);
			this.initOptIn(this.wikiaForm);
		},

		/**
		 * Applying ajax validation to the form fields that have been cached via WikiaForm
		 */
		setupValidation: function () {
			var inputs = this.wikiaForm.inputs;

			this.validator = new UserSignupAjaxValidation({
				wikiaForm: this.wikiaForm,
				submitButton: this.submitButton,
				passwordInputName: 'userloginext02'
			});

			inputs.userloginext01
				.add(inputs.email)
				.add(inputs.userloginext02)
				.on('blur.UserSignup', this.validator.validateInput.bind(this.validator));

			inputs.birthday
				.add(inputs.birthmonth)
				.add(inputs.birthyear)
				.on('change.UserSignup', this.validator.validateBirthdate.bind(this.validator));
		},

		setupHumanTracking: function () {
			$(document).on(
				'mousemove.humanTracking keypress.humanTracking touchstart.humanTracking',
				function(event) {
					$(this).off('.humanTracking');

					require(['wikia.tracker'], function (tracker) {
						tracker.track({
							category: 'user-sign-up',
							trackingMethod: 'analytics',
							action: tracker.ACTIONS.VIEW,
							label: 'human-pageview-' + event.type
						});
					});
				}
			);
		}
	};

	// Add common user signup mixin functions for use in this class
	UserSignupMixin.call(UserSignup);

	// expose global
	window.UserSignup = UserSignup;

	$(function () {
		UserSignup.init();
	});
})();
