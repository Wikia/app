<?php
/**
 * @author Sean Colombo
 * @date 20120501
 *
 * 
 */

class AbTesting {

	/**
	 * Add inline JS in <head> section
	 *
	 * NOTE: This is embedded instead of being an extra request because it needs to be done this early
	 * on the page (and external blocking-requests are time-consuming).
	 *
	 * @param string $scripts inline JS scripts
	 * @return boolean return true to tell other functions on the same hook to continue executing
	 */
	public static function onSkinGetHeadScripts($scripts) {
		wfProfileIn( __METHOD__ );

		// Config for experiments and treatment groups.
		$scripts .= "\n\n<!-- A/B Testing code -->\n";

		$js = AbTesting::getJsExperimentConfig() . "\n" . AbTesting::getJsFunction();

		$scripts .= Html::inlineScript( $js )."\n";

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Returns a string containing minified javascript for the configuration of experiments and test
	 * groups.
	 */
	public static function getJsExperimentConfig(){
		wfProfileIn( __METHOD__ );

		// Cache the generated string inside of memcached.
		$memKey = $app->wf->SharedMemcKey( 'datamart', 'abconfig' );
		$jsString = $app->wg->Memc->get( $memKey );
		if(empty($jsString)){
			$app = F::app();
			$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );
			
			// Generate config JS from the experiments and treatment_groups tables in the datamart.
			$result = $db->select(
						array('experiments', 'treatment_groups'),
						array("experiments.id as expId, experiments.name as expName, experiments.begin_time as expBeginTime, experiments.end_time as expEndTime, ".
							  "treatment_groups.id as tgId, treatment_groups.name as tgName, treatment_groups.is_control as tgIsControl, treatment_groups.percentage as tgPercentage"),
						array("end_time > NOW()",
							  "begin_time < NOW() + INTERVAL 1 DAY + INTERVAL 1 HOUR", // because pages are cached for 24 hours (and the string is an hour in memcached), we have to include experiments that start soon.
							  "treatment_groups.experiment_id = experiments.id",
						),
						__METHOD__
			);

			$expData = array();
			while ( $row = $db->fetchObject($result) ) {
				// If this is the first entry for this experiment, create the experiment in the array.
				if(!isset($expData[ $row->expId ])){
					$expData[ $row->expId ] = array(
						'name' => $row->expId,
						'begin_time' => $row->expBeginTime,
						'end_time' => $row->expEndTime,
						'groups' => array()
					);
				}
				
				// Add this treatment group's info to the experiment.
				$expData[ $row->expId ][ $row->tgId ] = array(
					'name' => $row->tgName,
					'is_control' => $row->tgIsControl,
					'percentage' => $row->tgPercentage
				);
			}

// TODO: CALCUTE min/max PERCENTAGES FOR THE EXPERIMENTS.
			// Pre-calculate the min-max percentages for each experiment.
print "DATA FROM DB:<br/>\n";
print_r($expData);
			foreach($expData as $expId => $exp){
				$min = 0;
				foreach($exp['groups'] as $groupId => $groupData){
					$groupData['min'] = $min;
					$groupData['max'] = $min + $groupData['percentage'] - 1; // -1 is because this range is inclusive, so all min-max ranges should be disjoint.
					unset($groupData['percentage']);
					$min = $groupData['max'] + 1;
				}
			}
print "DATA AFTER TRYING TO CALCULATE RANGES:<br/>\n";
print_r($expData);

			ob_start();

			// Output 'consts' (technically vars since const isn't fully cross-browser yet) for experiments and groups.
			$varString = "";
			foreach($expData as $expId => $exp){
				$varString .= ($varString == "" ? "" : ",");

				// Turn the experiment name into a variable
				$expName = $exp['name'];
				$expName = strtoupper( preg_replace("/[^a-b0-9_]/i", "", $expName) );

				$varString .= "$expName = $expId";
			}
			$varString = "var $varString;\n";

			print $varString;
			
			
print "JSON ENCODED expData (might work):<br/>\n".json_encode($expData);
			?>
			var AB_CONFIG = {
	// TODO: DO WE NEED NAMES OF EXPERIMENTS AND GROUPS? EASIER FOR DEBUG, BUG BIGGER PAYLOAD.

	//  TODO: USE EXPERIMENT IDS AS FIRST-LEVEL KEYS
				123: {
					name: // TODO:
					begin_time: // TODO:
					end_time: // TODO:
					groups: {
	// TODO: USE GROUP IDS AS KEYS
						222: {
							name: 
							is_control: 
							min: 
							max: 
						},
						333:
					}
				}
			};
			<?php
			$jsString = ob_get_clean();

			// We're embedding this in every page, so minify it.
			$jsString = AssetsManagerBaseBuilder::minifyJs( $jsString );
			
			// Store the generated string in memcached (both the db call and the minification are expensive enough that we'd rather not do them on every page-load).
			$SECONDS_IN_HOUR = 60*60;
			$app->wg->Memc->set( $memKey, $jsString, $SECONDS_IN_HOUR );
		}

		wfProfileOut( __METHOD__ );
		return $jsString;
	} // end getJsExperimentConfig()
	
