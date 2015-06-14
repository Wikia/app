/**
 * WARNING: WHILE THERE ARE TWO VERSIONS OF SPECIAL:CONTACT... THIS WILL BE THE MASTER FILE, AND THE OTHER /extensions/wikia/SpecialContact/SpecialContact.js
 * IS A COPY OF THIS FUNCTIONALITY.
 */

var SpecialContact = {
	init: function() {
		$( '#picker_grid' ).find( 'td > a' ).click( function () {
			var	trackLabel = $( this ).attr( 'class' ).substr( 23 ),
				trackUrl = $( this ).attr( 'href' );
			SpecialContact.trackClick( trackLabel, trackUrl );
		} );

		$( '#SpecialContactFooterPicker a' ).click( function (e) {
			var	trackLabel = 'footer-picker',
				trackUrl = $( this ).attr( 'href' );
			SpecialContact.trackClick( trackLabel, trackUrl, e );
		} );
		$( '#SpecialContactFooterNoForm a' ).click( function (e) {
			var	trackLabel = 'footer-noform',
				trackUrl = $( this ).attr( 'href' );
			SpecialContact.trackClick( trackLabel, trackUrl, e );
		} );
		$( '#SpecialContactIntroNoForm a' ).click( function (e) {
			var	trackLabel = 'intro-noform',
				trackUrl = $( this ).attr( 'href' );
			SpecialContact.trackClick( trackLabel, trackUrl, e );
		} );
		$( '#SpecialContactIntroForm a' ).click( function (e) {
			var	trackLabel = 'intro-form',
				trackUrl = $( this ).attr( 'href' );
			SpecialContact.trackClick( trackLabel, trackUrl, e );
		} );

		$('input[type=file]').change(function() {
			$(this).closest('p').next().show();
		});
	},

	trackClick: function ( trackLabel, trackUrl, event ) {
		Wikia.Tracker.track({
			action: Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
			category: 'specialcontact',
			label: trackLabel,
			href: trackUrl,
			trackingMethod: 'internal'
		});
	}
};

// If this user has javascript, they can be part of the A/B tests, so we'll
// embed what groups they're in (and whether that's the control group or not).
(function( window, $, undefined ) {
	var AbTest = window.Wikia.AbTest;

	if ( AbTest ) {
		var abString = '', abTests;

		abTests = AbTest.getExperiments();

		if ( abTests.length == 0 ) {
			abString = 'No active experiments.';

		} else {
			// Make a single entry for each experiment.
			$.each( abTests, function( i, exp ) {
				if ( abString != '' ) {
					abString += ', ';
				}
				abString += '[ ' + exp.name + ': ' + exp.group.name + ' ]';
			});
		}

		// Inject this debug-data into a hidden element in the form.
		$(function() {
			$( '#wpAbTesting' ).val( abString );
		});
	}
})( window, jQuery );
