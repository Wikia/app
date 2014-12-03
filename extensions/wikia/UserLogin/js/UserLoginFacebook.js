/* global UserLoginModal, wgCanonicalSpecialPageName, wgMainPageTitle, wgArticlePath */
/**
 * Handle
 */
require([
	'wikia.tracker',
	'wikia.querystring',
	'wikia.ui.factory'
], function (tracker, QueryString, uiFactory) {
	'use strict';

	var UserLoginFacebook = {
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

		init: function (origin) {
			if (this.initialized) {
				return;
			}
			this.bucky.timer.start('init');
			this.actions = tracker.ACTIONS;
			this.track = tracker.buildTrackingFunction({
				category: 'user-sign-up',
				value: origin || 0,
				trackingMethod: 'both'
			});

			this.initialized = true;
			this.loginSetup();

			// load when the login dropdown is shown or specific page is loaded
			$.loadFacebookAPI();

			this.log('init');
			this.bucky.timer.stop('init');
		},

		loginSetup: function () {
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
		},

		// callback for FB.login
		onFBLogin: function (response) {
			if (typeof response !== 'object' || !response.status) {
				this.bucky.timer.stop('loginSetup');
				return;
			}
			this.log(response);
			switch (response.status) {
			case 'connected':
				this.log('FB.login successful');

				this.track({
					action: this.actions.SUCCESS,
					label: 'facebook-login'
				});

				// begin ajax call performance tracking
				this.bucky.timer.start('loginCallbackAjax');

				// now check FB account (is it connected with Wikia account?)
				$.nirvana.postJson('FacebookSignupController', 'index', {
						returnto: encodeURIComponent(window.wgPageName),
						returntoquery: encodeURIComponent(window.location.search.substring(1))
					},
					$.proxy(this.checkAccountCallback, this));
				break;
			case 'not_authorized':
				// Not logged into the Wikia FB app
				this.track({
					action: this.actions.SUCCESS,
					label: 'facebook-login-not-auth'
				});
				break;
			default:
				// Track FB Connect Error
				this.track({
					action: this.actions.ERROR,
					label: 'facebook-login'
				});
			}
			this.bucky.timer.stop('loginSetup');
		},

		/**
		 * Check if the current user's FB account is connected with a Wikia account and act acordingly
		 * @param {Object} resp Response object from FacebookSignupController::index
		 */
		checkAccountCallback: function (resp) {
			var loginCallback;

			// end ajax call performance tracking
			this.bucky.timer.stop('loginCallbackAjax');

			loginCallback = this.callbacks['login-success'] || '';

			// logged in using FB account, reload the page or callback
			if (resp.loggedIn) {
				this.loggedInCallback(loginCallback);

			// some error occurred
			} else if (resp.loginAborted) {
				window.GlobalNotification.show(resp.errorMsg, 'error');

			// user not logged in, show the login/signup modal
			} else {
				this.showModal(resp, loginCallback);
			}
		},

		/**
		 * This runs after has signed in with facebook and is already registered with Wikia.
		 * @param {function} [callback] Called when outside extension has specified a callback
		 */
		loggedInCallback: function (callback) {
			if (callback && typeof callback === 'function') {
				callback();
			} else {
				this.bucky.timer.start('loggedInCallback');
				var qString = new QueryString(),
					returnTo = (wgCanonicalSpecialPageName &&
						(wgCanonicalSpecialPageName.match(/Userlogin|Userlogout/))) ?
						wgMainPageTitle : null;

				if (returnTo) {
					qString.setPath(wgArticlePath.replace('$1', returnTo));
				}
				// send bucky info immediately b/c the page is about to redirect
				this.bucky.timer.stop('loggedInCallback');
				this.bucky.flush();
				qString.addCb().goTo();
			}
		},

		/**
		 * Show a modal (to logged out users) for logging in or signing up with Wikia
		 * after a successful Facebook connection.
		 * @param {Object} resp Response object from FacebookSignupController::index
		 * @param {function} [callback]
		 */
		showModal: function (resp, callback) {
			var self = this;

			this.bucky.timer.start('loggedOutCallback');
			$.when(
				uiFactory.init('modal'),
				$.getResources(
					[$.getSassCommonURL('extensions/wikia/UserLogin/css/UserLoginFacebook.scss')]
				)
			).then(function (uiModal) {
				var modalConfig = {
					vars: {
						id: 'FacebookSignUp',
						size: 'medium',
						content: resp.modal,
						title: resp.title,
						buttons: [{
							vars: {
								value: resp.cancelMsg,
								data: [{
									key: 'event',
									value: 'close'
								}]
							}
						}]
					}
				};

				uiModal.createComponent(modalConfig, function (facebookSignupModal) {
					var form,
						//wikiaForm,
						signupAjaxForm,
						$modal = facebookSignupModal.$element;

					// set reference to modal object
					self.modal = facebookSignupModal;

					// Track Facebook Connect Modal Close
					facebookSignupModal.bind('beforeClose', function () {
						self.track({
							action: self.actions.CLOSE,
							label: 'facebook-login-modal'
						});
					});

					// Here's the signup form - we also need a login form
					form = new window.UserLoginFacebookForm($modal, {
						ajaxLogin: true,
						callback: function () {
							// Track FB Connect Sign Up
							self.track({
								action: self.actions.SUBMIT,
								label: 'facebook-login-modal'
							});

							// run logged in callback or redirect to the specified location
							if (callback && typeof callback === 'function') {
								callback();
							} else {
								window.location.href = this.returnToUrl;
							}
						}
					});

					// TODO: check if we need to set these properties
					// set reference to form object
					//self.form = form;
					// get WikiaForm object from form
					//wikiaForm = form.wikiaForm;
					// and set reference to WikiaForm object
					//self.wikiaForm = wikiaForm;

					// create signup form
					signupAjaxForm = new window.UserSignupAjaxForm(
						form.wikiaForm,
						null,
						form.el.find('input[type=submit]')
					);
					// and set reference to signup form
					//self.signupAjaxForm = signupAjaxForm;

					// attach handlers to modal content
					$modal
						.on('blur', 'input[name=username], input[name=password]',
							$.proxy(signupAjaxForm.validateInput, signupAjaxForm)
						)
						.on('click', '.submit-pane .extiw', function (event) {
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

	window.UserLoginFacebook = UserLoginFacebook;
});
