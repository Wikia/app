<?php
namespace Wikia\ExactTarget;

class ExactTargetWikiHooks {
	
	/**
	 * Runs a method adding an AddWikiTask to job queue.
	 * Executed on CreateWikiLocalJob-complete hook.
	 * @param  array $aParams  Must contain a city_id key
	 * @return true
	 */
	public function onCreateWikiLocalJobComplete( Array $aParams ) {
		$this->addTheAddWikiTask( $aParams );
		return true;
	}

	/**
	 * Runs a method adding an UpdateWikiTask to job queue on change in WikiFactory
	 * Executed on WikiFactoryChanged hook
	 * @param  array $aParams  Must contain a city_id and a cv_name keys
	 * @return true
	 */
	public function onWikiFactoryChangeCommitted( Array $aParams ) {
		$aWfVariablesTriggeringUpdate = $this->getWfVarsTriggeringUpdate();
		if ( isset( $aWfVariablesTriggeringUpdate[ $aParams['cv_name'] ] ) ) {
			$this->addTheUpdateWikiTask( $aParams['city_id'] );
		}
		return true;
	}

	/**
	 * Runs a method adding an UpdateWikiTask to job queue
	 * on change in Hubs tab in WikiFactory.
	 * Executed on WikiFactoryVerticalSet hook.
	 * @param  array  $aParams  Must contain a city_id key
	 * @return true
	 */
	public function onWikiFactoryVerticalSet( Array $aParams ) {
		$this->addTheUpdateWikiTask( $aParams['city_id'] );
		return true;
	}

	/**
	 * Runs a method adding an UpdateCityCatMappingTask to job queue
	 * on change in Hubs tab in WikiFactory.
	 * Executed on CityCatMappingUpdated hook.
	 * @param  array  $aParams  Must contain a city_id key
	 * @return true
	 */
	public function onCityCatMappingUpdated( Array $aParams ) {
		$this->addTheUpdateCityCatMappingTask( $aParams );
		return true;
	}

	/**
	 * Runs a method adding a DeleteWikiTask to the job queue
	 * when a wiki is closed.
	 * Executed on a WikiFactoryPublicStatusChanged hook.
	 * @param  Array  $aParams Must contain a city_id key
	 * @return true
	 */
	public function onWikiFactoryPublicStatusChanged( &$city_public, &$city_id, $reason ) {
		if ( $city_public <= 0 ) {
			$this->addTheDeleteWikiTask( [ 'city_id' => $city_id ] );
		}
		return true;
	}

	/**
	 * Adds a task to job queue that sends
	 * a Create request to ExactTarget with data of a new wiki.
	 * @param  Array $aParams  Must contain a city_id key
	 */
	private function addTheAddWikiTask( Array $aParams ) {
		$iCityId = $aParams['city_id'];
		$oTask = $this->getExactTargetCreateWikiTask();
		$oTask->call( 'sendNewWikiData', $iCityId );
		$oTask->queue();
	}

	/**
	 * Adds a task to job queue that sends
	 * an Update request to ExactTarget with a changed variable.
	 * @param  int $iCityId  A wiki's id
	 */
	private function addTheUpdateWikiTask( $iCityId ) {
		$oTask = $this->getExactTargetUpdateWikiTask();
		$oTask->call( 'updateFallbackCreateWikiData', $iCityId );
		$oTask->queue();
	}

	/**
	 * Adds a task to job queue that sends a request
	 * updating city_cat_mapping table.
	 * @param  Array $aParams  Must contain a city_id key
	 */
	private function addTheUpdateCityCatMappingTask( Array $aParams ) {
		$oTask = $this->getExactTargetUpdateCityCatMappingTask();
		$oTask->call( 'updateCityCatMappingData', $aParams );
		$oTask->queue();
	}

	/**
	 * Adds a task to job queue that sends a request
	 * deleting records from city_list and city_cat_mapping.
	 * @param  Array $aParams  Must contain a city_id key
	 */
	private function addTheDeleteWikiTask( Array $aParams ) {
		$oTask = $this->getExactTargetDeleteWikiTask();
		$oTask->call( 'deleteWikiData', $aParams );
		$oTask->queue();
	}

	/**
	 * Returns an array where WF vars names are keys.
	 * Change of these vars should trigger an ET's city_list table update.
	 * @return  Array  An array with vars names as keys
	 */
	private function getWfVarsTriggeringUpdate() {
		$aWfVarsTriggeringUpdate = [
			'wgServer' => true,
			'wgSitename' => true,
			'wgLanguageCode' => true,
			'wgDBcluster' => true,
		];
		return $aWfVarsTriggeringUpdate;
	}

	/**
	 * A simple getter for an object of an ExactTargetCreateWikiTask class
	 * @return  object ExactTargetCreateWikiTask
	 */
	private function getExactTargetCreateWikiTask() {
		return new ExactTargetCreateWikiTask();
	}

	/**
	 * A simple getter for an object of an ExactTargetUpdateWikiTask class
	 * @return  object ExactTargetUpdateWikiTask
	 */
	private function getExactTargetUpdateWikiTask() {
		return new ExactTargetUpdateWikiTask();
	}

	/**
	 * A simple getter for an object of an ExactTargetUpdateCityCatMappingTask class
	 * @return  object ExactTargetUpdateCityCatMappingTask
	 */
	private function getExactTargetUpdateCityCatMappingTask() {
		return new ExactTargetUpdateCityCatMappingTask();
	}

	/**
	 * A simple getter for an object of an ExactTargetDeleteWikiTask class
	 * @return  object ExactTargetDeleteWikiTask
	 */
	private function getExactTargetDeleteWikiTask() {
		return new ExactTargetDeleteWikiTask();
	}
}
