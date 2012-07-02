<?php
/**
 * @author Sean Colombo
 * @date 20120501
 *
 *
 */

class AbTesting extends WikiaObject {
	const SECONDS_IN_HOUR = 3600;
	static protected $initialized = false;

	function __construct(){
		parent::__construct();

		if ( !self::$initialized ) {
			//Nirvana singleton, please use F::build
			F::setInstance( __CLASS__, $this );
			self::$initialized = true;
		}
	}

	/**
	 * Add inline JS in <head> section
	 *
	 * NOTE: This is embedded instead of being an extra request because it needs to be done this early
	 * on the page (and external blocking-requests are time-consuming).
	 *
	 * @param string $scripts inline JS scripts
	 * @return boolean return true to tell other functions on the same hook to continue executing
	 */
	public function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		$this->wf->profileIn( __METHOD__ );

		//AbTesting is an Oasis-only experiment for now
		if ( $this->app->checkSkin( 'oasis', $skin ) ) {
			// Config for experiments and treatment groups.
			$scripts .= "\n\n<!-- A/B Testing code -->\n";
			$js = $this->getJsExperimentConfig();
			$scripts .= Html::inlineScript( $js )."\n";
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	//keeping the response size (assets minification) and the number of external requests low (aggregation)
	public function onWikiaMobileAssetsPackages( Array &$jsHeadPackages, Array &$jsBodyPackages, Array &$scssPackages ) {
		array_unshift( $jsHeadPackages, 'abtesting' );
		return true;
	}

	/**
	 * Gets the JS package name to add to a skin head element.
	 * This function exists to make it easy to enable/disable loading of the package on
	 * a per-skin basis while this is an Oasis-only experiment
	 *
	 * TODO: probably remove when multi-skin support will be correctly abstracted and implemented
	 */
	public function getJsPackage() {
		$res = null;

		//AbTesting is an Oasis-only experiment for now
		if ( $this->app->checkSkin( 'oasis' ) ) {
			$res = 'abtesting';
		}

		return $res;
	}

	/**
	 * Returns a string containing minified javascript for the configuration of experiments and test
	 * groups.
	 */
	private function getJsExperimentConfig(){
		$this->wf->profileIn( __METHOD__ );

		// Cache the generated string inside of memcached.
		$memKey = $this->wf->SharedMemcKey( 'wikicities', 'abconfig' );
		$jsString = $this->wg->Memc->get( $memKey );

		if ( empty( $jsString ) ) {
			$db = $this->wf->getDB( DB_SLAVE, array(), $this->wg->ExternalSharedDB );

			// Generate config JS from the experiments and treatment_groups tables in the datamart.
			$result = $db->select(
						array( 'experiments', 'treatment_groups' ),
						array( "experiments.id as expId, experiments.name as expName, experiments.begin_time as expBeginTime, experiments.end_time as expEndTime, ".
							  "treatment_groups.id as tgId, treatment_groups.name as tgName, treatment_groups.is_control as tgIsControl, treatment_groups.percentage as tgPercentage"
						),
						array( "end_time > NOW()",
							  "begin_time < NOW() + INTERVAL 1 DAY + INTERVAL 1 HOUR", // because pages are cached for 24 hours (and the string is an hour in memcached), we have to include experiments that start soon.
							  "treatment_groups.experiment_id = experiments.id",
						),
						__METHOD__
			);

			$expData = array();

			while ( $row = $db->fetchObject( $result ) ) {
				// If this is the first entry for this experiment, create the experiment in the array.
				if ( !isset( $expData[ $row->expId ] ) ) {
					$expData[ $row->expId ] = array(
						'name' => $row->expName,
						'begin_time' => $row->expBeginTime,
						'end_time' => $row->expEndTime,
						'ga_slot' => 46, // TODO: FIXME: HARDCODING TEMPORARILY. THIS SHOULD END UP IN THE EXPERIMENT TABLE SCHEMA SOON.
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
			foreach ( $expData as $expId => $exp ) {
				$min = 0;

				// The ranges must be computed with the groups sorted by id (so that ranges could be reproduced deterministically server-side).
				ksort( $exp['groups'] );

				foreach ( $exp['groups'] as $groupId => $groupData ) {
					$expData[$expId]['groups'][$groupId]['min'] = $min;
					$expData[$expId]['groups'][$groupId]['max'] = $min + $groupData['percentage'] - 1; // -1 is because this range is inclusive, so all min-max ranges should be disjoint.
					unset($expData[$expId]['groups'][$groupId]['percentage']);
					$min = $expData[$expId]['groups'][$groupId]['max'] + 1;
				}
			}

			ob_start();

			// Output 'consts' (technically vars since const isn't fully cross-browser yet) for experiments and groups.
			$varString = "";

			foreach ( $expData as $expId => $exp ) {
				$varString .= ( $varString == "" ? "" : "," );

				// Turn the experiment name into a variable
				$expName = $this->makeStringIntoJsConst( $exp['name'] );

				$varString .= "EXP_$expName = $expId";

				// Make 'consts' for each treatmenet-group too.
				foreach ( $exp['groups'] as $tgId => $tgData ) {
					$varString .= ( $varString == "" ? "" : "," );

					$tgName = $this->makeStringIntoJsConst( $tgData['name'] );
					$varString .= "TG_$tgName = $tgId";
				}
			}

			print "var $varString,AB_CONFIG = " . json_encode($expData) . "\n";
			$jsString = ob_get_clean();

			// We're embedding this in every page, so minify it.
			$jsString = AssetsManagerBaseBuilder::minifyJs( $jsString );

			// Store the generated string in memcached (both the db call and the minification are expensive enough that we'd rather not do them on every page-load).

			$this->wg->Memc->set( $memKey, $jsString, self::SECONDS_IN_HOUR );
		}

		$this->wf->profileOut( __METHOD__ );

		return $jsString;
	}

	/**
	 * Given a raw string, formats it such that it is a JS var (all caps to indicate that it's a constant).
	 */
	private function makeStringIntoJsConst( $rawString ) {
		$rawString = str_replace( " ", "_", $rawString );
		$rawString = strtoupper( preg_replace( "/[^a-z0-9_]/i", "", $rawString ) );

		return $rawString;
	}
}
