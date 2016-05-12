<?php

namespace Wikia\CreateNewWiki\Tasks;

use User;
use WikiFactory;

class SetCustomSettings implements Task {

	private $taskContext;

	public function __construct(TaskContext $taskContext ) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
	}

	public function check() {
	}

	public function run() {
		global $wgUniversalCreationVariables, $wgLangCreationVariables;

		$wikiType = "default";

		if ( !empty($wgUniversalCreationVariables) && isset( $wgUniversalCreationVariables[$wikiType] ) ) {
			$this->addCustomSettings( 0, $wgUniversalCreationVariables[$wikiType], "universal" );
			wfDebugLog( "createwiki", __METHOD__ . ": Custom settings added for wiki_type: {self::WIKI_TYPE} \n", true );
		}

		/**
		 * set variables per language
		 */
		$langCreationVar = isset($wgLangCreationVariables[$wikiType]) ? $wgLangCreationVariables[$wikiType] : $wgLangCreationVariables;
		$this->addCustomSettings( $this->taskContext->getLanguage(), $langCreationVar, "language" );
		wfDebugLog( "createwiki", __METHOD__ . ": Custom settings added for wiki_type: {$wikiType} and language: {$this->taskContext->getLanguage()} \n", true );
	}

	public function addCustomSettings( $match, $settings, $type = 'unknown' ) {
		global $wgUser;

		wfProfileIn( __METHOD__ );

		if( ( !empty( $match ) || $type == 'universal' ) && isset( $settings[ $match ] ) && is_array( $settings[ $match ] ) ) {
			wfDebugLog( "createwiki", __METHOD__ . ": Found '$match' in {$type} settings array \n", true );

			/**
			 * switching user for correct logging
			 */
			$oldUser = $wgUser;
			$wgUser = User::newFromName( 'CreateWiki script' );

			$cityId = $this->taskContext->getCityId();

			foreach( $settings[$match] as $key => $value ) {
				$success = WikiFactory::setVarById( $key, $cityId, $value );
				if( $success ) {
					wfDebugLog( "createwiki", __METHOD__ . ": Successfully added setting for {$cityId}: {$key} = {$value}\n", true );
				} else {
					wfDebugLog( "createwiki", __METHOD__ . ": Failed to add setting for {$cityId}: {$key} = {$value}\n", true );
				}
			}
			$wgUser = $oldUser;

			wfDebugLog( "createwiki", __METHOD__ . ": Finished adding {$type} settings\n", true );
		} else {
			wfDebugLog( "createwiki", __METHOD__ . ": '{$match}' not found in {$type} settings array. Skipping this step.\n", true );
		}

		wfProfileOut( __METHOD__ );
		return 1;
	}
}
