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

		$( '#SpecialContactFooterPicker a' ).click( function () {
			var	trackLabel = 'footer-picker',
				trackUrl = $( this ).attr( 'href' );
			SpecialContact.trackClick( trackLabel, trackUrl );
		} );
		$( '#SpecialContactFooterNoForm a' ).click( function () {
			var	trackLabel = 'footer-noform',
				trackUrl = $( this ).attr( 'href' );
			SpecialContact.trackClick( trackLabel, trackUrl );
		} );
		$( '#SpecialContactIntroNoForm a' ).click( function () {
			var	trackLabel = 'intro-noform',
				trackUrl = $( this ).attr( 'href' );
			SpecialContact.trackClick( trackLabel, trackUrl );
		} );
		$( '#SpecialContactIntroForm a' ).click( function () {
			var	trackLabel = 'intro-form',
				trackUrl = $( this ).attr( 'href' );
			SpecialContact.trackClick( trackLabel, trackUrl );
		} );

		$('input[type=file]').change(function() {
			$(this).closest('p').next().show();
		});
	},

	trackClick: function ( trackLabel, trackUrl ) {
		var trackObj = {
			ga_category: 'specialcontact',
			ga_action: WikiaTracker.ACTIONS.CLICK_LINK_TEXT,
			ga_label: trackLabel,
			href: trackUrl
		};
		WikiaTracker.trackEvent(
			'trackingevent',
			trackObj,
			'internal'
		);
	}
};

// If this user has javascript, they can be part of the A/B tests, so we'll
// embed what groups they're in (and whether that's the control group or not).
(function( window, $, undefined ) {
	var AbTest = window.Wikia.AbTest;

	if ( AbTest ) {
		var abString = '';

		if ( !AbTest.experimentCount ) {
			abString = 'No active experiments.';

		} else {
			var experiment, treatmentGroup,
				experiments = AbTest.experiments;

			// Make a single entry for each experiment.
			$.each( AbTest.getTreatmentGroups(), function( experimentId, treatmentGroupId ) {
				experiment = experiments[ experimentId ];
				treatmentGroup = experiment.treatmentGroups[ treatmentGroupId ];

				abString += ( abString == '' ? '[ ' : ', [ ' ) + experiment.name + ': ';

				if ( treatmentGroup !== undefined ) {
					abString += treatmentGroup.name + ( treatmentGroup.isControl ? ' (control group)' : '' );

				} else {
					abString += 'UNKNOWN GROUP (treatment-group id: ' + treatmentGroupId + ')';
				}

				abString += ' ]';
			});
		}

		// Inject this debug-data into a hidden element in the form.
		$(function() {
			$( '#wpAbTesting' ).val( abString );
		});
	}
})( window, jQuery );