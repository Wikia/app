<?php
namespace Wikia\ExactTarget;

class ExactTargetWikiHooks {
	
	/**
	 * Runs a method adding an AddWikiTask to job queue.
	 * Executed on CreateWikiLocalJob-complete hook.
	 * @param  array $wikiData  Must contain a city_id key
	 * @return true
	 */
	public function onCreateWikiLocalJobComplete( Array $wikiData ) {
		$wikiId = $wikiData['city_id'];
		/* Get and run the tasks */
		$this->queueUpdateWikiTask( $wikiId );
		$this->queueUpdateWikiCategoriesMapping( $wikiId );

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
			$this->queueUpdateWikiTask( $aParams['city_id'] );
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
		$this->queueUpdateWikiTask( $aParams['city_id'] );
		return true;
	}

	/**
	 * Runs a method adding an UpdateWikiCategoriesMapping to job queue
	 * on change in Hubs tab in WikiFactory.
	 * Executed on CityCatMappingUpdated hook.
	 * @param  array  $wikiData  Must contain a city_id key
	 * @return true
	 */
	public function onCityCatMappingUpdated( Array $wikiData ) {
		$this->queueUpdateWikiCategoriesMapping( $wikiData['city_id'] );
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
			$this->queueDeleteWikiTask( $city_id );
		}
		return true;
	}

	/**
	 * Adds update wiki task to queue
	 *
	 * @param int $wikiId
	 */
	private function queueUpdateWikiTask( $wikiId ) {
		$helper = $this->getWikiHelper();

		$task = new ExactTargetWikiTask();
		$task->call( 'updateWiki', $wikiId, $helper->prepareWikiData( $wikiId ) );
		$task->queue();
	}

	/**
	 * Deletes wiki
	 *
	 * @param int $wikiId
	 */
	private function queueDeleteWikiTask( $wikiId ) {
		$task = new ExactTargetWikiTask();
		$task->call( 'deleteWiki', $wikiId );
		$task->queue();
	}

	/**
	 * Updates wiki categories mapping
	 *
	 * @param $wikiId
	 */
	private function queueUpdateWikiCategoriesMapping( $wikiId ) {
		$task = new ExactTargetWikiTask();
		$task->call( 'updateWikiCategoriesMapping', $wikiId );
		$task->queue();
	}

	/**
	 * Returns an array where WF vars names are keys.
	 * Change of these vars should trigger an ET's city_list table update.
	 * @return  array  An array with vars names as keys
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
	 * A simple getter for an object of ExactTargetWikiHooksHelper class
	 * @return ExactTargetWikiHooksHelper
	 */
	private function getWikiHelper() {
		return new ExactTargetWikiHooksHelper();
	}

}
