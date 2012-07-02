/**
 * Front-end scripting core for the MoodBar MediaWiki extension
 *
 * @author Timo Tijhof, 2011
 * @author Rob Moen, 2011
 */

( function( $ ) {

	var mb = mw.moodBar;
	$.extend( mb, {

		tpl: {			
			overlayBase: '\
				<div id="mw-moodBar-overlayWrap"><div id="mw-moodBar-overlay">\
					<div id="mw-moodBar-pokey"></div>\
					<span class="mw-moodBar-overlayClose"><a href="#"><html:msg key="moodbar-close" /></a></span>\
					<div class="mw-moodBar-overlayContent"></div>\
				</div></div>',
			userinput: '\
					<div class="mw-moodBar-overlayTitle"><span><html:msg key="INTROTITLE" /></span></div>\
					<div class="mw-moodBar-types-container">\
						<div class="mw-moodBar-types"></div>\
					</div>\
					<div class="mw-moodBar-form">\
						<div class="mw-moodBar-formTitle">\
							<span class="mw-moodBar-formNote"><span id="mw-moodBar-charCount"></span><html:msg key="moodbar-form-note-dynamic" /></span>\
							<html:msg key="moodbar-form-title" />\
						</div>\
						<div class="mw-moodBar-formInputs">\
							<textarea rows="3" id="mw-moodBar-feedbackInput" class="mw-moodBar-formInput" /></textarea>\
							<div class="mw-moodBar-privacy"></div>\
							<input type="button" class="mw-moodBar-formSubmit" disabled="disabled" />\
						</div>\
					</div>\
					<span class="mw-moodBar-overlayWhat">\
						<a href="#" title-msg="tooltip-moodbar-what">\
							<span class="mw-moodBar-overlayWhatTrigger"></span>\
							<span class="mw-moodBar-overlayWhatLabel"><html:msg key="moodbar-what-label" /></span>\
						</a>\
						<div class="mw-moodBar-overlayWhatContent"></div>\
					</span>',
			emailinput: '\
					<div class="mw-moodBar-overlayTitle"><span><html:msg key="moodbar-email-title" /></span></div>\
						<div class="mw-moodBar-form">\
							<div class="mw-moodBar-desc">\
								<html:msg key="moodbar-email-desc" />\
							</div>\
							<div class="mw-moodBar-formInputs">\
								<div>\
									<html:msg key="moodbar-email-input" />\
									<input type="text" id="mw-moodBar-emailInput" class="mw-moodBar-emailInput" />\
								</div>\
								<input type="button" class="mw-moodBar-emailSubmit" disabled="disabled" />\
								<input type="button" class="mw-moodBar-emailOptOut" />\
							</div>\
						</div>',
			emailconfirmation: '\
					<div class="mw-moodBar-overlayTitle"><span><html:msg key="moodbar-email-confirm-title" /></span></div>\
						<div class="mw-moodBar-form">\
							<div class="mw-moodBar-desc">\
								<html:msg key="moodbar-email-confirm-desc" />\
							</div>\
							<div class="mw-moodBar-formInputs">\
								<input type="button" class="mw-moodBar-emailConfirm" />\
								<input type="button" class="mw-moodBar-emailOptOut" />\
							</div>\
						</div>',
			type: '\
				<span class="mw-moodBar-type mw-moodBar-type-$1" rel="$1">\
					<span class="mw-moodBar-typeTitle"><html:msg key="moodbar-type-$1-title" /></span>\
				</span>',
			loading: '\
				<div class="mw-moodBar-state mw-moodBar-state-loading">\
					<div class="mw-moodBar-state-title"><html:msg key="moodbar-loading-title" /></div>\
					<div class="mw-moodBar-state-subtitle"><html:msg key="moodbar-loading-subtitle" /></div>\
				</div>',
			updatingEmail: '\
				<div class="mw-moodBar-state mw-moodBar-state-loading">\
					<div class="mw-moodBar-state-title"><html:msg key="moodbar-updating-title" /></div>\
					<div class="mw-moodBar-state-subtitle"><html:msg key="moodbar-updating-subtitle" /></div>\
				</div>',
			success: '\
				<div class="mw-moodBar-state mw-moodBar-state-success">\
					<div class="mw-moodBar-state-title"><html:msg key="moodbar-success-title" /></div>\
					<div class="mw-moodBar-state-subtitle"><html:msg key="moodbar-success-subtitle" /></div>\
				</div>',
			error: '\
				<div class="mw-moodBar-state mw-moodBar-state-error">\
					<div class="mw-moodBar-state-title"><html:msg key="moodbar-error-title" /></div>\
					<div class="mw-moodBar-state-subtitle"><html:msg key="moodbar-error-subtitle" /></div>\
				</div>',
			blocked: '\
				<div class="mw-moodBar-state mw-moodBar-state-error">\
					<div class="mw-moodBar-state-title"><html:msg key="moodbar-blocked-title" /></div>\
					<div class="mw-moodBar-state-subtitle"><html:msg key="moodbar-blocked-subtitle" /></div>\
				</div>'
		},

		event: {
			trigger: function( e ) {
				e.preventDefault();
				if ( mb.ui.overlay.is( ':hidden' ) ) {
					mb.swapContent( mb.tpl.userinput );
					mb.ui.overlay.show();
					mb.ui.tooltip.hide();
				} else {
					mb.ui.overlay.hide();
				}
			},
			
			disable: function( e ) {
				e.preventDefault();
				$.cookie(
					mb.cookiePrefix() + 'disabled',
					'1',
					{ 'path': '/', 'expires': Number( mb.conf.disableExpiration ) }
				);
				mb.ui.overlay.fadeOut( 'fast' );
				mb.ui.trigger.fadeOut( 'fast' );
			},

			emailOptOut: function( e ) {
				$.cookie(
					mb.cookiePrefix() + 'emailOptOut',
					'1',
					{ 'path': '/', 'expires': Number( mb.conf.disableExpiration ) }
				);
			}
		},

		feedbackItem: {
			comment: '',
			bucket: mb.conf.bucketKey,
			type: 'unknown',
			callback: function( data ) {
				if ( data && data.moodbar && data.moodbar.result === 'success' ) {
					
					var emailFlag,emailOptOut = ($.cookie( mb.cookiePrefix() + 'emailOptOut' ) == '1');

					// if opt out cookie not set and if email is on globally, proceed with email prompt
					if( emailOptOut === false && mw.config.get( 'mbEmailEnabled' ) ) { 

						if( mw.config.get( 'mbUserEmail' ) ) { // if user has email

							if ( !mw.config.get( 'mbIsEmailConfirmationPending' ) ) { // if no confirmation pending, show form.
								mb.showSuccess();
		
							} else { //show email confirmation form
								mb.swapContent ( mb.tpl.emailconfirmation );
							}

						} else { //no email, show email input form
							mb.swapContent( mb.tpl.emailinput );
						} 

					} else { //user has email opt-out cookie set, or email is disabled
						mb.showSuccess();
					} 
					
				} else if (data && data.error && data.error.code === 'blocked') { 
					mb.swapContent( mb.tpl.blocked );
					setTimeout( function() {
						mb.ui.overlay.fadeOut();
					}, 3000 );
				} else {
					mb.swapContent( mb.tpl.error );
				}
			}
		},

		showSuccess: function() {
			mb.swapContent( mb.tpl.success );	
			setTimeout( function() {
				mb.ui.overlay.fadeOut();
			}, 3000 );
		},

		emailInput: {
			email: '',
			callback: function( data ) {
				mb.showSuccess();
				//set email flag to true so we do not ask again on this page load.
				mw.config.set({'mbUserEmail': true, 'mbIsEmailConfirmationPending': true});
			}
		},

		emailVerify: {
			callback: function ( data ) {
				mb.showSuccess();
				//set conf pending flag to false so we do not ask again on this page load.
				mw.config.set({'mbIsEmailConfirmationPending': false});
			}	

		},

		prepareUserinputContent: function( overlay ) {
			overlay
				// Populate type selector
				.find( '.mw-moodBar-types' )
					.append( function() {
						var	$mwMoodBarTypes = $( this ),
							elems = [];
						$.each( mb.conf.validTypes, function( id, type ) {
							elems.push(
								$( mb.tpl.type.replace( /\$1/g, type ) )
									.localize()
									.click( function( e ) {
										var $el = $( this );
										mb.ui.overlay.find( '.mw-moodBar-formInput' ).focus();
										$mwMoodBarTypes.addClass( 'mw-moodBar-types-select' );
										mb.feedbackItem.type = $el.attr( 'rel' );
										$el.addClass( 'mw-moodBar-selected' )
											.addClass( 'mw-moodBar-' + mb.feedbackItem.type + '-selected' );
										$el.parent()
											.find( '.mw-moodBar-selected' )
												.not( $el )
												.removeClass( 'mw-moodBar-selected' )
												.removeClass( 'mw-moodBar-happy-selected' )
												.removeClass( 'mw-moodBar-sad-selected' )
												.removeClass( 'mw-moodBar-confused-selected' );
										mb.validateFeedback();
									} )
									.get( 0 )
							);
						} );
						return elems;
					} )
					.hover( function() {
						$( this ).addClass( 'mw-moodBar-types-hover' );
					}, function() {
						$( this ).removeClass( 'mw-moodBar-types-hover' );
					} )
					.end()
				// Link what-button
				.find( '.mw-moodBar-overlayWhatTrigger' )
					//.text( mw.msg( 'moodbar-what-collapsed' ) )
					.addClass('moodbar-what-collapsed')
					.end()
				.find( '.mw-moodBar-overlayWhat > a' )
					.click( function( e ) {
						e.preventDefault();
						mb.ui.overlay
							.find( '.mw-moodBar-overlayWhatContent' )
								.each( function() {
									var	$el = $( this ),
										$trigger = mb.ui.overlay.find( '.mw-moodBar-overlayWhatTrigger' );
									if ( $el.is( ':visible' ) ) {
										$el.slideUp( 'fast' );
										//$trigger.html( mw.msg( 'moodbar-what-collapsed' ) );
										$trigger.addClass('moodbar-what-collapsed')
											.removeClass('moodbar-what-expanded');
									} else {
										$el.slideDown( 'fast' );
										//$trigger.html( mw.msg( 'moodbar-what-expanded' ) );
										$trigger.addClass('moodbar-what-expanded')
											.removeClass('moodbar-what-collapsed');
									}
								} );
					} )
					.end()
				.find( '.mw-moodBar-overlayWhatContent' )
					.html(
						function() {
							var	message, linkMessage, link,
								disableMsg, disableLink, out;

							message = mw.msg( 'moodbar-what-content' );
							linkMessage = mw.msg( 'moodbar-what-link' );
							link = mw.html.element( 'a', {
									'href': mb.conf.infoUrl,
									'title': linkMessage,
									'target': '_blank' 
								}, linkMessage );

							out = mw.html.escape( message )
								.replace( /\$1/, link );
							out = mw.html.element( 'p', {},
								new mw.html.Raw( out )
							);
							
							disableMsg = mw.msg( 'moodbar-disable-link' );
							disableLink = mw.html.element( 'a', {
								'href' : '#',
								'class' : 'mw-moodBar-disable'
							}, disableMsg );
							
							out += mw.html.element( 'p', {},
								new mw.html.Raw( disableLink )
							);
							
							return out;
						}
					)
					.find('.mw-moodBar-disable')
					.click( mb.event.disable )
					.end()
					.end()
				.find( '.mw-moodBar-privacy' )
					.html(
						function() {
							var message, linkMessage, linkTitle, link;

							message = mw.msg( 'moodbar-privacy' );
							linkMessage = mw.msg( 'moodbar-privacy-link' );
							linkTitle = mw.msg( 'moodbar-privacy-link-title' );
							link = mw.html.element( 'a', {
									'href': mb.conf.privacyUrl,
									'title': linkTitle,
									'target': '_blank' 
								}, linkMessage );

							return mw.html.escape( message )
								.replace( /\$1/, link );
						}
					)
					.end()
				// set up character count
				.find( '.mw-moodBar-formNote' )
					.html(
						function() {
							var message, counterElement;
							message = mw.msg( 'moodbar-form-note-dynamic' );							
							counterElement = mw.html.element( 'span', {
									'id': 'mw-moodBar-charCount'
								} );
							return mw.html.escape( message )
								.replace( /\$1/, counterElement );
						}
					)
					.end()

					
				// Submit
				.find( '.mw-moodBar-formSubmit' )
					.val( mw.msg( 'moodbar-form-submit' ) )
					.click( function() {
						mb.feedbackItem.comment = $.trim(mb.ui.overlay.find( '.mw-moodBar-formInput' ).val() );
						if( mb.feedbackItem.comment.length > 0 ){
							mb.swapContent( mb.tpl.loading );
							$.moodBar.submit( mb.feedbackItem );
						}
					} )
					.end()
					
				// Keypress
				.find( '#mw-moodBar-feedbackInput' )
					.keyup( function(event) {							
						mb.validateFeedback();
					})
					.end();
			
				// Set up character counter
				// This is probably not the right way to do this.
				$( '#mw-moodBar-feedbackInput' )
					.NobleCount('#mw-moodBar-charCount', {	
						max_chars:140,
						/*
						 * Callbacks:
						 * function on_negative: called when text field is negative in remaining characters.
						 * @param t_obj is the text object.  need to pass to the callback to add modifiers. 
						 */
						on_negative: function( t_obj ) {
							$( t_obj )
							.parent().prev()
							.find('.mw-moodBar-formNote')
							.addClass('red-bold');
						},
						/*
						 * function on_positive: called when text field has available remaining characters.
						 * @param t_obj is the text object.  need to pass to the callback to add modifiers. 
						 */
						on_positive: function( t_obj ) {
							$( t_obj )
							.parent().prev()
							.find('.mw-moodBar-formNote')
							.removeClass('red-bold');
						}
					});
		},

		prepareSuccess: function( overlay ) {
			
			var fbdLink = mw.html.element('a', {
				'href' : mb.conf.feedbackDashboardUrl,
				'target': '_blank' 
			}, mw.msg ( 'moodbar-fbd-link-title' ));
		
			var subTitle = overlay
				.find('.mw-moodBar-state-subtitle');
			var subTitleText = subTitle
				.text()
				.replace( new RegExp( $.escapeRE('{{FBD-LINK}}'), 'g' ), fbdLink );
			subTitle.html(subTitleText);
				
		},

		prepareEmailInput: function ( overlay ) {
			overlay
				.find('#mw-moodBar-emailInput')
				.keyup(function(event){
					mb.validateEmail();
				})
				.end()
				.find('.mw-moodBar-emailOptOut')
				.val ( mw.msg ( 'moodbar-email-optout' ) ) 
				.click (function(event) {
					//set cookie to prevent this from coming back
					mb.event.emailOptOut();
					mb.showSuccess();
				})
				.end()
				.find('.mw-moodBar-emailSubmit')
				.val( mw.msg( 'moodbar-email-submit' ) ) 
				.click( function( event ) {
					//set the email address in the userdata to prevent email form on same page view
					mb.userData.email = mb.emailInput.email = overlay.find('#mw-moodBar-emailInput').val();
					mb.swapContent( mb.tpl.updatingEmail );
					$.moodBar.setEmail (mb.emailInput);
				});				

		},

		prepareEmailVerification: function ( overlay ) {
			overlay
				.find( '.mw-moodBar-emailConfirm' )
				.val( mw.msg ( 'moodbar-email-resend-confirmation' ) ) 
				.click ( function() {
					mb.swapContent( mb.tpl.updatingEmail );
					$.moodBar.resendVerification( mb.emailVerify );
				})
				.end()
				.find( '.mw-moodBar-emailOptOut' )
				.val( mw.msg ( 'moodbar-email-optout' ) ) 
				.click( function ( event ) {
					//set cookie to prevent this from coming back
					mb.event.emailOptOut();
					mb.showSuccess();	
				});

		},

		core: function() {

			// Create overlay
			mb.ui.overlay = $( mb.tpl.overlayBase )
				.localize()
				// Bind close-toggle
				.find( '.mw-moodBar-overlayClose' )
					.click( mb.event.trigger )
					.end();
			mb.swapContent( mb.tpl.userinput );

			mb.ui.overlay.appendTo( 'body' );
			mb.ui.overlay.show();
			
			// Get the width of the types element, and add 100px
			// 52px in known margins, 58px seems to be a necessary
			// fudge factor, plus 30px so the close button doesn't collide
			// with the rounded corners
			// Check for ie7 before applying fix. Was breaking in chrome.
			if( navigator.userAgent.toLowerCase().indexOf('msie 7') !== -1 ) {
				var newWidth = mb.ui.overlay
						.find('.mw-moodBar-types')
						.width() + 140;
				var titleWidth = mb.ui.overlay
						.find('.mw-moodBar-overlayTitle span')
						.width() + 100;
				
				if ( newWidth < titleWidth ) {
					newWidth = titleWidth;
				}
				mb.ui.overlay.width(newWidth);
			}

			mb.ui.overlay.hide();
			
			// Bind triger
			mb.ui.trigger.click( mb.event.trigger );
		},

		swapContent: function( tpl ) {
			var	sitenameParams = [mw.config.get( 'wgSiteName' )], // Cache common params
				msgOptions = {
					keys: {
						INTROTITLE: 'moodbar-intro-' + mb.conf.bucketKey
					},
					params: {
						INTROTITLE: sitenameParams,
						'moodbar-loading-subtitle': sitenameParams,
						'moodbar-success-subtitle': sitenameParams,
						'moodbar-error-subtitle': sitenameParams
					}
				};

			mb.ui.overlay
				.find( '.mw-moodBar-overlayContent' )
					.html( tpl )
					.localize( msgOptions );

			if ( tpl == mb.tpl.userinput ) {
				mb.prepareUserinputContent( mb.ui.overlay );
			}
			if ( tpl == mb.tpl.emailinput ) {
				mb.prepareEmailInput ( mb.ui.overlay );
			}
			if (tpl == mb.tpl.emailconfirmation) {
				mb.prepareEmailVerification ( mb.ui.overlay );
			}
			if (tpl == mb.tpl.success) {
				mb.prepareSuccess( mb.ui.overlay );
			}
			return true;
		},
		
		validateFeedback: function() {
			var comment = $( '#mw-moodBar-feedbackInput' ).val();
			if( $.trim( comment ).length > 0 && comment.length <= 140 && $( '.mw-moodBar-selected').length ) {
				mb.ui.overlay.find( '.mw-moodBar-formSubmit').prop('disabled', false);
			} else {
				mb.ui.overlay.find( '.mw-moodBar-formSubmit').prop('disabled', true);		
			}
		},

		validateEmail: function() {
			var email = $( '#mw-moodBar-emailInput' ).val();
			if( mw.util.validateEmail( email ) ) {
				mb.ui.overlay.find( '.mw-moodBar-emailSubmit').prop('disabled', false);
			} else {
				mb.ui.overlay.find( '.mw-moodBar-emailSubmit').prop('disabled', true);		
			}
		}

	} );

	if ( !mb.isDisabled() ) {
		mb.core();
	}

} )( jQuery );
