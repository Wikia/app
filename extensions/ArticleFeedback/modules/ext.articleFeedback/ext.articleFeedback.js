/*
 * Script for Article Feedback Extension
 */
( function( $ ) {

// Only track users who have been assigned to the tracking group
var tracked = 'track' === mw.user.bucket(
	'ext.articleFeedback-tracking', mw.config.get( 'wgArticleFeedbackTracking' )
);

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
 * Checks if a pitch is currently muted
 * 
 * @param pitch String: Name of pitch to check
 * @return Boolean: Whether the pitch is muted
 */
function isPitchVisible( pitch ) {
	return $.cookie( prefix( 'pitches-' + pitch ) ) != 'hide';
}

/**
 * Ensures a pitch will be muted for a given duration of time
 * 
 * @param pitch String: Name of pitch to mute
 * @param durration Integer: Number of days to mute the pitch for
 */
function mutePitch( pitch, duration ) {
	$.cookie( prefix( 'pitches-' + pitch ), 'hide', { 'expires': duration, 'path': '/' } );
}

function trackClick( id ) {
	// Track the click so we can figure out how useful this is
	if ( tracked && $.isFunction( $.trackActionWithInfo ) ) {
		$.trackActionWithInfo( prefix( id ), mw.config.get( 'wgTitle' ) );
	}
}

function trackClickURL( url, id ) {
	if ( tracked && $.isFunction( $.trackActionURL ) ) {
		return $.trackActionURL( url, prefix( id ) );
	} else {
		return url;
	}
}

/**
 * Survey object
 * 
 * This object makes use of Special:SimpleSurvey, and uses some nasty hacks - this needs to be
 * replaced with something much better in the future.
 */
var survey = new ( function() {
	
	/* Private Members */
	
	var that = this;
	var $dialog;
	var $form = $( [] );
	var $message = $( [] );
	// The form is rendered by loading the raw results of a special page into a div, this is the
	// URL of that special page
	var formSource = mw.config.get( 'wgScript' ) + '?' + $.param( {
		'title': 'Special:SimpleSurvey',
		'survey': 'articlerating',
		'raw': 1
	} );
	
	/* Public Methods */
	
	this.load = function() {
		// Try to select existing dialog
		$dialog = $( '#articleFeedback-dialog' );
		// Fall-back on creating one
		if ( $dialog.length === 0 ) {
			// Create initially in loading state
			$dialog = $( '<div id="articleFeedback-dialog" class="loading" />' )
				.dialog( {
					'width': 600,
					'height': 400,
					'bgiframe': true,
					'autoOpen': true,
					'modal': true,
					'title': mw.msg( 'articlefeedback-survey-title' ),
					'close': function() {
						// Click tracking
						trackClick( 'survey-cancel' );
						// Return the survey to default state
						$dialog.dialog( 'option', 'height', 400 );
						$form.show();
						$message.remove();
					}
				} )
				.load( formSource, function() {
					$form = $dialog.find( 'form' );
					// Bypass normal form processing
					$form.submit( function() { return that.submit(); } );
					// Dirty hack - we want a fully styled button, and we can't get that from an
					// input[type=submit] control, so we just swap it out
					var $input = $form.find( 'input[type=submit]' );
					var $button = $( '<button type="submit"></button>' )
						.text( $(this).find( 'input[type=submit]' ).val() )
						.button()
						.insertAfter( $input );
					$input.remove();
					$form.find( '#prefswitch-survey-origin' ).text( mw.config.get( 'wgTitle' ) );
					
					// Insert disclaimer message
					$button.before(
						$( '<div>' )
							.addClass( 'articleFeedback-survey-disclaimer' )
							// Can't use .text() with mw.message(, /* $1 */ link).toString(),
							// because 'link' should not be re-escaped (which would happen if done by mw.message)
							.html( function() {
								var link = mw.html.element(
									'a', {
										href: mw.msg( 'articlefeedback-privacyurl' )
									}, mw.msg( 'articlefeedback-survey-disclaimerlink' )
								);
								return mw.html.escape( mw.msg( 'articlefeedback-survey-disclaimer' ) )
									.replace( /\$1/, link );
							})
					);
					
					// Take dialog out of loading state
					$dialog.removeClass( 'loading' );
				} );
		}
		$dialog.dialog( 'open' );
	};
	this.submit = function() {
		$dialog = $( '#articleFeedback-dialog' );
		// Put dialog into "loading" state
		$dialog
			.addClass( 'loading' )
			.find( 'form' )
				.hide();
		// Setup request to send information directly to a special page
		var data = {
			'title': 'Special:SimpleSurvey'
		};
		// Build request from form data
		$dialog
			.find( [
				'input[type=text]',
				'input[type=radio]:checked',
				'input[type=checkbox]:checked',
				'input[type=hidden]',
				'textarea'
			].join( ',' ) )
				.each( function() {
					var name = $(this).attr( 'name' );
					if ( name !== '' ) {
						if ( name.substr( -2 ) == '[]' ) {
							var trimmedName = name.substr( 0, name.length - 2 );
							if ( typeof data[trimmedName] == 'undefined' ) {
								data[trimmedName] = [];
							}
							data[trimmedName].push( $(this).val() );
						} else {
							data[name] = $(this).val();
						}
					}
				} );
		// Click tracking
		trackClick( 'survey-submit-attempt' );
		// XXX: Not only are we submitting to a special page instead of an API request, but we are
		// screen-scraping the result - this is evil and needs to be addressed later
		$.ajax( {
			'url': wgScript,
			'type': 'POST',
			'data': data,
			'dataType': 'html',
			'success': function( data ) {
				// Take the dialog out of "loading" state
				$dialog.removeClass( 'loading' );
				// Screen-scrape to determine success or error
				var success = $( data ).find( '.simplesurvey-success' ).size() > 0;
				// Display success/error message
				that.alert( success ? 'success' : 'error' );
				// Mute for 30 days
				mutePitch( 'survey', 30 );
				// Click tracking
				trackClick( 'survey-submit-complete' );
			},
			'error': function( XMLHttpRequest, textStatus, errorThrown ) {
				// Take the dialog out of "loading" state
				$dialog.removeClass( 'loading' );
				// Display error message
				that.alert( 'error' );
			}
		} );
		// Do not continue with normal form processing
		return false;
	};
	this.alert = function( message ) {
		$message = $( '<div />' )
			.addClass( 'articleFeedback-survey-message-' + message )
			.text( mw.msg( 'articlefeedback-survey-message-' + message ) )
			.appendTo( $dialog );
		$dialog.dialog( 'option', 'height', $message.height() + 100 );
	};
} )();

var config = {
	'ratings': mw.config.get( 'wgArticleFeedbackRatingTypesFlipped' ),
	'pitches': {
		'survey': {
			'weight': 1,
			'condition': function() {
				return isPitchVisible( 'survey' );
			},
			'action': function() {
				survey.load();
				// Click tracking
				trackClick( 'pitch-survey-accept' );
				// Hide the pitch immediately
				return true;
			},
			'title': 'articlefeedback-pitch-thanks',
			'message': 'articlefeedback-pitch-survey-message',
			'body': 'articlefeedback-pitch-survey-body',
			'accept': 'articlefeedback-pitch-survey-accept',
			'reject': 'articlefeedback-pitch-reject'
		},
		'join': {
			'weight': 1,
			'condition': function() {
				return isPitchVisible( 'join' ) && mw.user.anonymous();
			},
			'action': function() {
				// Mute for 1 day
				mutePitch( 'join', 1 );
				// Go to account creation page
				// Track the click through an API redirect
				window.location = trackClickURL(
					mw.config.get( 'wgScript' ) + '?' + $.param( {
						'title': 'Special:UserLogin',
						'type': 'signup',
						'returnto': mw.config.get( 'wgPageName' )
					} ), 'pitch-join-accept-signup' );
				return false;
			},
			'title': 'articlefeedback-pitch-thanks',
			'message': 'articlefeedback-pitch-join-message',
			'body': 'articlefeedback-pitch-join-body',
			'accept': 'articlefeedback-pitch-join-accept',
			'reject': 'articlefeedback-pitch-reject',
			// Special alternative action for going to login page
			'altAccept': 'articlefeedback-pitch-join-login',
			'altAction': function() {
				// Mute for 1 day
				mutePitch( 'join', 1 );
				// Go to login page
				// Track the click through an API redirect
				window.location = trackClickURL(
					mw.config.get( 'wgScript' ) + '?' + $.param( {
						'title': 'Special:UserLogin',
						'returnto': mw.config.get( 'wgPageName' )
					} ), 'pitch-join-accept-login' );
				return false;
			}
		},
		'edit': {
			'weight': 2,
			'condition': function() {
				// An empty restrictions array means anyone can edit
				var restrictions =  mw.config.get( 'wgRestrictionEdit', [] );
				if ( restrictions.length ) {
					var groups =  mw.config.get( 'wgUserGroups' );
					// Verify that each restriction exists in the user's groups
					for ( var i = 0; i < restrictions.length; i++ ) {
						if ( $.inArray( restrictions[i], groups ) < 0 ) {
							return false;
						}
					}
				}
				return isPitchVisible( 'edit' );
			},
			'action': function() {
				// Mute for 7 days
				mutePitch( 'edit', 7 );
				// Setup edit page link
				var params = {
					'title': mw.config.get( 'wgPageName' ),
					'action': 'edit'
				};
				if ( tracked ) {
					// Keep track of tracked users' edits
					params.clicktrackingsession = $.cookie( 'clicktracking-session' );
					params.clicktrackingevent = prefix( 'pitch-edit-save' );
				}
				// Track the click through an API redirect (automatically bypasses if !tracked)
				window.location = trackClickURL(
					mw.config.get( 'wgScript' ) + '?' + $.param( params ), 'pitch-edit-accept'
				);
				return false;
			},
			'title': 'articlefeedback-pitch-thanks',
			'message': 'articlefeedback-pitch-edit-message',
			'body': 'articlefeedback-pitch-edit-body',
			'accept': 'articlefeedback-pitch-edit-accept',
			'reject': 'articlefeedback-pitch-reject'
		}
	}
};

/* Load at the bottom of the article */
var $aftDiv = $( '<div id="mw-articlefeedback"></div>' ).articleFeedback( config );

// Put on bottom of article before #catlinks (if it exists)
// Except in legacy skins, which have #catlinks above the article but inside content-div.
var legacyskins = [ 'standard', 'cologneblue', 'nostalgia' ];
if ( $( '#catlinks' ).length && $.inArray( mw.config.get( 'skin' ), legacyskins ) < 0 ) {
	$aftDiv.insertBefore( '#catlinks' );
} else {
	// CologneBlue, Nostalgia, ...
	mw.util.$content.append( $aftDiv );
}

/* Add link so users can navigate to the feedback tool from the toolbox */
var $tbAft = $( '<li id="t-articlefeedback"><a href="#mw-articlefeedback"></a></li>' )
	.find( 'a' )
		.text( mw.msg( 'articlefeedback-form-switch-label' ) )
		.click( function() {
			// Click tracking
			trackClick( 'toolbox-link' );
			// Get the image, set the count and an interval.
			var $box = $( '#mw-articlefeedback' );
			var count = 0;
			var interval = setInterval( function() {
				// Animate the opacity over .2 seconds
				$box.animate( { 'opacity': 0.5 }, 100, function() {
					// When finished, animate it back to solid.
					$box.animate( { 'opacity': 1.0 }, 100 );
				} );
				// Clear the interval once we've reached 3.
				if ( ++count >= 3 ) {
					clearInterval( interval );
				}
			}, 200 );
			return true;
		} )
		.end();
$( '#p-tb' ).find( 'ul' ).append( $tbAft );

} )( jQuery );
