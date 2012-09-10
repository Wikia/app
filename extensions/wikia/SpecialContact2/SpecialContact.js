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

$(function() {
	SpecialContact.init();

	/**
	 * If this user has javascript, they can be part of the A/B tests...
	 * so we'll embed what groups they're in (and whether that's the control
	 * group or not).
	 *
	 * WARNING: WHILE THERE ARE TWO VERSIONS OF SPECIAL:CONTACT... THIS WILL BE THE MASTER FILE, AND THE OTHER /extensions/wikia/SpecialContact/SpecialContact.js
	 * IS A COPY OF THIS FUNCTIONALITY.
	 */

	// Have to iterate through all of the experiments to see how the user would be treated with them (because the values
	// don't get computed and stored in abTreatments unless getTreatmentGroup() is called on that particular experiment -
	// and many experiments may not run right on the Special:Contact page before this code executes).
	if(window.AB_CONFIG){
		for(var expId in AB_CONFIG){
			if(AB_CONFIG.hasOwnProperty(expId)){
				// Cause the treatment-group to be cached in abTreatments array.
				window.getTreatmentGroup && getTreatmentGroup(expId);
			}
		}
	}

	// We only have info if abTreatments is defined.
	if(window.abTreatments){
		var abString = '';

		if(Object.keys(abTreatments).length == 0){
			abString = 'No active experiments.';
		} else {
			// Make a single entry for each experiment.
			for(var expId in abTreatments){
				var tgId = abTreatments[expId];
				if(window.AB_CONFIG && (typeof AB_CONFIG[expId] != 'undefined')){
					var config = AB_CONFIG[expId];
					
					abString += ((abString == '') ? '' : ', ');
					abString += '[';

					// Info about experiment.
					abString += config.name + ' (id:' + expId + '): ';
					
					// Info about the treatment-group the user was in for that experiment.
					if(typeof config.groups[tgId] != 'undefined'){
						var groupConfig = config.groups[tgId];
						abString +=  groupConfig.name;
						if(groupConfig.is_control){
							abString += " (control group)";
						}
					} else {
						abString += 'UNKNOWN GROUP (this is weird) (treatment-group id: ' + tgId + ')';
					}

					abString += ']';
				}
			}
		}

		// Inject this debug-data into a hidden element in the form.
		$('#wpAbTesting').val( abString );
	}
});
