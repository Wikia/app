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



	log: function( msg ) {
		'use strict';

		$().log( msg, 'UserLoginFacebook' );
	},

	init: function( origin ) {
		'use strict';

		var self = this;

		if( !this.initialized ) {
			require( ['wikia.tracker'], function( tracker ) {
				self.actions = tracker.ACTIONS
				self.track = tracker.buildTrackingFunction( {
					category: 'user-sign-up',
					value: origin || 0,
					trackingMethod: 'both'
				} );
			} );

			this.initialized = true;
			this.loginSetup();
			this.setupTooltips();

			// load when the login dropdown is shown - see BugId:68955
			$.loadFacebookAPI();

			this.log( 'init' );
		}
	},

	setupTooltips: function() {
		'use strict';

		$( '.sso-login > a' ).tooltip();
	},

	loginSetup: function() {
		'use strict';

		var self = this;

		$( 'body' )
			.off( 'fb' )
			.on( 'click.fb', '.sso-login-facebook', function( ev ) {
				ev.preventDefault();

				// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
				FB.login( $.proxy( self.loginCallback, self ), {
					scope:'publish_stream,email'
				} );
		} );
	},

	// callback for FB.login
	loginCallback: function( response ) {
		'use strict';

		if ( typeof response === 'object' && response.status ) {
			this.log( response );
			switch ( response.status ) {
				case 'connected':
					this.log( 'FB.login successful' );

					// now check FB account (is it connected with Wikia account?)
					$.nirvana.postJson( 'FacebookSignupController', 'index', $.proxy(
						this.checkAccountCallback, this )
					);
					break;

				default:
					this.track( {
						action: this.actions.ERROR,
						label: 'facebook-login'
					} );
					break;
			}
		}
	},

	// check FB account (is it connected with Wikia account?)
	checkAccountCallback: function( resp ) {
		'use strict';

		var self = this,
			loginCallback = this.callbacks['login-success'] || '';

		if ( resp.loggedIn ) {
			// logged in using FB account, reload the page or callback

			this.track( {
				action: this.tracker.ACTIONS.SUCCESS,
				label: 'facebook-login'
			} );

			if ( loginCallback && typeof loginCallback === 'function' ) {
				loginCallback();
			} else {
				require( ['wikia.querystring'], function( Qs ) {
					var w = window,
						wgCanonicalSpecialPageName = w.wgCanonicalSpecialPageName,
						qString = new Qs(),
						returnTo = ( wgCanonicalSpecialPageName &&
							( wgCanonicalSpecialPageName.match( /Userlogin|Userlogout/ ) ) ) ? w.wgMainPageTitle : null;

					if( returnTo ) {
						qString.setPath( w.wgArticlePath.replace( '$1', returnTo ) );
					}
					qString.addCb().goTo();
				} );
			}
		} else {
			require( ['wikia.ui.factory'], function( uiFactory ) {
				$.when(
					uiFactory.init( 'modal' ),
					$.getResources(
						[$.getSassCommonURL( 'extensions/wikia/UserLogin/css/UserLoginFacebook.scss' )]
					)
				).then( function( uiModal ) {
					var modalConfig = {
						vars: {
							id: 'FacebookSignUp',
							size: 'medium',
							content: resp.modal,
							title: resp.title,
							buttons: [
								{
									vars: {
										value: resp.cancelMsg,
										data: [
											{
												key: 'event',
												value: 'close'
											}
										]
									}
								}
							]
						}
					};

					uiModal.createComponent( modalConfig, function( facebookSignupModal ) {
						var form,
							wikiaForm,
							signupAjaxForm,
							$modal = facebookSignupModal.$element;

						self.modal = facebookSignupModal; // set reference to modal object

						self.track( {
							action: self.tracker.ACTIONS.CONFIRM
						} );

						// Track Facebook Connect Modal Close
						facebookSignupModal.bind( 'beforeClose', function () {
							self.track( {
								action: self.tracker.ACTIONS.CLOSE,
								label: 'facebook-login-modal'
							} );
						} );

						self.form = new UserLoginFacebookForm( $modal, {
							ajaxLogin: true,
							callback: function( res ) {
								var location = res.location;

								// redirect to the user page
								if ( loginCallback && typeof loginCallback === 'function' ) {
									loginCallback();
								} else if ( location ) {
									window.location.href = location;
								}
							}
						} );
						form = self.form; // cache in local variables

						self.wikiaForm = form.wikiaForm; // re-reference for convinience
						wikiaForm = self.wikiaForm; // cache in local variables

						self.signupAjaxForm = new UserSignupAjaxForm(
							wikiaForm,
							null,
							form.el.find( 'input[type=submit]' )
						);
						signupAjaxForm = self.signupAjaxForm; // cache in local variables

						// attach handlers to modal content
						$modal
							.on( 'click', '.FacebookSignupConfigHeader', function( event ) {
								event.preventDefault();
								$( this ).toggleClass( 'on' ).next( 'form' ).toggle();
							} )
							.on ( 'blur', 'input[name=username], input[name=password]',
								$.proxy( signupAjaxForm.validateInput, signupAjaxForm ) );

						facebookSignupModal.show();

						// TODO: temporary fix - force repaint
						// find a way to fix forms on modal rendering issues on chrome
						// o wait till chrome fixes its rendering bug -
						// when changing position relative to fixed on <body>
						$modal.hide().height();
						$modal.show();
					} );
				} );
			} );
		}
	},

	closeSignupModal: function() {
		'use strict';

		var modal = this.modal;

		if( modal ) {
			modal.trigger( 'close' );
		}
	}
};
