var UserLoginModal = {
	loginAjaxForm: false,
	isInitializationStarted: false,
	uiFactory: false,
	packagesData: false,
	$modal: false,

	initModal: function ( options ) {
		'use strict';

		var that = this;

		require( ['wikia.tracker'], function( tracker ) {
			that.trackerActions = tracker.ACTIONS;
			that.track = tracker.buildTrackingFunction( {
				category: 'force-login-modal',
				trackingMethod: 'both'
			} );
		} );

		$.when(
				Wikia.getMultiTypePackage( {
					templates: [
						{
							controller: 'UserLoginSpecial',
							method: 'modal',
							params: { uselang: window.wgUserLanguage }
						}
					],
					styles: '/extensions/wikia/UserLogin/css/UserLoginModal.scss',
					messages: 'UserLogin'
				} )
			).done( function ( packagesData ) {
				require( [ 'wikia.ui.factory', 'wikia.loader' ], function ( uiFactory, loader ) {
					loader.processStyle( packagesData.styles );

					that.uiFactory = uiFactory;
					that.packagesData = packagesData;

					window.UserLoginFacebook && window.UserLoginFacebook.init( window.UserLoginFacebook.origins.MODAL );

					that.buildModal( options );
				} );
			} );
	},

	buildModal: function(options) {
		'use strict';

		var that = this,
			origin = '',
			clickAction = this.trackerActions.CLICK;

		this.uiFactory.init( 'modal' ).then( function ( uiModal ) {
			var modalConfig = {
				type: 'default',
				vars: {
					id: 'userForceLoginModal',
					size: 'medium',
					content: that.packagesData.templates.UserLoginSpecial_modal,
					title: $.msg( 'userlogin-login-heading' ),
					closeButton: true
				}
			};

			uiModal.createComponent( modalConfig, function ( loginModal ) {
				UserLoginModal.$modal = loginModal;

				var $loginModal = loginModal.$element;

				UserLoginModal.loginAjaxForm = new window.UserLoginAjaxForm( $loginModal, {
					ajaxLogin: true,
					callback: function ( res ) {
						window.wgUserName = res.username;
						var callback = options.callback;
						if ( callback && typeof callback === 'function' ) {
							if ( !options.persistModal ) {
								UserLoginModal.$modal.trigger('close');
							}
							callback();
						} else {
							UserLoginModal.loginAjaxForm.reloadPage();
						}
					},
					resetpasscallback: function () {
						$.nirvana.sendRequest( {
							controller: 'UserLoginSpecial',
							method: 'changePassword',
							format: 'html',
							data: {
								username: UserLoginModal.loginAjaxForm.inputs.username.val(),
								password: UserLoginModal.loginAjaxForm.inputs.password.val(),
								returnto: UserLoginModal.loginAjaxForm.inputs.returnto.val(),
								fakeGet: 1
							},
							callback: function ( html ) {
								var content = $( '<div style="display:none" />' ).append( html ),
									heading = content.find( 'h1' ),
									modal = loginModal,
									contentBlock = $loginModal.find( '.UserLoginModal' );

								modal.setTitle( heading.text() );
								heading.remove();

								contentBlock.slideUp( 400, function () {
									contentBlock.html( '' ).html( content );
									content.show();
									contentBlock.slideDown( 400 );
								} );
							}
						} );
					}
				} );

				if ( options.modalInitCallback && typeof options.modalInitCallback === 'function' ) {
					options.modalInitCallback();
				}

				if ( options.origin ) {
					origin = options.origin;
				}

				that.track( {
					action: that.trackerActions.OPEN,
					label: 'from-' + origin
				} );

				// Click tracking
				$loginModal.on( 'click', '.forgot-password', function() {
					that.track( {
						action: clickAction,
						label: 'forgot-password'
					} );
				} ).on( 'click', 'input.keep-logged-in', function() {
					that.track( {
						action: clickAction,
						label: 'keep-me-logged-in'
					} );
				} ).on( 'click', '.get-account a', function() {
					that.track( {
						action: clickAction,
						label: 'sign-up-from-' + origin
					} );
				} ).on( 'click', '.sso-login-facebook', function() {
					that.track( {
						action: clickAction,
						label: 'facebook-connect'
					} );
				}).on( 'click', 'input.login-button', function(event) {
					that.track( {
						action: clickAction,
						label: 'login-from-'  + origin
					} );
				} );
			} );
		} );
	},

	/**
	 * options (optional):
	 *  callback: callback after login successful login
	 * returns: true if modal is shown, false if it is not
	 */
	show: function ( options ) {
		'use strict';

		if ( !window.wgComboAjaxLogin && window.wgEnableUserLoginExt ) {
			options = options || {};

			options.modalInitCallback = $.proxy( function () { this.$modal.show(); }, this );
			this.initModal( options );

			return true;
		} else if ( window.wgComboAjaxLogin ) {
			/* 1st, 2nd, 4th, and 5th vars in this method is not used outside of ajaxlogin itself*/
			window.showComboAjaxForPlaceHolder( false, false, function () {
				if ( options.callback ) {
					window.AjaxLogin.doSuccess = options.callback;
				}
			}, false, true );

			return true;
		}

		return false;
	},
	isPreventingForceLogin: function ( element ) {
		'use strict';
		if ( !( element.closest( 'span' ).hasClass( 'drop' ) ) &&
			!( element.closest( 'ul' ).hasClass( 'WikiaMenuElement' ) ) ) {
			return false;
		}
		return true;
	},
	init: function () {
		'use strict';
		// attach event handler
		var editpromptable = $( '#te-editanon, .loginToEditProtectedPage, .upphotoslogin' );

		// add .editsection on wikis with anon editing disabled
		if ( window.wgDisableAnonymousEditing ) {
			editpromptable = editpromptable.add( '.editsection' );
		}

		editpromptable.click( $.proxy( function ( ev ) {
			ev.stopPropagation(); // (BugId:34026) stop bubbling up when parent and child both have event listener.

			if ( !this.isPreventingForceLogin( $( ev.target ) ) && window.UserLogin.isForceLogIn() ) {
				ev.preventDefault();
			}
		}, this ) );

		//Attach DOM-Ready handlers
		$( 'body' ).delegate( '.ajaxLogin', 'click', function ( e ) {
			UserLoginModal.show();
			e.preventDefault();
		} );
	}
};

$( function () {
	'use strict';
	if ( ( typeof window.wgEnableUserLoginExt !== 'undefined' ) && window.wgEnableUserLoginExt ) {
		UserLoginModal.init();
	}
} );
