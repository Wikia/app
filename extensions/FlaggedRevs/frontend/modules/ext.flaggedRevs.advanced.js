/**
 * FlaggedRevs Stylesheet
 * @author Aaron Schulz
 * @author Krinkle <krinklemail@gmail.com> 2011
 */
( function( $ ) {

var fr = {
	/* Dropdown collapse timer */
	'boxCollapseTimer': null,

	/* Startup function */
	'init': function() {
		// Enables rating detail box
		var toggle = $( '#mw-fr-revisiontoggle' );

		if ( toggle.length ) {
			toggle.css( 'display', 'inline' ); // show toggle control
			fr.hideBoxDetails(); // hide the initially displayed ratings
		}

		// Bar UI: Toggle the box when the toggle is clicked
		$( '.fr-toggle-symbol#mw-fr-revisiontoggle' ).click( fr.toggleBoxDetails );

		// Simple UI: Show the box on mouseOver
		$( '.fr-toggle-arrow#mw-fr-revisiontoggle' ).mouseover( fr.onBoxMouseOver );
		$( '.flaggedrevs_short#mw-fr-revisiontag' ).mouseout( fr.onBoxMouseOut );

		// Enables diff detail box and toggle
		toggle = $( '#mw-fr-difftoggle' );
		if ( toggle.length ) {
			toggle.css( 'display', 'inline' ); // show toggle control
			$( '#mw-fr-stablediff' ).hide();
		}
		toggle.children( 'a' ).click( fr.toggleDiff );

		// Enables log detail box and toggle
		toggle = $( '#mw-fr-logtoggle' );
		if ( toggle.length ) {
			toggle.css( 'display', 'inline' ); // show toggle control
			$( '#mw-fr-logexcerpt' ).hide();
		}
		toggle.children( 'a' ).click( fr.toggleLog );

		// Enables changing of save button when "review this" checkbox changes
		$( '#wpReviewEdit' ).click( fr.updateSaveButton );
	},

	/* Expands flag info box details */
	'showBoxDetails': function() {
		$( '#mw-fr-revisiondetails' ).css( 'display', 'block' );
	},

	/* Collapses flag info box details */
	'hideBoxDetails': function() {
		$( '#mw-fr-revisiondetails' ).css( 'display', 'none' );
	},

	/**
	 * Toggles flag info box details for (+/-) control
	 * @context {jQuery}
	 * @param e {jQuery.Event}
	 */
	'toggleBoxDetails': function( e ) {
		var	toggle = $( '#mw-fr-revisiontoggle' ),
			ratings = $( '#mw-fr-revisiondetails' );

		if ( toggle.length && ratings.length ) {
			// Collapsed -> expand
			if ( ratings.css( 'display' ) === 'none' ) {
				fr.showBoxDetails();
				toggle.text( mw.msg( 'revreview-toggle-hide' ) );
			// Expanded -> collapse
			} else {
				fr.hideBoxDetails();
				toggle.text( mw.msg( 'revreview-toggle-show' ) );
			}
		}
	},

	/**
	 * Expands flag info box details on mouseOver
	 * @context {jQuery}
	 * @param e {jQuery.Event}
	 */
	'onBoxMouseOver': function( e ) {
		window.clearTimeout( fr.boxCollapseTimer );
		fr.boxCollapseTimer = null;
		fr.showBoxDetails();
	},

	/**
	 * Hides flag info box details on mouseOut *except* for event bubbling
	 * @context {jQuery}
	 * @param e {jQuery.Event}
	 */
	'onBoxMouseOut': function( e ) {
		if ( !fr.isMouseOutBubble( e, 'mw-fr-revisiontag' ) ) {
			fr.boxCollapseTimer = window.setTimeout( fr.hideBoxDetails, 150 );
		}
	},

	/**
	 * Checks if mouseOut event is for a child of parentId
	 * @param e {jQuery.Event}
	 * @param parentId {String}
	 * @return {Boolean} True if given event object originated from a (direct or indirect)
	 * child element of an element with an id of parentId.
	 */
	'isMouseOutBubble': function( e, parentId ) {
		var toNode = e.relatedTarget;

		if ( toNode ) {
			var nextParent = toNode.parentNode;
			while ( nextParent ) {
				if ( nextParent.id === parentId ) {
					return true;
				}
				// next up
				nextParent = nextParent.parentNode;
			}
		}
		return false;
	},

	/**
	 * Toggles diffs
	 * @context {jQuery}
	 * @param e {jQuery.Event}
	 */
	'toggleDiff': function( e ) {
		var	diff = $( '#mw-fr-stablediff' ),
			toggle = $( '#mw-fr-difftoggle' );

		if ( diff.length && toggle.length ) {
			if ( diff.css( 'display' ) === 'none' ) {
				diff.show( 'slow' );
				toggle.children( 'a' ).text( mw.msg( 'revreview-diff-toggle-hide' ) );
			} else {
				diff.hide( 'slow' );
				toggle.children( 'a' ).text( mw.msg( 'revreview-diff-toggle-show' ) );
			}
		}
	},

	/**
	 * Toggles log excerpts
	 * @context {jQuery}
	 * @param e {jQuery.Event}
	 */
	'toggleLog': function( e ) {
		var	hideMsg, showMsg,
			log = $( '#mw-fr-logexcerpt' ),
			toggle = $( '#mw-fr-logtoggle' );

		if ( log.length && toggle.length ) {
			// Two different message sets used here...
			if ( toggle.hasClass( 'fr-logtoggle-details' ) ) {
				hideMsg = mw.msg( 'revreview-log-details-hide' );
				showMsg = mw.msg( 'revreview-log-details-show' );
			} else {
				hideMsg = mw.msg( 'revreview-log-toggle-hide' );
				showMsg = mw.msg( 'revreview-log-toggle-show' );
			}

			if ( log.css( 'display' ) === 'none' ) {
				log.show();
				toggle.children( 'a' ).text( hideMsg );
			} else {
				log.hide();
				toggle.children( 'a' ).text( showMsg );
			}
		}
	},

	/**
	 * Update save button when "review this" checkbox changes
	 * @context {jQuery}
	 * @param e {jQuery.Event}
	 */
	'updateSaveButton': function() {
		var	$save = $( '#wpSave' ),
			$checkbox = $( '#wpReviewEdit' );

		if ( $save.length && $checkbox.length ) {
			// Review pending changes
			if ( $checkbox.prop( 'checked' ) ) {
				$save
					.val( mw.msg( 'savearticle' ) )
					.attr( 'title',
						mw.msg( 'tooltip-save' ) + ' [' + mw.msg( 'accesskey-save' ) + ']'
					);
			// Submit for review
			} else {
				$save
					.val( mw.msg( 'revreview-submitedit' ) )
					.attr( 'title',
						mw.msg( 'revreview-submitedit-title' ) + ' [' + mw.msg( 'accesskey-save' ) + ']'
					);
			}
		}
		mw.util.updateTooltipAccessKeys( [ $save ] ); // update accesskey in save.title
	}
};

// Perform some onload (which is when this script is included) events:
fr.init();

})( jQuery );
