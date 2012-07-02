
/**
 * WARNING: SINCE SPECIAL:CONTACT IS IN FLUX B/W A NEW VERSION ON English AND THE OLD VERSION ELSEWHERE (still being translated), THIS CODE IS DUPLICATED.
 * Please refer to /extensions/wikia/SpecialContact2/SpecialContact.js for the other (canonical version) and just merge changes to this file.
 */

/**
 * If this user has javascript, they can be part of the A/B tests...
 * so we'll embed what groups they're in (and whether that's the control
 * group or not).
 */
$(function(){

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
				if(window.AB_CONFIG && (AB_CONFIG[expId] != 'undefined')){
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
