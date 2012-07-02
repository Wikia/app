/*
 * Script for Article Feedback Plugin
 */

( function( $ ) {
// Only track users who have been assigned to the tracking group
var tracked = 'track' === mw.user.bucket(
	'ext.articleFeedback-tracking', mw.config.get( 'wgArticleFeedbackTracking' )
);

// Only show extra options to users in the options group
var showOptions = 'show' === mw.user.bucket(
	'ext.articleFeedback-options', mw.config.get( 'wgArticleFeedbackOptions' )
);

var loadUserRatings = !mw.user.anonymous() || $.cookie( prefix( 'rated' ) ) === 'true';

/**
 * Prefixes a key for cookies or events, with extension and version information
 * 
 * @param event String: Name of event to prefix
 * @return String: Prefixed event name
 */
function prefix( key ) {
	var version = mw.config.get( 'wgArticleFeedbackTracking' ).version || 0;
	return 'ext.articleFeedback@' + version + '-' + key;
}

/**
 * Given an email sting, gets validity status (true, false, null) and updates the label CSS class
 */
var updateMailValidityLabel = function( mail, context ) {
	var	isValid = mw.util.validateEmail( mail ),
		$that = context.$ui.find( '.articleFeedback-helpimprove-email' );

	// We allow empty address
	if( isValid === null ) {
		$that.removeClass( 'valid invalid' );

	// Valid
	} else if ( isValid ) {
		$that.addClass( 'valid' ).removeClass( 'invalid' );

	// Not valid
	} else {
		$that.addClass( 'invalid' ).removeClass( 'valid' );
	}
};

/**
 * Article Feedback jQuery Plugin Support Code
 */
$.articleFeedback = {
	'tpl': {
		'ui': '\
<div class="articleFeedback-panel">\
	<div class="articleFeedback-buffer articleFeedback-ui">\
		<div class="articleFeedback-switch articleFeedback-switch-report articleFeedback-visibleWith-form" rel="report"><html:msg key="report-switch-label" /></div>\
		<div class="articleFeedback-switch articleFeedback-switch-form articleFeedback-visibleWith-report" rel="form"><html:msg key="form-switch-label" /></div>\
		<div class="articleFeedback-title articleFeedback-visibleWith-form"><html:msg key="form-panel-title" /></div>\
		<div class="articleFeedback-title articleFeedback-visibleWith-report"><html:msg key="report-panel-title" /></div>\
		<div class="articleFeedback-explanation articleFeedback-visibleWith-form"><a class="articleFeedback-explanation-link"><html:msg key="form-panel-explanation" /></a></div>\
		<div class="articleFeedback-description articleFeedback-visibleWith-report"><html:msg key="report-panel-description" /></div>\
		<div style="clear:both;"></div>\
		<div class="articleFeedback-ratings"></div>\
		<div style="clear:both;"></div>\
		<div class="articleFeedback-options">\
			<div class="articleFeedback-expertise articleFeedback-visibleWith-form" >\
				<input type="checkbox" value="general" disabled="disabled" /><label class="articleFeedback-expertise-disabled"><html:msg key="form-panel-expertise" /></label>\
				<div class="articleFeedback-expertise-options">\
					<div><input type="checkbox" value="studies" /><label><html:msg key="form-panel-expertise-studies" /></label></div>\
					<div><input type="checkbox" value="profession" /><label><html:msg key="form-panel-expertise-profession" /></label></div>\
					<div><input type="checkbox" value="hobby" /><label><html:msg key="form-panel-expertise-hobby" /></label></div>\
					<div><input type="checkbox" value="other" /><label><html:msg key="form-panel-expertise-other" /></label></div>\
					<div class="articleFeedback-helpimprove">\
						<input type="checkbox" value="helpimprove-email" />\
						<label><html:msg key="form-panel-helpimprove" /></label>\
						<input type="text" placeholder="" class="articleFeedback-helpimprove-email" />\
						<div class="articleFeedback-helpimprove-note"></div>\
					</div>\
				</div>\
			</div>\
			<div style="clear:both;"></div>\
		</div>\
		<button class="articleFeedback-submit articleFeedback-visibleWith-form" type="submit" disabled="disabled"><html:msg key="form-panel-submit" /></button>\
		<div class="articleFeedback-success articleFeedback-visibleWith-form"><span><html:msg key="form-panel-success" /></span></div>\
		<div class="articleFeedback-pending articleFeedback-visibleWith-form"><span><html:msg key="form-panel-pending" /></span></div>\
		<div style="clear:both;"></div>\
		<div class="articleFeedback-notices articleFeedback-visibleWith-form">\
			<div class="articleFeedback-expiry">\
				<div class="articleFeedback-expiry-title"><html:msg key="form-panel-expiry-title" /></div>\
				<div class="articleFeedback-expiry-message"><html:msg key="form-panel-expiry-message" /></div>\
			</div>\
		</div>\
	</div>\
	<div class="articleFeedback-error"><div class="articleFeedback-error-message"><html:msg key="error" /></div></div>\
	<div class="articleFeedback-pitches"></div>\
	<div style="clear:both;"></div>\
</div>\
<div class="articleFeedback-lock"></div>\
		',
		'rating': '\
<div class="articleFeedback-rating">\
	<div class="articleFeedback-label"></div>\
	<input type="hidden" />\
	<div class="articleFeedback-rating-labels articleFeedback-visibleWith-form">\
		<div class="articleFeedback-rating-label" rel="1"></div>\
		<div class="articleFeedback-rating-label" rel="2"></div>\
		<div class="articleFeedback-rating-label" rel="3"></div>\
		<div class="articleFeedback-rating-label" rel="4"></div>\
		<div class="articleFeedback-rating-label" rel="5"></div>\
		<div class="articleFeedback-rating-clear"></div>\
	</div>\
	<div class="articleFeedback-visibleWith-form">\
		<div class="articleFeedback-rating-tooltip"></div>\
	</div>\
	<div class="articleFeedback-rating-average articleFeedback-visibleWith-report"></div>\
	<div class="articleFeedback-rating-meter articleFeedback-visibleWith-report"><div></div></div>\
	<div class="articleFeedback-rating-count articleFeedback-visibleWith-report"></div>\
	<div style="clear:both;"></div>\
</div>\
		',
		'pitch': '\
<div class="articleFeedback-pitch">\
	<div class="articleFeedback-buffer">\
		<div class="articleFeedback-title"></div>\
		<div class="articleFeedback-pop">\
			<div class="articleFeedback-message"></div>\
			<div class="articleFeedback-body"></div>\
			<button class="articleFeedback-accept"></button>\
			<button class="articleFeedback-reject"></button>\
		</div>\
	</div>\
</div>\
		'
	},
	'fn': {
		'enableSubmission': function( state ) {
			var context = this;
			if ( state ) {
				// Reset success timeout
				clearTimeout( context.successTimeout );
				context.$ui
					// Enable
					.find( '.articleFeedback-submit' )
						.button( { 'disabled': false } )
						.end()
					// Hide success
					.find( '.articleFeedback-success span' )
						.hide()
						.end()
					// Show pending
					.find( '.articleFeedback-pending span' )
						.fadeIn( 'fast' );
			} else {
				// Disable
				context.$ui
					.find( '.articleFeedback-submit' )
						.button( { 'disabled': true } )
						.end()
					.find( '.articleFeedback-pending span' )
						.hide();
			}
		},
		'updateRating': function() {
			var $rating = $(this);
			$rating.find( '.articleFeedback-rating-label' )
				.removeClass( 'articleFeedback-rating-label-full' );
			var val = $rating.find( 'input:hidden' ).val();
			var $label = $rating.find( '.articleFeedback-rating-label[rel="' + val + '"]' );
			if ( $label.length ) {
				$label
					.prevAll( '.articleFeedback-rating-label' )
						.add( $label )
							.addClass( 'articleFeedback-rating-label-full' )
							.end()
						.end()
					.nextAll( '.articleFeedback-rating-label' )
						.removeClass( 'articleFeedback-rating-label-full' );
				$rating.find( '.articleFeedback-rating-clear' ).show();
			} else {
				$rating.find( '.articleFeedback-rating-clear' ).hide();
			}
		},
		'enableExpertise': function( $expertise ) {
			$expertise
				.find( 'input:checkbox[value=general]' )
					.attr( 'disabled', false )
					.end()
				.find( '.articleFeedback-expertise-disabled' )
					.removeClass( 'articleFeedback-expertise-disabled' );
		},
		'submit': function() {
			var context = this;
			// For anon users, keep a cookie around so we know they've rated before
			if ( mw.user.anonymous() ) {
				$.cookie( prefix( 'rated' ), 'true', { 'expires': 365, 'path': '/' } );
				// Ensure that user ratings are loaded from now on
				loadUserRatings = true;
			}
			$.articleFeedback.fn.enableSubmission.call( context, false );
			context.$ui.find( '.articleFeedback-lock' ).show();
			// Build data from form values for 'action=articlefeedback'
			var data = {};
			for ( var key in context.options.ratings ) {
				var id = context.options.ratings[key];
				data['r' + id] = context.$ui.find( 'input[name="r' + id + '"]' ).val();
			}
			var expertise = [];
			context.$ui.find( '.articleFeedback-expertise input:checked' ).each( function() {
				expertise.push( $(this).val() );
			} );
			data.expertise = expertise.join( '|' );
			$.ajax( {
				'url': mw.config.get( 'wgScriptPath' ) + '/api.php',
				'type': 'POST',
				'dataType': 'json',
				'context': context,
				'data': $.extend( data, {
					'action': 'articlefeedback',
					'format': 'json',
					'anontoken': mw.user.id(),
					'pageid': mw.config.get( 'wgArticleId' ),
					'revid': mw.config.get( 'wgCurRevisionId' ),
					'bucket': Number( showOptions )
				} ),
				'success': function( data ) {
					var context = this;
					if ( 'error' in data ) {
						mw.log( 'ArticleFeedback: Form submission error' );
						mw.log( data.error );
						context.$ui.find( '.articleFeedback-error' ).show();
					} else {
						$.articleFeedback.fn.load.call( context );
						context.$ui.find( '.articleFeedback-lock' ).hide();
					}
				},
				'error': function() {
					var context = this;
					mw.log( 'Form submission error' );
					context.$ui.find( '.articleFeedback-error' ).show();
				}
			} );
			// Build data from form values for 'action=emailcapture'
			// Ignore if email was invalid
			if ( context.$ui.find( '.articleFeedback-helpimprove-email.valid' ).length
				// Ignore if email field was empty (it's optional)
				 && !$.isEmpty( context.$ui.find( '.articleFeedback-helpimprove-email' ).val() )
				 // Ignore if checkbox was unchecked (ie. user can enter and then decide to uncheck,
				 // field fades out, then we shouldn't submit)
				 && context.$ui.find('.articleFeedback-helpimprove input:checked' ).length
			) {
				$.ajax( {
					'url': mw.config.get( 'wgScriptPath' ) + '/api.php',
					'type': 'POST',
					'dataType': 'json',
					'context': context,
					'data': {
						'email': context.$ui.find( '.articleFeedback-helpimprove-email' ).val(),
						'info': $.toJSON( {
							'ratingData': data,
							'pageTitle': mw.config.get( 'wgTitle' ),
							'pageCategories': mw.config.get( 'wgCategories' )
						} ),
						'action': 'emailcapture',
						'format': 'json'
					},
					'success': function( data ) {
						var context = this;

						if ( 'error' in data ) {
							mw.log( 'EmailCapture: Form submission error' );
							mw.log( data.error );
							updateMailValidityLabel( 'triggererror', context );

						} else {
							// Hide helpimprove-email for when user returns to Rate-view
							// without reloading page
							context.$ui.find( '.articleFeedback-helpimprove' ).hide();

							// Set cookie if it was successful, so it won't be asked again
							$.cookie(
								prefix( 'helpimprove-email' ),
								// Path must be set so it will be remembered
								// for all article (not just current level)
								// @XXX: '/' may be too wide (multi-wiki domains)
								'hide', { 'expires': 30, 'path': '/' }
							);
						}
					}
				} );
			
			// If something was invalid, reset the helpimprove-email part of the form.
			// When user returns from submit, it will be clean
			} else {
				context.$ui
					.find( '.articleFeedback-helpimprove' )
						.find( 'input:checkbox' )
							.removeAttr( 'checked' )
							.end()
						.find( '.articleFeedback-helpimprove-email' )
							.val( '' )
							.removeClass( 'valid invalid' );
			}
		},
		'executePitch': function( action ) {
			var $pitch = $(this).closest( '.articleFeedback-pitch' );
			$pitch
				.find( '.articleFeedback-accept, .articleFeedback-altAccept' )
					.button( { 'disabled': true } )
					.end()
				.find( '.articleFeedback-reject' )
					.attr( 'disabled', true );
			var key = $pitch.attr( 'rel' );
			// If a pitch's action returns true, hide the pitch and
			// re-enable the button
			if ( action.call( $(this) ) ) {
				$pitch
					.fadeOut()
					.find( '.articleFeedback-accept, .articleFeedback-altAccept' )
						.button( { 'disabled': false } )
						.end()
					.find( '.articleFeedback-reject' )
						.attr( 'disabled', false )
						.end()
					.closest( '.articleFeedback-panel' )
						.find( '.articleFeedback-ui' )
							.show();
			}
			return false;
		},
		'load': function() {
			var context = this;
			$.ajax( {
				'url': mw.config.get( 'wgScriptPath' ) + '/api.php',
				'type': 'GET',
				'dataType': 'json',
				'context': context,
				'cache': !loadUserRatings,
				'data': {
					'action': 'query',
					'format': 'json',
					'list': 'articlefeedback',
					'afpageid': mw.config.get( 'wgArticleId' ),
					'afanontoken': loadUserRatings ? mw.user.id() : '',
					'afuserrating': Number( loadUserRatings ),
					'maxage': 0,
					'smaxage': loadUserRatings ? 0 : mw.config.get( 'wgArticleFeedbackSMaxage' )
				},
				'success': function( data ) {
					var context = this;
					if (
						!( 'query' in data )
						|| !( 'articlefeedback' in data.query )
						|| !$.isArray( data.query.articlefeedback )
						|| !data.query.articlefeedback.length
					) {
						mw.log( 'ArticleFeedback invalid response error.' );
						context.$ui.find( '.articleFeedback-error' ).show();
						return;
					}
					var feedback = data.query.articlefeedback[0];
					
					// Expertise
					var $expertise = context.$ui.find( '.articleFeedback-expertise' );
					if ( typeof feedback.expertise === 'string' ) {
						var tags = feedback.expertise.split( '|' );
						if ( $.inArray( 'general', tags ) !== -1 ) {
							$expertise.find( 'input:checkbox' ).each( function() {
								$(this).attr( 'checked', $.inArray( $(this).val(), tags ) !== -1 );
							} );
							// IE7 seriously has issues, and we have to hide, then show
							$expertise.find( '.articleFeedback-expertise-options' )
								.hide().show();
							$.articleFeedback.fn.enableExpertise( $expertise );
						}
					} else {
						$expertise
							.find( 'input:checkbox' )
								.attr( 'checked', false )
								.end()
							.find( '.articleFeedback-expertise-options' )
								.hide();
					}
					
					// Help improve
					var $helpimprove = context.$ui.find( '.articleFeedback-helpimprove' );

					var showHelpimprove = true;

					if ( $.cookie( prefix( 'helpimprove-email' ) ) == 'hide'
						|| !mw.user.anonymous() ) {
						showHelpimprove = false;
					}
					
					if ( !showHelpimprove ) {
						$helpimprove.hide();
					}

					// Index rating data by rating ID
					var ratings = {};
					if ( typeof feedback.ratings === 'object' && feedback.ratings !== null ) {
						for ( var i = 0; i < feedback.ratings.length; i++ ) {
							ratings[feedback.ratings[i].ratingid] = feedback.ratings[i];
						}
					}
					
					// Ratings
					context.$ui.find( '.articleFeedback-rating' ).each( function() {
						var name = $(this).attr( 'rel' );
						var rating = name in context.options.ratings
							&& context.options.ratings[name] in ratings ?
								ratings[context.options.ratings[name]] : null;
						// Report
						if (
							rating !== null
							&& 'total' in rating
							&& 'count' in rating
							&& rating.total > 0
						) {
							var average = Math.round( ( rating.total / rating.count ) * 10 ) / 10;
							$(this)
								.find( '.articleFeedback-rating-average' )
									.text( mw.language.convertNumber( average + ( average % 1 === 0 ? '.0' : '' ) , false ) )
									.end()
								.find( '.articleFeedback-rating-meter div' )
									.css( 'width', Math.round( average * 21 ) + 'px' )
									.end()
								.find( '.articleFeedback-rating-count' )
									.text(
										mw.msg( 'articlefeedback-report-ratings', rating.countall )
									);
						} else {
							// Special case for no ratings
							$(this)
								.find( '.articleFeedback-rating-average' )
									.html( '&nbsp;' )
									.end()
								.find( '.articleFeedback-rating-meter div' )
									.css( 'width', 0 )
									.end()
								.find( '.articleFeedback-rating-count' )
									.text( mw.msg( 'articlefeedback-report-empty' ) );
						}
						// Form
						if ( rating !== null && typeof rating.userrating !== 'undefined' ) {
							$(this).find( 'input:hidden' ).val( rating.userrating );
							if ( rating.userrating > 0 ) {
								// If any ratings exist, make sure expertise is enabled so users can
								// supplement their ratings with expertise information
								$.articleFeedback.fn.enableExpertise( $expertise );
							}
						} else {
							$(this).find( 'input:hidden' ).val( 0 );
						}
						// Update rating controls based on the form data
						$.articleFeedback.fn.updateRating.call( $(this) );
					} );
					// Expiration
					if ( typeof feedback.status === 'string' && feedback.status === 'expired' ) {
						context.$ui
							.addClass( 'articleFeedback-expired' )
							.find( '.articleFeedback-expiry' )
								.slideDown( 'fast' );
					} else {
						context.$ui
							.removeClass( 'articleFeedback-expired' )
							.find( '.articleFeedback-expiry' )
								.slideUp( 'fast' );
					}
					// Status change - un-new the rating controls
					context.$ui.find( '.articleFeedback-rating-new' )
						.removeClass( 'articleFeedback-rating-new' );
				},
				'error': function() {
					var context = this;
					mw.log( 'Report loading error' );
					context.$ui.find( '.articleFeedback-error' ).show();
				}
			} );
		},
		'build': function() {
			var context = this;
			context.$ui
				.addClass( 'articleFeedback' )
				// Insert and localize HTML
				.append( $.articleFeedback.tpl.ui )
				.find( '.articleFeedback-ratings' )
					.each( function() {
						for ( var key in context.options.ratings ) {
							var	tipMsg = 'articlefeedback-field-' + key + '-tip',
								labelMsg = 'articlefeedback-field-' + key + '-label';
							$( $.articleFeedback.tpl.rating )
								.attr( 'rel', key )
								.find( '.articleFeedback-label' )
									.attr( 'title', mw.msg( tipMsg ) )
									.text( mw.msg( labelMsg ) )
									.end()
								.find( '.articleFeedback-rating-clear' )
									.attr( 'title', mw.msg( 'articlefeedback-form-panel-clear' ) )
									.end()
								.appendTo( $(this) );
						}
					} )
					.end()
				.find( '.articleFeedback-explanation-link' )
					.attr( 'href', mw.config.get( 'wgArticlePath' ).replace(
						'$1', mw.config.get( 'wgArticleFeedbackWhatsThisPage' )
					) )
					.end()
				.find( '.articleFeedback-pitches' )
					.each( function() {
						for ( var key in context.options.pitches ) {
							var $pitch = $( $.articleFeedback.tpl.pitch )
								.attr( 'rel', key )
								.find( '.articleFeedback-title' )
									.text( mw.msg( context.options.pitches[key].title ) )
									.end()
								.find( '.articleFeedback-message' )
									.text( mw.msg( context.options.pitches[key].message ) )
									.end()
								.find( '.articleFeedback-body' )
									.text( mw.msg( context.options.pitches[key].body ) )
									.end()
								.find( '.articleFeedback-accept' )
									.text( mw.msg( context.options.pitches[key].accept ) )
									.click( function() {
										var $pitch = $(this).closest( '.articleFeedback-pitch' );
										var key = $pitch.attr( 'rel' );
										return $.articleFeedback.fn.executePitch.call(
											$(this), context.options.pitches[key].action
										);
									} )
									.button()
									.addClass( 'ui-button-green' )
									.end()
								.find( '.articleFeedback-reject' )
									.text( mw.msg( context.options.pitches[key].reject ) )
									.click( function() {
										var $pitch = $(this).closest( '.articleFeedback-pitch' );
										var key = $pitch.attr( 'rel' );
										// Remember that the users rejected this, set a cookie to not
										// show this for 3 days
										$.cookie(
											prefix( 'pitch-' + key ),
											'hide',
											{ 'expires': 3, 'path': '/' }
										);
										// Track that a pitch was dismissed
										if ( tracked && typeof $.trackAction == 'function' ) {
											$.trackAction( prefix( 'pitch-' + key + '-reject' ) );
										}
										$pitch.fadeOut( 'fast', function() {
											context.$ui.find( '.articleFeedback-ui' ).show();
										} );
									} )
									.end()
									.appendTo( $(this) );
							if (
								typeof context.options.pitches[key].altAccept == 'string'
								&& typeof context.options.pitches[key].altAction == 'function'
							) {
								$pitch
									.find( '.articleFeedback-accept' )
										.after( '<button class="articleFeedback-altAccept"></button>' )
										.after(
											$( '<span class="articleFeedback-pitch-or"></span>' )
												.text( mw.msg( 'articlefeedback-pitch-or' ) )
										)
										.end()
									.find( '.articleFeedback-altAccept' )
										.text( mw.msg( context.options.pitches[key].altAccept ) )
										.click( function() {
											var $pitch = $(this).closest( '.articleFeedback-pitch' );
											var key = $pitch.attr( 'rel' );
											return $.articleFeedback.fn.executePitch.call(
												$(this), context.options.pitches[key].altAction
											);
										} )
										.button()
										.addClass( 'ui-button-green' );
							}
						}
					} )
					.end()
				.find( '.articleFeedback-helpimprove-note' )
					// Can't use .text() with mw.message(, /* $1 */ link).toString(),
					// because 'link' should not be re-escaped (which would happen if done by mw.message)
					.html( function() {
						var link = mw.html.element(
							'a', {
								href: mw.msg( 'articlefeedback-privacyurl' )
							}, mw.msg( 'articlefeedback-form-panel-helpimprove-privacy' )
						);
						return mw.html.escape( mw.msg( 'articlefeedback-form-panel-helpimprove-note' ) )
							.replace( /\$1/, link );
					})
					.end()
				.find( '.articleFeedback-helpimprove-email' )
					.attr( 'placeholder', mw.msg( 'articlefeedback-form-panel-helpimprove-email-placeholder' ) )
					.placeholder() // back. compat. for older browsers
					.one( 'blur', function() {
						var $el = $(this);
						updateMailValidityLabel( $el.val(), context );
						$el.keyup( function() {
							updateMailValidityLabel( $el.val(), context );
						} );
					} )
					.end()
				.localize( { 'prefix': 'articlefeedback-' } )
				// Activate tooltips
				.find( '[title]' )
					.tipsy( {
						'gravity': 'sw',
						'center': false,
						'fade': true,
						'delayIn': 300,
						'delayOut': 100
					} )
					.end()
				.find( '.articleFeedback-expertise > input:checkbox' )
					.change( function() {
						var $options = context.$ui.find( '.articleFeedback-expertise-options' );
						if ( $(this).is( ':checked' ) ) {
							$options.slideDown( 'fast' );
						} else {
							$options.slideUp( 'fast', function() {
								$options.find( 'input:checkbox' ).attr( 'checked', false );
							} );
						}
					} )
					.end()
				.find( '.articleFeedback-expertise input:checkbox' )
					.each( function() {
						var id = 'articleFeedback-expertise-' + $(this).attr( 'value' );
						$(this)
							.click( function() {
								$.articleFeedback.fn.enableSubmission.call( context, true );
							} )
							.attr( 'id', id )
							.next()
								.attr( 'for', id );
					} )
					.end()
				.find( '.articleFeedback-helpimprove > input:checkbox' )
					.each( function() {
						var id = 'articleFeedback-expertise-' + $(this).attr( 'value' );
						$(this)
							.attr( 'id', id )
							.next()
								.attr( 'for', id );
					})
					.end()
				.find( '.articleFeedback-helpimprove-email' )
					.bind( 'mousedown click', function( e ) {
						$(this)
							.closest( '.articleFeedback-helpimprove' )
								.find( 'input:checkbox' )
									.attr( 'checked', true );
					} )
					.end()
				// Buttonify the button
				.find( '.articleFeedback-submit' )
					.button()
					.addClass( 'ui-button-blue' )
					.click( function() {
						$.articleFeedback.fn.submit.call( context );
						var pitches = [];
						for ( var key in context.options.pitches ) {
							// Dont' bother checking the condition if there's a cookie that says
							// the user has rejected this within 3 days of right now
							var display = $.cookie( prefix( 'pitch-' + key ) );
							if ( display !== 'hide' && context.options.pitches[key].condition() ) {
								var weight = 'weight' in pitches ? pitches.weight : 1;
								for ( var i = 0; i < weight; i++ ) {
									pitches.push( key );
								}
							}
						}
						if ( pitches.length ) {
							// Select randomly using equal distribution of available pitches
							var key = pitches[Math.floor( Math.random() * pitches.length )];
							context.$ui.find( '.articleFeedback-pitches' )
								.css( 'width', context.$ui.width() )
								.find( '.articleFeedback-pitch[rel="' + key + '"]' )
									.fadeIn( 'fast' );
							context.$ui.find( '.articleFeedback-ui' ).hide();
							// Track that a pitch was presented
							if ( tracked && typeof $.trackAction == 'function' ) {
								$.trackAction( prefix( 'pitch-' + key + '-show' ) );
							}
						} else {
							// Track that a pitch was not presented
							if ( tracked && typeof $.trackAction == 'function' ) {
								$.trackAction( prefix( 'pitch-bypass' ) );
							}
							// Give user some feedback that a save occured
							context.$ui.find( '.articleFeedback-success span' ).fadeIn( 'fast' );
							context.successTimeout = setTimeout( function() {
								context.$ui.find( '.articleFeedback-success span' )
									.fadeOut( 'slow' );
							}, 5000 );
						}
					} )
					.end()
				// Hide report elements initially
				.find( '.articleFeedback-visibleWith-report' )
					.hide()
					.end()
				// Name the hidden fields
				.find( '.articleFeedback-rating' )
					.each( function() {
						$(this).find( 'input:hidden' ) .attr( 'name', 'r' + context.options.ratings[$(this).attr( 'rel' )] );
					} )
					.end()
				// Setup switch behavior
				.find( '.articleFeedback-switch' )
					.click( function( e ) {
						context.$ui
							.find( '.articleFeedback-visibleWith-' + $(this).attr( 'rel' ) )
								.show()
								.end()
							.find( '.articleFeedback-switch' )
								.not( $(this) )
								.each( function() {
									context.$ui
										.find( '.articleFeedback-visibleWith-' + $(this).attr( 'rel' ) )
										.hide();
								} );
						e.preventDefault();
						return false;
					} )
					.end()
				// Setup rating behavior
				.find( '.articleFeedback-rating-label' )
					.hover(
						function() {
							var	$el = $(this),
								$rating = $el.closest( '.articleFeedback-rating' );
							$el
								.addClass( 'articleFeedback-rating-label-hover-head' )
								.prevAll( '.articleFeedback-rating-label' )
									.addClass( 'articleFeedback-rating-label-hover-tail' );
							$rating
								.find( '.articleFeedback-rating-tooltip' )
								.text( mw.msg( 'articlefeedback-field-' + $rating.attr( 'rel' ) + '-tooltip-' + $el.attr( 'rel' ) ) )
								.show();
						},
						function() {
							var	$el = $(this),
								$rating = $el.closest( '.articleFeedback-rating' );
							$el
								.removeClass( 'articleFeedback-rating-label-hover-head' )
								.prevAll( '.articleFeedback-rating-label' )
									.removeClass( 'articleFeedback-rating-label-hover-tail' );
							$rating
								.closest( '.articleFeedback-rating' )
									.find( '.articleFeedback-rating-tooltip' )
									.hide();

							$.articleFeedback.fn.updateRating.call( $rating );
						}
					)
					.mousedown( function() {
						$.articleFeedback.fn.enableSubmission.call( context, true );
						
						if ( context.$ui.hasClass( 'articleFeedback-expired' ) ) {
							// Changing one means the rest will get submitted too
							context.$ui
								.removeClass( 'articleFeedback-expired' )
								.find( '.articleFeedback-rating' )
									.addClass( 'articleFeedback-rating-new' );
						}
						context.$ui
							.find( '.articleFeedback-expertise' )
								.each( function() {
									$.articleFeedback.fn.enableExpertise( $(this) );
								} )
								.end();
						$(this)
							.closest( '.articleFeedback-rating' )
								.addClass( 'articleFeedback-rating-new' )
								.find( 'input:hidden' )
									.val( $(this).attr( 'rel' ) )
									.end()
								.end()
							.addClass( 'articleFeedback-rating-label-down' )
							.nextAll()
								.removeClass( 'articleFeedback-rating-label-full' )
								.end()
							.parent()
								.find( '.articleFeedback-rating-clear' )
									.show();
					} )
					.mouseup( function() {
						$(this).removeClass( 'articleFeedback-rating-label-down' );
					} )
					.end()
				.find( '.articleFeedback-rating-clear' )
					.click( function() {
						$.articleFeedback.fn.enableSubmission.call( context, true );
						$(this).hide();
						var $rating = $(this).closest( '.articleFeedback-rating' );
						$rating.find( 'input:hidden' ).val( 0 );
						$.articleFeedback.fn.updateRating.call( $rating );
					} );
			// Hide/show additional options according to group
			if ( !showOptions ) {
				context.$ui.find( '.articleFeedback-options' ).hide();
			}
			if ( loadUserRatings ) {
				// Show initial form and report values when the tool is visible
				context.$ui.appear( function() {
					$.articleFeedback.fn.load.call( context );
				} );
			} else {
				context.$ui.find( '.articleFeedback-switch-report' ).one( 'click', function() {
					$.articleFeedback.fn.load.call( context );
				} );
			}
		}
	}
};

/**
 * Article Feedback jQuery Plugin
 * 
 * Can be called with an options object like...
 * 
 * 	$( ... ).articleFeedback( {
 * 		'ratings': {
 * 			'rating-name': {
 * 				'id': 1, // Numeric identifier of the rating, same as the rating_id value in the db
 * 				'label': 'msg-key-for-label', // String of message key for label
 * 				'tip': 'msg-key-for-tip', // String of message key for tip
 * 			},
 *			// More ratings here...
 * 		}
 * 	} );
 * 
 * Rating IDs need to be included in $wgArticleFeedbackRatingTypes, which is an array mapping allowed IDs to rating names.
 */
$.fn.articleFeedback = function() {
	var args = arguments;
	$(this).each( function() {
		var context = $(this).data( 'articleFeedback-context' );
		if ( !context ) {
			// Create context
			context = { '$ui': $(this), 'options': { 'ratings': {}, 'pitches': {} } };
			// Allow customization through an options argument
			if ( typeof args[0] === 'object' ) {
				context = $.extend( true, context, { 'options': args[0] } );
			}
			// Build user interface
			$.articleFeedback.fn.build.call( context );
			// Save context
			$(this).data( 'articleFeedback-context', context );
		}
	} );
	return $(this);
};

} )( jQuery );
