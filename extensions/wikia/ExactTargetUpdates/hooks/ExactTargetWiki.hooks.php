<?php

class ExactTargetWikiHooks {
	
	/**
	 * Runs a method adding an AddWikiTask to job queue.
	 * Executed on CreateWikiLocalJob-complete hook.
	 * @param  array $aParams  Contains a wiki's id, url and title.
	 * @return true
	 */
	public function onCreateWikiLocalJobComplete( Array $aParams ) {
		$this->addTheAddWikiTask( $aParams );
		return true;
	}

	/**
	 * Runs a method adding an UpdateWikiTask to job queue on change in WikiFactory
	 * Executed on WikiFactoryChanged hook
	 * @param  array $aWfVarParams  Contains a var's name, a wiki's id and a new value.
	 * @return true
	 */
	public function onWikiFactoryChangeCommitted( Array $aParams ) {
		$oHelper = $this->getHelper();
		$aWfVariablesTriggeringUpdate = $oHelper->getWfVarsTriggeringUpdate();
		if ( isset( $aWfVariablesTriggeringUpdate[ $aParams['cv_name'] ] ) ) {
			$this->addTheUpdateWikiTask( $aParams['city_id'] );
		}
		return true;
	}

	/**
	 * Runs a method adding an UpdateWikiTask to job queue
	 * on change in Hubs tab in WikiFactory.
	 * Executed on WikiFactoryVerticalSet hook.
	 * @param  array  $aParams  An array with a relevant city_id
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
	 * @param  array  $aParams  An array with a relevant city_id and an array of new categories
	 * @return true
	 */
	public function onCityCatMappingUpdated( Array $aParams ) {
		$this->addTheUpdateCityCatMappingTask( $aParams );
		return true;
	}

	/**
	 * Adds a task to job queue that sends
	 * a Create request to ExactTarget with data of a new wiki.
	 * @param  array $aParams  Contains wiki's id, url and title.
	 * @param  ExactTargetAddWikiTask $oTask  Task object.
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
	 * @param  array $aWfVarParams  Contains var's name, city_id and a new value.
	 * @param  ExactTargetUpdateTask $oTask  Task object.
	 */
	private function addTheUpdateWikiTask( $iCityId ) {
		$oTask = $this->getExactTargetUpdateWikiTask();
		$oTask->call( 'updateWikiData', $iCityId );
		$oTask->queue();
	}

	/**
	 * [addTheUpdateCityCatMappingTask description]
	 * @param [type]                              $aParams [description]
	 * @param ExactTargetUpdateCityCatMappingTask $oTask   [description]
	 */
	private function addTheUpdateCityCatMappingTask( Array $aParams ) {
		$oTask = $this->getExactTargetUpdateCityCatMappingTask();
		$oTask->call( 'updateCityCatMappingData', $aParams );
		$oTask->queue();
	}

	private function getHelper() {
		return new ExactTargetWikiHooksHelper();
	}

	private function getExactTargetCreateWikiTask() {
		return new ExactTargetCreateWikiTask();
	}

	private function getExactTargetUpdateWikiTask() {
		return new ExactTargetUpdateWikiTask();
	}

	private function getExactTargetUpdateCityCatMappingTask() {
		return new ExactTargetUpdateCityCatMappingTask();
	}
}