	/**
	 * Returns the javascript for the getTreatmentGroup() function as a string.
	 */
	public static function getJsFunction(){
		wfProfileIn( __METHOD__ );

		ob_start();

// TODO: WRITE THE BODY OF THE FUNCTION!
		// Will return the id of the treatment group that this user should see. If the beacon_id doesn't exist, the control group
		// will be returned.  If there is an error loadign the config (so no control group or other group IDs can be found, this will
		// return an empty string. For any invalid group IDs, the calling code MUST default to using a reasonable fallback
		// (usually this should be the control-group, if that's easy to know at coding-time).
		?>function getTreatmentGroup( experimentId ){
			var hasLogging = (typeof console != 'undefined');
			var treatmentGroup = "";
			if(AB_CONFIG.hasOwnProperty( experimentId )){
			
				if(typeof beacon_id == "undefined"){
					if (hasLogging) {
						console.log("DO NOT CALL getTreatmentGroup() BEFORE THE BEACON/PAGE-VIEW CALL! Experiment is broken (will fall back to control group).");
					}
					
					// There is no beacon, so treat the user with the Control Group (this treatment will get recorded).
					for( var tgId in AB_CONFIG[experimentId] ){
						var tgConfig = AB_CONFIG[experimentId][tgId];
						if(tgConfig.is_control){
							treatmentGroup = tgId;
						}
					}
					if((treatmentGroup === "") && hasLogging){
						console.log("NO CONTROL GROUP DEFINED FOR EXPERIMENT: " + experiment);
					}
				} else {
					// Figure out the correct treatment group based on the beacon_id.
					var normalizedHash = abHash( experimentId ); // beacon_id is used in here
					for( var tgId in AB_CONFIG[experimentId] ){
						var tgConfig = AB_CONFIG[experimentId][tgId];
						if((normalizedHash >= tgConfig.min) || (normalizedHash <= tgConfig.max)){
							treatmentGroup = tgId;
						}
					}
				}

// TODO: Record the treatment event and cache the treatment group (so that we know not to send the event again).
// NOTE: pass varnishTime to the backend

			} else if (hasLogging) {
				console.log("TRIED TO getTreatmentGroup() FOR AN EXPERIMENT THAT IS NOT CONFIGURED! Exp: " + experimentId);
			}

			return treatmentGroup;
		}
		<?php
			// abHash will hash the beacon_id and return an integer from 0 to 99 inclusive.
			// That number can be used to slot into a treatment-group based on its percentages.
			// If there is no beacon_id yet, then this will always return 0.
		?>function abHash( experimentId ){
			if(typeof beacon_id == "undefined"){
				return 0;
			} else {
				var s = beacon_id + '' + experimentId;
				var i, hash = 0;
				for (i = 0; i < s.length; i++){
					hash += (s.charCodeAt(i) * (i+1));
				}
				return Math.abs(hash) % 100;
			}
		}
		<?php
		$jsString = ob_get_clean();

		// We're embedding this in every page, so minify it.
		$jsString = AssetsManagerBaseBuilder::minifyJs( $jsString );
		
		wfProfileOut( __METHOD__ );
		return $jsString;
	} // end getJsFunction()

}
