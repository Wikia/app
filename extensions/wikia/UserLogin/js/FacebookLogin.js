/* global UserLoginModal, wgScriptPath, BannerNotification, UserSignupAjaxValidation */

/**
 * Handle signing in and signing up with Facebook
 * Only for logged out users. Logged in users can connect with facebook on their preferences page.
 */
(function () {
	'use strict';

	var tracker,
		QueryString,
		uiFactory,
		FacebookLogin,
		bannerNotification;

	FacebookLogin = {
		modal: false,
		form: false,
		callbacks: {},
		initialized: false,
		origins: {
			DROPDOWN: 1,
			PAGE: 2,
			MODAL: 3
		},
		actions: {},
		track: false,
		bucky: window.Bucky('UserLoginFacebook'),

		log: function (msg) {
			$().log(msg, 'UserLoginFacebook');
		},

		/**
		 * Initialize functionality needed to log in or sign up for a new account with facebook
		 * @param {Object} origin Possible values are from FacebookLogin.origins. For tracking how a user got here.
		 */
		init: function (origin) {
			var self = this;

			if (this.initialized || window.wgUserName) {
				return;
			}

			this.bucky.timer.start('init');

			// requiring these variables here instead of at the top of the page to avoid race conditions
			require([
				'wikia.tracker',
				'wikia.querystring',
				'wikia.ui.factory',
				'BannerNotification'
			], function (t, qs, uf, BannerNotification) {

				tracker = t;
				QueryString = qs;
				uiFactory = uf;
				bannerNotification = new BannerNotification().setType('error');
				self.actions = tracker.ACTIONS;
				self.track = tracker.buildTrackingFunction({
					category: 'user-sign-up',
					value: origin || 0,
					trackingMethod: 'both'
				});

				self.initialized = true;
				self.bindEvents();

				// load when the login dropdown is shown or specific page is loaded
				$.loadFacebookSDK();

				self.log('init');
				self.bucky.timer.stop('init');
			});
		},

		/**
		 * Set click handlers for the facebook button
		 */
		bindEvents: function () {
			var self = this;

			this.bucky.timer.start('loginSetup');

			$('body')
				.off('fb')
				.on('click.fb', '.sso-login-facebook', function (ev) {
					ev.preventDefault();

					// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
					window.FB.login($.proxy(self.onFBLogin, self), {
						scope: 'email'
					});
					if (UserLoginModal.$modal) {
						UserLoginModal.$modal.trigger('close');
					}
				});
			this.bucky.timer.stop('loginSetup');
		},

		/**
		 * Callback function after Facebook Login.
		 * @see https://developers.facebook.com/docs/reference/javascript/FB.login/v2.2
		 * @param {Object} response Response object sent from Facebook after login attempt
		 */
		onFBLogin: function (response) {
			var pageUrl,
				returnToURL,
				returnToQuery;

			// There was a connection error or something went horribly wrong.
			if (typeof response !== 'object') {
				this.track({
					action: this.actions.ERROR,
					label: 'facebook-login'
				});

			// User successfully logged in with FB and granted permissions
			} else if (response.authResponse) {
				this.log('FB.login successful');

				this.track({
					action: this.actions.SUCCESS,
					label: 'facebook-login'
				});

				// begin ajax call performance tracking
				this.bucky.timer.start('loginCallbackAjax');

				pageUrl = new QueryString();
				returnToURL = pageUrl.getVal('returnto');
				if (returnToURL) {
					returnToQuery = pageUrl.getVal('returntoquery');
				} else {
					returnToURL = encodeURIComponent(window.wgPageName);
					returnToQuery = encodeURIComponent(window.location.search.substring(1));
				}

				// now check FB account (is it connected with Wikia account?)
				$.nirvana.postJson('FacebookSignupController', 'index', {
						returnto: returnToURL,
						returntoquery: returnToQuery
					},
					$.proxy(this.checkAccountCallback, this)
				);

			// The user didn't grant permissions
			} else {
				this.track({
					action: this.actions.SUCCESS,
					label: 'facebook-login-not-auth'
				});
			}
		},

		/**
		 * Check if the current user's FB account is connected with a Wikia account and act acordingly
		 * @param {Object} response Response object from FacebookSignupController::index
		 */
		checkAccountCallback: function (response) {
			// end ajax call performance tracking
			this.bucky.timer.stop('loginCallbackAjax');

			// if extensions have specified a callback, run it after successful login
			this.loginCallback = typeof this.callbacks['login-success'] === 'function' ?
				this.callbacks['login-success'] : false;

			// logged in using FB account, reload the page or callback
			if (response.loggedIn) {
				if (this.loginCallback) {
					this.loginCallback();
				} else {
					window.location = response.returnUrl;
				}
			// some error occurred
			} else if (response.loginAborted) {
				bannerNotification.setContent(response.errorMsg).show();
			} else if (response.unconfirmed) {
				$.get(wgScriptPath + '/wikia.php', {
					controller: 'UserLoginSpecial',
					method: 'getUnconfirmedUserRedirectUrl',
					format: 'json',
					username: response.userName
				}, function (json) {
					window.location = json.redirectUrl;
				});
			// user not logged in, show the login/signup modal
			} else {
				this.setupModal(response);
			}
		},

		/**
		 * Show a modal (to logged out users) for logging in or signing up with Wikia
		 * after a successful Facebook connection.
		 * @param {Object} response Response object from FacebookSignupController::index
		 */
		setupModal: function (response) {
			if (!response.modal) {
				bannerNotification.setContent($.msg('oasis-generic-error')).show();
				return;
			}

			this.bucky.timer.start('loggedOutCallback');
			$.when(
				uiFactory.init('modal'),
				$.getResources(
					[$.getSassCommonURL('extensions/wikia/UserLogin/css/UserLoginFacebook.scss')]
				)
			// response argument will be prepended to arguments otherwise passed to buildModal
			).then(this.buildModal.bind(this, response));
		},

		/**
		 * Build the login/signup modal once the dependencies are retrieved
		 * @param {Object} response Response object from FacebookSignupController::index
		 * @param {Object} uiModal UI Factory modal
		 */
		buildModal: function (response, uiModal) {
			// show the "or" circle only for languages where it makes sense
			var self = this,
				modalConfig = {
					vars: {
						id: 'FacebookSignUp',
						size: 'medium',
						content: response.modal,
						htmlTitle: response.htmlTitle,
						classes: [
							'facebook-signup-modal'
						]
					}
				};

			uiModal.createComponent(modalConfig, function (facebookSignupModal) {
				var $modal = facebookSignupModal.$element;

				// set reference to modal object
				self.modal = facebookSignupModal;

				// Track Facebook Connect Modal Close
				facebookSignupModal.bind('beforeClose', function () {
					self.track({
						action: self.actions.CLOSE,
						label: 'facebook-login-modal'
					});
				});

				self.createSignupForm($modal);
				self.createLoginForm($modal);

				$modal.on('click', '.extiw', function (event) {
					self.track({
						action: tracker.ACTIONS.CLICK_LINK_TEXT,
						browserEvent: event,
						href: $(event.target).attr('href'),
						label: 'wikia-terms-of-use'
					});
				});

				// Track FB Connect Modal Open
				self.track({
					action: self.actions.OPEN,
					label: 'facebook-login-modal'
				});

				facebookSignupModal.show();
				self.bucky.timer.stop('loggedOutCallback');
			});
		},

		/**
		 * Handle JS for the signup form portion of the modal
		 * @param {Object} $modal jQuery DOM element of the open modal
		 */
		createSignupForm: function ($modal) {
			var self = this;

			this.signupForm = new window.FacebookFormCreateUser($modal.find('.UserLoginFacebookLeft'), {
				ajaxLogin: true,
				skipFocus: true,
				callback: function () {
					// Track FB Connect Sign Up
					self.track({
						action: self.actions.SUBMIT,
						label: 'facebook-signup-modal'
					});

					// run logged in callback or redirect to the specified location
					if (self.loginCallback) {
						self.loginCallback();
					} else {
						window.location.href = this.returnToUrl;
					}
				}
			});

			this.initSignupFormValidation();
		},

		initSignupFormValidation: function () {
			var validator,
				wikiaForm = this.signupForm.wikiaForm,
				inputs = wikiaForm.inputs,
				inputsToValidate = ['username', 'password'],
				$filteredInputs = $();

			if (inputs.email) {
				inputsToValidate.push('email');
			}

			validator = new UserSignupAjaxValidation({
				wikiaForm: wikiaForm,
				submitButton: inputs.submit
			});

			// Add validation on blur event for all inputs to validate
			inputsToValidate.forEach(function (inputName) {
				$filteredInputs = $filteredInputs.add(inputs[inputName]);
			});
			$filteredInputs.on('blur', validator.validateInput.bind(validator));
		},

		/**
		 * Handle JS for the login form portion of the modal
		 * @param {Object} $modal jQuery DOM element of the open modal
		 */
		createLoginForm: function ($modal) {
			var self = this;

			this.loginForm = new window.FacebookFormConnectUser($modal.find('.UserLoginFacebookRight'), {
				ajaxLogin: true,
				skipFocus: true,
				callback: function () {
					// Track FB Connect login
					self.track({
						action: self.actions.SUBMIT,
						label: 'facebook-login-modal'
					});

					// run logged in callback or redirect to the specified location
					if (self.loginCallback) {
						self.loginCallback();
					} else {
						window.location.href = this.returnToUrl;
					}
				}
			});
		},

		/**
		 * Used mainly by other extensions to close the signup modal after a successful login
		 */
		closeSignupModal: function () {
			var modal = this.modal;

			if (modal) {
				modal.trigger('close');
			}
		}
	};

	window.FacebookLogin = FacebookLogin;
})();
