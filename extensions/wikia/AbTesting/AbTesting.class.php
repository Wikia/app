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

		$app = F::app();

		// Cache the generated string inside of memcached.
		$memKey = $app->wf->SharedMemcKey( 'datamart', 'abconfig' );
		$jsString = $app->wg->Memc->get( $memKey );
		if(empty($jsString)){
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
						'name' => $row->expName,
						'begin_time' => $row->expBeginTime,
						'end_time' => $row->expEndTime,
						'groups' => array()
					);
				}
				
				// Add this treatment group's info to the experiment.
				$expData[ $row->expId ]['groups'][ $row->tgId ] = array(
					'name' => $row->tgName,
					'is_control' => ($row->tgIsControl == "1"),
					'percentage' => $row->tgPercentage
				);
			}

			// Pre-calculate the min-max percentages for each experiment.
			foreach($expData as $expId => $exp){
				$min = 0;
				
				// The ranges must be computed with the groups sorted by id (so that ranges could be reproduced deterministically server-side).
				ksort($exp['groups']);

				foreach($exp['groups'] as $groupId => $groupData){
					$expData[$expId]['groups'][$groupId]['min'] = $min;
					$expData[$expId]['groups'][$groupId]['max'] = $min + $groupData['percentage'] - 1; // -1 is because this range is inclusive, so all min-max ranges should be disjoint.
					unset($expData[$expId]['groups'][$groupId]['percentage']);
					$min = $expData[$expId]['groups'][$groupId]['max'] + 1;
				}
			}

			ob_start();

			// Output 'consts' (technically vars since const isn't fully cross-browser yet) for experiments and groups.
			$varString = "";
			foreach($expData as $expId => $exp){
				$varString .= ($varString == "" ? "" : ",");

				// Turn the experiment name into a variable
				$expName = self::makeStringIntoJsConst( $exp['name'] );

				$varString .= "EXP_$expName = $expId";

				// Make 'consts' for each treatmenet-group too.
				foreach($exp['groups'] as $tgId => $tgData){
					$varString .= ($varString == "" ? "" : ",");

					$tgName = self::makeStringIntoJsConst( $tgData['name'] );
					$varString .= "TG_$tgName = $tgId";
				}
			}
			print "var $varString,AB_CONFIG = ".json_encode($expData)."\n";
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
	 * Given a raw string, formats it such that it is a JS var (all caps to indicate that it's a constant).
	 */
	public static function makeStringIntoJsConst( $rawString ){
		$rawString = str_replace(" ", "_", $rawString);
		$rawString = strtoupper( preg_replace("/[^a-z0-9_]/i", "", $rawString) );
		return $rawString;
	}
	
	/**
	 * Returns the javascript for the getTreatmentGroup() function as a string.
	 */
	public static function getJsFunction(){
		wfProfileIn( __METHOD__ );

		ob_start();

		// Will return the id of the treatment group that this user should see. If the beacon_id doesn't exist, the control group
		// will be returned.  If there is an error loadign the config (so no control group or other group IDs can be found, this will
		// return an empty string. For any invalid group IDs, the calling code MUST default to using a reasonable fallback
		// (usually this should be the control-group, if that's easy to know at coding-time).
		?>
		// Caches already-assigned treatments to make sure any re-treatments are consistent and to avoid sending the treatment event multiple times for the same treatment on a page-load.
		var abTreatments = {};

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
							console.log("DON'T CALL getTreatmentGroup() BEFORE BEACON/PAGE-VIEW CALL! Experiment is broken (will fall back to control group).");
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
					} else {
						// Figure out the correct treatment group based on the beacon_id.
						var normalizedHash = abHash( expId ); // beacon_id is used in here
						var controlId;
						for( var tgId in AB_CONFIG[expId]['groups'] ){
							var tgConfig = AB_CONFIG[expId]['groups'][tgId];
							if((normalizedHash >= tgConfig.min) || (normalizedHash <= tgConfig.max)){
								treatmentGroup = tgId;
							}
							if(tgConfig.is_control){
								controlId = tgConfig;
							}
						}

						// If treatment group wasn't explicitly set, show the user the control, but don't log a treatment event.
						if(treatmentGroup === ""){
							treatmentGroup = controlId;
						} else {
							// Record the treatment event.
							$.internalTrack('TREATMENT_EVENT', { 'varnishTime': varnishTime , 'treatmentGroup': treatmentGroup });
							
							// Cache the treatment grouup so that we know not to send the treatment event again on this page.
							abTreatments[ expId ] = treatmentGroup;
						}
					}
				} else if (hasLogging) {
					console.log("CALLED getTreatmentGroup FOR AN EXPERIMENT THAT IS NOT CONFIGURED! Exp: " + expId);
				}
			}

			return treatmentGroup;
		}
		<?php
			// abHash will hash the beacon_id and return an integer from 0 to 99 inclusive.
			// That number can be used to slot into a treatment-group based on its percentages.
			// If there is no beacon_id yet, then this will always return 0.
		?>function abHash( expId ){
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
		<?php
		$jsString = ob_get_clean();

		// We're embedding this in every page, so minify it.
// TODO: RESTORE THE MINIFICATION BEFORE COMMITTING.
//		$jsString = AssetsManagerBaseBuilder::minifyJs( $jsString );
		
		wfProfileOut( __METHOD__ );
		return $jsString;
	} // end getJsFunction()

}
