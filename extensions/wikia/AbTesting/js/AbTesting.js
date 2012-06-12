/**
 * @author Sean Colombo
 *
 * These functions are loaded very early in page-execution so that A/B tests can be run at various
 * spots in execution.  Because this is loaded in a blocking manner (and very early), please make sure
 * to keep the functionality short and to the point (comments get minified away, so don't fear them).
 */

// Caches already-assigned treatments to make sure any re-treatments are consistent and to avoid sending the treatment event multiple times for the same treatment on a page-load.
abTreatments = window.abTreatments || {};

// Key is experiment id, value is true if this user is recieving a treatment that
// will be tracked for the experiment. This is a way to differentiate users being
// tracked in the control group vs. those also experiencing the control, but not
// being part of the test results.
var abBeingTracked = {};

// Allow forcing yourself into a certain treatment group for the duration of a pageview, for any number of experiments simultaneously.
// The URL params are of the format ab[EXPERIMENT_ID]=TREATMENT_GROUP_ID, eg: "?ab[1]=123&ab[2]=345"
var reg = /[?&]+ab\[([^&]+)\]=([^&]*)/gi;
var matches;
while((matches = reg.exec(window.location.href)) != null){
	abTreatments[ matches[1] ] = matches[2];
}

/**
 * Will return the id of the treatment group that this user should see. If the beacon_id doesn't exist, the control group
 * will be returned.  If there is an error loading the config (so no control group or other group IDs can be found, this will
 * return an empty string). For any invalid group IDs, the calling code MUST default to using a reasonable fallback
 * (usually this should be the control-group, if that's easy to know at coding-time).
 */
function getTreatmentGroup( expId ){
	var hasLogging = (typeof console != 'undefined');
	var treatmentGroup = "";

	if(typeof abTreatments[expId] !== 'undefined'){
		// If we've already determined the treatment on this page-load, then return it right away (and don't send an extra treatment event).
		treatmentGroup = abTreatments[expId];
	} else {
		if(AB_CONFIG.hasOwnProperty( expId )){
			if(typeof beacon_id == "undefined"){
				if (hasLogging) {
					if((typeof wgJsAtBottom !='undefined') && (!wgJsAtBottom)){
						console.log("This type of page makes a beacon call in body but loads JS for tests in the head: A/B tests can't work this way. Will fall back to control group.");
					} else {
						console.log("DON'T CALL getTreatmentGroup() BEFORE BEACON/PAGE-VIEW CALL! Experiment is broken (will fall back to control group).");
					}
				}

				// There is no beacon, so treat the user with the Control Group (this treatment will get recorded).
				for( var tgId in AB_CONFIG[expId]['groups'] ){
					var tgConfig = AB_CONFIG[expId]['groups'][tgId];
					if(tgConfig.is_control){
						treatmentGroup = tgId;
					}
				}
				if((treatmentGroup === "") && hasLogging){
					console.log("NO CONTROL GROUP DEFINED FOR EXPERIMENT: " + expId);
				}
				abBeingTracked[expId] = false;
			} else {
				// Figure out the correct treatment group based on the beacon_id.
				var normalizedHash = abHash( expId ); // beacon_id is used in here
				var controlId;
				for( var tgId in AB_CONFIG[expId]['groups'] ){
					var tgConfig = AB_CONFIG[expId]['groups'][tgId];
					if((normalizedHash >= tgConfig.min) && (normalizedHash <= tgConfig.max)){
						treatmentGroup = tgId;
					}
					if(tgConfig.is_control){
						controlId = tgId;
					}
				}

				// If treatment group wasn't explicitly set, show the user the control, but don't log a treatment event.
				if(treatmentGroup === ""){
					treatmentGroup = controlId;
					abBeingTracked[expId] = false;
				} else {
					// Record the treatment event.
					WikiaTracker.trackEvent(
						'ab_treatment',
						{
							'varnishTime': varnishTime ,
							'experimentId': expId,
							'treatmentGroup': treatmentGroup
						},
						'internal'
					);

					// Cache the treatment grouup so that we know not to send the treatment event again on this page.
					abTreatments[ expId ] = treatmentGroup;
					abBeingTracked[expId] = true;
				}
			}
		} else if (hasLogging) {
			console.log("CALLED getTreatmentGroup FOR AN EXPERIMENT THAT IS NOT CONFIGURED! Exp: " + expId);
		}
	}

	return treatmentGroup;
}

// abHash will hash the beacon_id and return an integer from 0 to 99 inclusive.
// That number can be used to slot into a treatment-group based on its percentages.
// If there is no beacon_id yet, then this will always return 0.
function abHash( expId ){
	if(typeof beacon_id == "undefined"){
		return 0;
	} else {
		var s = beacon_id + '' + expId;
		var i, hash = 0;
		for (i = 0; i < s.length; i++){
			hash += (s.charCodeAt(i) * (i+1));
		}
		return Math.abs(hash) % 100;
	}
}
