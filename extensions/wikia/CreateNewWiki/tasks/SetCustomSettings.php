<?php

namespace Wikia\CreateNewWiki\Tasks;

use User;
use WikiFactory;
use Wikia\Logger\Loggable;

class SetCustomSettings extends Task {
	use Loggable;

	public function run() {
		global $wgUniversalCreationVariables, $wgLangCreationVariables;

		$wikiType = "default";
		$language = $this->taskContext->getLanguage();

		if ( !empty($wgUniversalCreationVariables) && isset($wgUniversalCreationVariables[$wikiType]) ) {
			$this->addCustomSettings( 0, $wgUniversalCreationVariables[$wikiType], "universal" );
			$this->debug( implode( ":", [ "CreateWiki", __METHOD__, "Custom settings added for wiki_type: {$wikiType}" ] ) );
		}

		/**
		 * set variables per language
		 */
		$langCreationVar = isset($wgLangCreationVariables[$wikiType]) ? $wgLangCreationVariables[$wikiType] : $wgLangCreationVariables;
		$this->addCustomSettings( $language, $langCreationVar, "language" );
		$this->debug( implode( ":",
			[ __METHOD__, "Custom settings added for wiki_type: {$wikiType} and language: {$language}" ]
		) );

		return TaskResult::createForSuccess();
	}

	public function addCustomSettings( $match, $settings, $type = 'unknown' ) {
		global $wgUser;

		wfProfileIn( __METHOD__ );

		if ( (!empty($match) || $type == 'universal') && isset($settings[$match]) && is_array( $settings[$match] ) ) {
			$this->debug( implode( ":", [ __METHOD__, "Found '$match' in {$type} settings array" ] ) );

			/**
			 * switching user for correct logging
			 */
			$oldUser = $wgUser;
			$wgUser = User::newFromName( 'CreateWiki script' );

			$cityId = $this->taskContext->getCityId();

			foreach ( $settings[$match] as $key => $value ) {
				$success = WikiFactory::setVarById( $key, $cityId, $value );
				if ( $success ) {
					$this->debug( implode( ":", [ __METHOD__, "Successfully added setting for {$cityId}: {$key} = {$value}" ] ) );
				} else {
					$this->debug( implode( ":", [ __METHOD__, "Failed to add setting for {$cityId}: {$key} = {$value}" ] ) );
				}
			}

			$wgUser = $oldUser;

			$this->debug( implode( ":", [ __METHOD__, "Finished adding {$type} settings" ] ) );
		} else {
			$this->debug( implode( ":", [ __METHOD__, "'{$match}' not found in {$type} settings array. Skipping this step." ] ) );
		}

		wfProfileOut( __METHOD__ );
	}
}
