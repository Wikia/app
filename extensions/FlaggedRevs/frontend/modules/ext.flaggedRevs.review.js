/**
 * FlaggedRevs Stylesheet
 * @author Aaron Schulz
 * @author Daniel Arnold 2008
 */
( function( $ ) {

var fr = {
	/* User is reviewing this page? */
	'isUserReviewing': 0,

	/* Startup function */
	'init': function() {
		var form = $( '#mw-fr-reviewform' );

		// Enable AJAX-based submit functionality to the review form on this page
		$( '#mw-fr-submit-accept,#mw-fr-submit-unaccept' ).click( function( e ) {
			fr.submitRevisionReview( this, form );
			return false; // don't do normal non-AJAX submit
		} );

		// Disable 'accept' button if the revision was already reviewed.
		// This is used so that they can be re-enabled if a rating changes.
		if ( typeof( jsReviewNeedsChange ) != 'undefined' && jsReviewNeedsChange === 1 ) {
			$( 'mw-fr-submit-accept' ).prop( 'disabled', 'disabled' );
		}

		// Setup <select> form option colors
		fr.updateReviewFormColors( form );
		// Update review form on change
		form.find( 'input,select' ).change( function( e ) {
			fr.updateReviewForm( form );
		} );

		// Display "advertise" notice
		fr.enableAjaxReviewActivity();
		// "De-advertise" user as "no longer reviewing" on navigate-away
		$( window ).unload( function( e ) {
			if ( fr.isUserReviewing === 1 ) {
				fr.deadvertiseReviewing();
			}
		} );
	},

	/*
	 * Updates for radios/checkboxes on patch by Daniel Arnold (bug 13744).
	 * Visually update the revision rating form on change.
	 * - Disable submit in case of invalid input.
	 * - Update colors when <select> changes.
	 * - Also remove comment box clutter in case of invalid input.
	 * NOTE: all buttons should exist (perhaps hidden though)
	 */
	'updateReviewForm': function( form ) {
		if ( form.prop( 'disabled' ) ) {
			return;
		}

		var quality = true;
		var somezero = false;
		// Determine if this is a "quality" or "incomplete" review
		for ( var tag in wgFlaggedRevsParams.tags ) {
			// Get the element or elements for selecting the tag level.
			// We might get back a select, a checkbox, or *several* radios.
			var tagLevelSelects = form.find( "[name='wp" + tag + "']" );
			if ( !tagLevelSelects.length ) {
				continue; // none found; binary flagging?
			}
			var tagLevelSelect = tagLevelSelects.eq( 0 ); // convenient for select and checkbox

			var selectedlevel = 0; // default
			if ( tagLevelSelect.prop( 'nodeName' ) === 'SELECT' ) {
				selectedlevel = tagLevelSelect.prop( 'selectedIndex' );
			} else if ( tagLevelSelect.prop( 'type' ) == 'checkbox' ) {
				selectedlevel = tagLevelSelect.prop( 'checked' ) ? 1 : 0;
			} else if ( tagLevelSelect.prop( 'type' ) === 'radio' ) {
				// Go through each radio option and find the selected one...
				for ( var i = 0; i < tagLevelSelects.length; i++ ) {
					if ( tagLevelSelects.eq( i ).prop( 'checked' ) ) {
						selectedlevel = i;
						break;
					}
				}
			} else {
				return; // error: should not happen
			}

			// Get quality level for this tag
			var qualityLevel = wgFlaggedRevsParams.tags[tag]['quality'];
			if ( selectedlevel < qualityLevel ) {
				quality = false; // not a quality review
			}
			if ( selectedlevel <= 0 ) {
				somezero = true;
			}
		}

		// (a) If only a few levels are zero ("incomplete") then disable submission.
		// (b) Re-enable submission for already accepted revs when ratings change.
		$( '#mw-fr-submit-accept' )
			.prop( 'disabled', somezero ? 'disabled' : '' )
			.val( mw.msg( 'revreview-submit-review' ) ); // reset to "Accept"

		// Update colors of <select>
		fr.updateReviewFormColors( form );
	},

	/*
	 * Update <select> color for the selected item/option
	 */
	'updateReviewFormColors': function( form ) {
		for ( var tag in wgFlaggedRevsParams.tags ) { // for each tag
			var select = form.find( "[name='wp" + tag + "']" ).eq( 0 );
			// Look for a selector for this tag
			if ( select.length && select.prop( 'nodeName' ) == 'SELECT' ) {
				var selectedlevel = select.prop( 'selectedIndex' );
				var value = select.children( 'option' ).eq( selectedlevel ).val();
				select.prop( 'className', 'fr-rating-option-' + value );
				// Fix FF one-time jitter bug of changing an <option>
				select.prop( 'selectedIndex', null );
				select.prop( 'selectedIndex', selectedlevel );
			}
		}
	},

	/*
	 * Lock review form from submissions (using during AJAX requests)
	 */
	'lockReviewForm': function( form ) {
		form.find( 'input,textarea,select' ).prop( 'disabled', 'disabled' );
	},

	/*
	 * Unlock review form from submissions (using after AJAX requests)
	 */  
	'unlockReviewForm': function( form ) {
		var inputs = form.find( 'input' );
		for ( var i=0; i < inputs.length; i++ ) {
			if ( inputs.eq( i ).prop( 'type' ) !== 'submit' ) { // not all buttons can be enabled
				inputs.eq( i ).prop( 'disabled', '' );
			} else {
				inputs.eq( i ).blur(); // focus off element (bug 24013)
			}
		}
		form.find( 'textarea,select' ).prop( 'disabled', '' );
	},

	/*
	 * Submit a revision review via AJAX and update form elements.
	*
	 * Note: requestArgs build-up from radios/checkboxes
	 * based on patch by Daniel Arnold (bug 13744)
	 */
	'submitRevisionReview': function( button, form ) {
		fr.lockReviewForm( form ); // disallow submissions
		// Build up arguments array and update submit button text...
		var requestArgs = []; // array of strings of the format <"pname|pval">.
		var inputs = form.find( 'input' );
		for ( var i=0; i < inputs.length; i++ ) {
			var input = inputs.eq( i );
			// Different input types may occur depending on tags...
			if ( input.prop( 'name' ) === "title" || input.prop( 'name' ) === "action" ) {
				continue; // No need to send these...
			} else if ( input.prop( 'type' ) === "submit" ) {
				if ( input.prop( 'id' ) === button.id ) {
					requestArgs.push( input.prop( 'name' ) + "|1" );
					// Show that we are submitting via this button
					input.val( mw.msg( 'revreview-submitting' ) );
				}
			} else if ( input.prop( 'type' ) === "checkbox" ) {
				requestArgs.push( input.prop( 'name' ) + "|" + // must send a number
					( input.prop( 'checked' ) ? input.val() : 0 ) );
			} else if ( input.prop( 'type' ) === "radio" ) {
				if ( input.prop( 'checked' ) ) { // must be checked
					requestArgs.push( input.prop( 'name' ) + "|" + input.val() );
				}
			} else {
				requestArgs.push( input.prop( 'name' ) + "|" + input.val() ); // text/hiddens...
			}
		}
		var selects = form.find( 'select' );
		for ( var i=0; i < selects.length; i++ ) {
			var select = selects.eq( i );
			// Get the selected tag level...
			if ( select.prop( 'selectedIndex' ) >= 0 ) {
				var soption = select.find( 'option' ).eq( select.prop( 'selectedIndex' ) );
				requestArgs.push( select.prop( 'name' ) + "|" + soption.val() );
			}
		}
		// Send encoded function plus all arguments...
		var post_data = 'action=ajax&rs=RevisionReview::AjaxReview';
		for ( var i=0; i < requestArgs.length; i++ ) {
			post_data += '&rsargs[]=' + encodeURIComponent( requestArgs[i] );
		}
		// Send POST request via AJAX!
		var call = $.ajax({
			url      : mw.util.wikiScript( 'index' ),
			type     : "POST",
			data     : post_data,
			dataType : "html", // response type
			success  : function( response ) {
				fr.postSubmitRevisionReview( form, response );
			},
			error    : function( response ) {
				fr.unlockReviewForm( form );
			}
		});
	},
	
	/*
	 * Update form elements after AJAX review.
	 */
	'postSubmitRevisionReview': function( form, response ) {
		var msg = response.substr(6); // remove <err#> or <suc#>
		// Read new "last change time" timestamp for conflict handling
		// @TODO: pass last-chage-time data using JSON or something not retarded
		var m = msg.match(/^<lct#(\d*)>(.*)/m);
		if ( m ) msg = m[2]; // remove tag from msg
		var changeTime = m ? m[1] : null; // MW TS

		// Review form elements
		var asubmit = $( '#mw-fr-submit-accept' ); // ACCEPT
		var usubmit = $( '#mw-fr-submit-unaccept' ); // UNACCEPT
		var rsubmit = $( '#mw-fr-submit-reject' ); // REJECT
		var diffNotice = $( '#mw-fr-difftostable' );
		// FlaggedRevs rating box
		var tagBox = $( '#mw-fr-revisiontag' );
		// Diff parameters
		var diffUIParams = $( '#mw-fr-diff-dataform' );

		// On success...
		if ( response.indexOf('<suc#>') === 0 ) {
			// (a) Update document title and form buttons...
			if ( asubmit.length && usubmit.length ) {
				// Revision was flagged
				if ( asubmit.val() === mw.msg( 'revreview-submitting' ) ) {
					asubmit.val( mw.msg( 'revreview-submit-reviewed' ) ); // done!
					asubmit.css( 'fontWeight', 'bold' );
					// Unlock and reset *unflag* button
					usubmit.val( mw.msg( 'revreview-submit-unreview' ) );
					usubmit.css( 'fontWeight', '' ); // back to normal
					usubmit.show(); // now available
					usubmit.prop( 'disabled', '' ); // unlock
					rsubmit.prop( 'disabled', 'disabled' ); // lock if present
				// Revision was unflagged
				} else if ( usubmit.val() === mw.msg( 'revreview-submitting' ) ) {
					usubmit.val( mw.msg( 'revreview-submit-unreviewed' ) ); // done!
					usubmit.css( 'fontWeight', 'bold' );
					// Unlock and reset *flag* button
					asubmit.val( mw.msg( 'revreview-submit-review' ) );
					asubmit.css( 'fontWeight', '' ); // back to normal
					asubmit.prop( 'disabled', '' ); // unlock
					rsubmit.prop( 'disabled', '' ); // unlock if present
				}
			}
			// (b) Remove review tag from drafts
			tagBox.css( 'display', 'none' );
			// (c) Update diff-related items...
			if ( diffUIParams.length ) {
				// Hide "review this" box on diffs
				diffNotice.hide();
				// Update the contents of the mw-fr-diff-headeritems div
				var requestArgs = []; // <oldid, newid>
				requestArgs.push( diffUIParams.find( 'input' ).eq( 0 ).val() );
				requestArgs.push( diffUIParams.find( 'input' ).eq( 1 ).val() );
				// Send encoded function plus all arguments...
				var url_pars = '?action=ajax&rs=FlaggablePageView::AjaxBuildDiffHeaderItems';
				for ( var i=0; i < requestArgs.length; i++ ) {
					url_pars += '&rsargs[]=' + encodeURIComponent( requestArgs[i] );
				}
				// Send GET request via AJAX!
				var call = $.ajax({
					url      : mw.util.wikiScript( 'index' ) + url_pars,
					type     : "GET",
					dataType : "html", // response type
					success  : function( response ) {
						// Update the contents of the mw-fr-diff-headeritems div
						$( '#mw-fr-diff-headeritems' ).html( response );
					}
				});
			}
		// On failure...
		} else {
			// (a) Update document title and form buttons...
			if ( asubmit.length && usubmit.length ) {
				// Revision was flagged
				if ( asubmit.val() === mw.msg( 'revreview-submitting' ) ) {
					asubmit.val( mw.msg( 'revreview-submit-review' ) ); // back to normal
					asubmit.prop( 'disabled', '' ); // unlock
				// Revision was unflagged
				} else if ( usubmit.val() === mw.msg( 'revreview-submitting' ) ) {
					usubmit.val( mw.msg( 'revreview-submit-unreview' ) ); // back to normal
					usubmit.prop( 'disabled', '' ); // unlock
				}
			}
			// (b) Output any error response message
			if ( response.indexOf('<err#>') === 0 ) {
				mediaWiki.util.jsMessage( msg, 'review' ); // failure notice
			} else {
				mediaWiki.util.jsMessage( response, 'review' ); // fatal notice
			}
			window.scroll( 0, 0 ); // scroll up to notice
		}
		// Update changetime for conflict handling
		if ( changeTime != null ) {
			$( '#mw-fr-input-changetime' ).val( changeTime );
		}
		fr.unlockReviewForm( form );
	},

	/*
	 * Enable AJAX-based functionality to set that a user is reviewing a page/diff
	 */
	'enableAjaxReviewActivity': function() {
		// User is already reviewing in another tab...
		if ( $('#mw-fr-user-reviewing').val() === 1 ) {
			fr.isUserReviewing = 1;
			fr.advertiseReviewing( null, true );
		// User is not already reviewing this....
		} else {
			fr.deadvertiseReviewing( null, true );
		}
		$('#mw-fr-reviewing-status').show();
	},
	
	/*
	 * Flag users as "now reviewing"
	 */
	'advertiseReviewing': function( e, isInitial ) {
		if ( isInitial !== true ) { // don't send if just setting up form
			if ( !fr.setReviewingStatus( 1 ) ) {
				return; // failed
			}
		}
		// Build notice to say that user is advertising...
		var msgkey = $('#mw-fr-input-refid').length
			? 'revreview-adv-reviewing-c' // diff
			: 'revreview-adv-reviewing-p'; // page
		var $underReview = $(
			'<span class="fr-under-review">' + mw.message( msgkey ).escaped() + '</span>' );
		// Update notice to say that user is advertising...
		$('#mw-fr-reviewing-status')
			.empty()
			.append( $underReview )
			.append( ' ('  + mw.html.element( 'a',
				{ id: 'mw-fr-reviewing-stop' }, mw.msg( 'revreview-adv-stop-link' ) ) + ')' )
			.find( '#mw-fr-reviewing-stop')
			.css( 'cursor', 'pointer' )
			.click( fr.deadvertiseReviewing );
	},
	
	/*
	 * Flag users as "no longer reviewing"
	 */
	'deadvertiseReviewing': function( e, isInitial ) {
		if ( isInitial !== true ) { // don't send if just setting up form
			if ( !fr.setReviewingStatus( 0 ) ) {
				return; // failed
			}
		}
		// Build notice to say that user is not advertising...
		var msgkey = $('#mw-fr-input-refid').length
			? 'revreview-sadv-reviewing-c' // diff
			: 'revreview-sadv-reviewing-p'; // page
		var $underReview = $(
			'<span class="fr-make-under-review">' +
			mw.message( msgkey )
				.escaped()
				.replace( /\$1/, mw.html.element( 'a',
					{ id: 'mw-fr-reviewing-start' }, mw.msg( 'revreview-adv-start-link' ) ) ) +
			'</span>'
		);
		$underReview.find( '#mw-fr-reviewing-start')
			.css( 'cursor', 'pointer' )
			.click( fr.advertiseReviewing );
		// Update notice to say that user is not advertising...
		$('#mw-fr-reviewing-status').empty().append( $underReview );
	},
	
	/*
	 * Set reviewing status for this page/diff
	 */
	'setReviewingStatus': function( value ) {
		var res = false;
		// Get {previd,oldid} array for this page view.
		// The previd value will be 0 if this is not a diff view.
		var oRevId = $('#mw-fr-input-refid') ? $('#mw-fr-input-refid').val() : 0;
		var nRevId = $('#mw-fr-input-oldid') ? $('#mw-fr-input-oldid').val() : 0;
		if ( nRevId > 0 ) {
			// Send GET request via AJAX!
			var call = $.ajax({
				url     : mw.util.wikiScript( 'api' ),
				data    : {
					action    : 'reviewactivity',
					previd    : oRevId,
					oldid     : nRevId,
					reviewing : value,
					token     : mw.user.tokens.get('editToken'),
					format    : 'json'
				},
				type     : "POST",
				dataType : "json", // response type
				timeout  : 1700, // don't delay user exiting
				success  : function( data ) { res = data; },
				async    : false
			});
			if ( res && res.reviewactivity && res.reviewactivity.result === "Success" ) {
				fr.isUserReviewing = value;
				return true;
			}
		}
		return false;
	}
};

// Perform some onload (which is when this script is included) events:
fr.init();

})( jQuery );
