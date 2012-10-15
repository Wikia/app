/**
 * WARNING: SINCE SPECIAL:CONTACT IS IN FLUX B/W A NEW VERSION ON English AND THE OLD VERSION ELSEWHERE (still being translated), THIS CODE IS DUPLICATED.
 * Please refer to /extensions/wikia/SpecialContact2/SpecialContact.js for the other (canonical version) and just merge changes to this file.
 */

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