var SpecialContact = {
	init: function() {
		$('.specialcontact-seclink-content-issue').trackClick('wiki/SpecialContact/content-issue');
		$('.specialcontact-seclink-user-conflict').trackClick('wiki/SpecialContact/user-conflict');
		$('.specialcontact-seclink-adoption').trackClick('wiki/SpecialContact/adoption');
		$('.specialcontact-seclink-account-issue').trackClick('wiki/SpecialContact/account-issue');
		$('.specialcontact-seclink-close-account').trackClick('wiki/SpecialContact/close-account');
		$('.specialcontact-seclink-rename-account').trackClick('wiki/SpecialContact/rename-account');
		$('.specialcontact-seclink-blocked').trackClick('wiki/SpecialContact/blocked');
		$('.specialcontact-seclink-using-wikia').trackClick('wiki/SpecialContact/using-wikia');
		$('.specialcontact-seclink-feedback').trackClick('wiki/SpecialContact/feedback');
		$('.specialcontact-seclink-bug').trackClick('wiki/SpecialContact/bug');
		$('.specialcontact-seclink-bad-ad').trackClick('wiki/SpecialContact/bad-ad');
		$('.specialcontact-seclink-wiki-name-change').trackClick('wiki/SpecialContact/wiki-name-change');
		$('.specialcontact-seclink-design').trackClick('wiki/SpecialContact/design');
		$('.specialcontact-seclink-features').trackClick('wiki/SpecialContact/features');
		$('.specialcontact-seclink-close-wiki').trackClick('wiki/SpecialContact/close-wiki');
		$('#SpecialContactFooterPicker a').trackClick('wiki/SpecialContact/footer-picker');
		$('#SpecialContactFooterNoForm a').trackClick('wiki/SpecialContact/footer-noform');
		$('#SpecialContactIntroNoForm a').trackClick('wiki/SpecialContact/intro-noform');
		$('#SpecialContactIntroForm a').trackClick('wiki/SpecialContact/intro-form');

		$('input[type=file]').change(function() {
			$(this).closest('p').next().show();
		});
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
	if(typeof AB_CONFIG != 'undefined'){
		for(var expId in AB_CONFIG){
			if(AB_CONFIG.hasOwnProperty(expId)){
				// Cause the treatment-group to be cached in abTreatments array.
				getTreatmentGroup(expId);
			}
		}
	}

	// We only have info if abTreatments is defined.
	if(typeof abTreatments == 'object'){
		var abString = '';

		if(Object.keys(abTreatments).length == 0){
			abString = 'No active experiments.';
		} else {
			// Make a single entry for each experiment.
			for(var expId in abTreatments){
				var tgId = abTreatments[expId];
				if(typeof AB_CONFIG[expId] != 'undefined'){
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
