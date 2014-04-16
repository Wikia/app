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
				self.actions = tracker.ACTIONS;
				self.track = tracker.buildTrackingFunction( {
					category: 'user-sign-up',
					value: origin || 0,
					trackingMethod: 'both'
				} );
			} );

			this.initialized = true;
			this.loginSetup();

			// load when the login dropdown is shown - see BugId:68955
			$.loadFacebookAPI();

			this.log( 'init' );
		}
	},

	loginSetup: function() {
		'use strict';

		var self = this;

		$( 'body' )
			.off( 'fb' )
			.on( 'click.fb', '.sso-login-facebook', function( ev ) {
				ev.preventDefault();

				// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
				window.FB.login( $.proxy( self.loginCallback, self ), {
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
					// Track FB Connect Error
					this.track( {
						action: this.actions.ERROR,
						label: 'facebook-login'
					} );
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

			// Track FB Connect Login
			this.track( {
				action: this.actions.SUCCESS,
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
		} else if ( resp.loginAborted ) {
			window.GlobalNotification.show( resp.errorMsg, 'error' );
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

						// Track Facebook Connect Modal Close
						facebookSignupModal.bind( 'beforeClose', function () {
							// Track FB Connect Modal Close
							self.track( {
								action: self.actions.CLOSE,
								label: 'facebook-login-modal'
							} );
						} );

						self.form = new UserLoginFacebookForm( $modal, {
							ajaxLogin: true,
							callback: function( res ) {
								// Track FB Connect Sign Up
								self.track( {
									action: self.actions.SUBMIT,
									label: 'facebook-login-modal'
								} );
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
							.on( 'blur', 'input[name=username], input[name=password]',
								$.proxy( signupAjaxForm.validateInput, signupAjaxForm )
							)
							.on( 'click', '.submit-pane .extiw', function( event ) {
								require( ['wikia.tracker'], function( tracker ) {
									tracker.track( {
										action: tracker.ACTIONS.CLICK_LINK_TEXT,
										browserEvent: event,
										category: 'user-sign-up',
										href: $( event.target ).attr( 'href' ),
										label: 'wikia-terms-of-use',
										trackingMethod: 'both'
									} );
								} );
							} );

						// Track FB Connect Modal Open
						self.track( {
							action: self.actions.OPEN,
							label: 'facebook-login-modal'
						} );
						facebookSignupModal.show();
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
