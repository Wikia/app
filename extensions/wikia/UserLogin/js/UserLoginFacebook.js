var UserLoginFacebook = {
	modal: false,
	form: false,
	callbacks: {},
	initialized: false,

	log: function(msg) {
		$().log(msg, 'UserLoginFacebook');
	},

	init: function() {
		if(!this.initialized) {
			this.initialized = true;
			this.loginSetup();
			this.setupTooltips();

			// load when the login dropdown is shown - see BugId:68955
			$.loadFacebookAPI();

			this.log('init');
		}
	},

	setupTooltips: function() {
		$('.sso-login > a').tooltip();
	},

	loginSetup: function() {
		var self = this;

		$('body').off('fb').on('click.fb', '.sso-login-facebook', function(ev) {
			ev.preventDefault();

			// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
			FB.login($.proxy(self.loginCallback, self), {
				scope:'publish_stream,email'
			});
		});
	},

	// callback for FB.login
	loginCallback: function(response) {
		if (typeof response === 'object' && response.status) {
			this.log(response);
			switch(response.status) {
				case 'connected':
					this.log('FB.login successful');

					// now check FB account (is it connected with Wikia account?)
					$.nirvana.postJson('FacebookSignupController', 'index', $.proxy(this.checkAccountCallback, this));
					break;

				case 'unknown':
					break;
			}
		}
	},

	// check FB account (is it connected with Wikia account?)
	checkAccountCallback: function(resp) {
		if (resp.loggedIn) {
			// logged in using FB account, reload the page or callback
			var loginCallback = this.callbacks['login-success'] || '';
			if (loginCallback && typeof loginCallback === 'function') {
				loginCallback();
			} else {
				require(['wikia.querystring'], function(qs){
					var qString = new qs(),
						returnto = (wgCanonicalSpecialPageName && (wgCanonicalSpecialPageName.match(/Userlogin|Userlogout/))) ? wgMainPageTitle : null;

					if(returnto) {
						qString.setPath(wgArticlePath.replace('$1', returnto));
					}
					qString.addCb().goTo();
				});
			}
		}
		else {
			$.showCustomModal(resp.title, resp.modal, {
				id: 'FacebookSignUp',
				width: 710,
				buttons: [{
					id: 'FacebookSignUpCancel',
					message: resp.cancelMsg,
					handler: $.proxy(function() {
						this.modal.closeModal();
					}, this)
				}],
				callback: $.proxy(this.showSignupModal, this)
			});
		}
	},

	// show FB signup modal
	showSignupModal: function(modal) {
		this.modal = modal;

		var loginCallback = this.callbacks['login-success'] || '';

		// hmm, why was loginajaxform inherited to create this? - hyun is curious
		this.form = new UserLoginFacebookForm(this.modal, {
			ajaxLogin: true,
			callback: function(res) {
				// redirect to the user page
				if (loginCallback && typeof loginCallback === 'function') {
					loginCallback();
				} else if (res.location) {
					window.location.href = res.location;
				}
			}
		});

		this.wikiaForm = this.form.wikiaForm;	// re-reference for convinience

		this.modal.find('.FacebookSignupConfigHeader').bind('click', function(ev) {
			ev.preventDefault();

			$(this).
				toggleClass('on').
				next('form').toggle();
		});

		this.signupAjaxForm = new UserSignupAjaxForm(
			this.wikiaForm,
			null,
			this.form.el.find('input[type=submit]'));
		this.wikiaForm.el
			.find('input[name=username], input[name=password]')
			.bind('blur.UserLoginFacebook', $.proxy(this.signupAjaxForm.validateInput, this.signupAjaxForm));

		$.getResources([$.getSassCommonURL('extensions/wikia/UserLogin/css/UserLoginFacebook.scss')]);
	},

	closeSignupModal: function() {
		if(this.modal) {
			this.modal.closeModal();
		}
	}
};
