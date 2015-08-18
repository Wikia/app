<?php
namespace Flags;

use Flags\FlagsExtractor;
use Wikia\Tasks\Tasks\BaseTask;

class FlagsExtractTemplatesTask extends BaseTask {

	private
		$actionsStatus = false;

	public function extractTemplatesFromPage( $pageId, Array $flagTypesToExtract ) {
		$app = \F::app();

		$wikiId = $this->getWikiId();

		$wikiPage = \WikiPage::newFromID( $pageId );
		$app->wg->User = \User::newFromId( $wikiPage->getUser() );

		$content = $wikiPage->getText();

		$flagsExtractor = new FlagsExtractor();

		/**
		 * Get the existing flags first
		 */
		$existingFlags = $app->sendRequest( 'FlagsApiController',
			'getFlagsForPage',
			[
				'page_id' => $pageId,
			]
		)->getData()[\FlagsApiController::FLAGS_API_RESPONSE_DATA];

		/**
		 * Prepare actions for the extraction and check which flags should be updated
		 */
		$actions = [ FlagsExtractor::ACTION_REMOVE_ALL_FLAGS ];

		/**
		 * Check which flags should be added and which should be updated
		 */
		$flagsToAdd = $flagsToUpdate = [];

		foreach ( $flagTypesToExtract as $flagType ) {
			$actionParams = [
				'wiki_id' => $wikiId,
				'page_id' => $pageId,
				'flag_type_id' => $flagType['flag_type_id'],
			];

			$flagsExtractor->init( $content, $flagType['flag_view'], $actions, $actionParams );
			$template = $flagsExtractor->getTemplate()[0];

			if ( isset( $existingFlags[$flagType['flag_type_id']] ) ) {
				$flagsToUpdate[] = [
					'flag_id' => $existingFlags[$flagType['flag_type_id']]['flag_id'],
					'params' => $template['params'],
				];
			} else {
				$flagsToAdd[] = [
					'flag_type_id' => $flagType['flag_type_id'],
					'params' => $template['params'],
				];
			}

			/**
			 * Modify the content for the next template
			 */
			$content = $flagsExtractor->getText();
		}

		/**
		 * Send requests
		 */

		if ( !empty( $flagsToAdd ) ) {
			$responseData = $app->sendRequest( 'FlagsApiController',
				'addFlagsToPage',
				[
					'wiki_id' => $wikiId,
					'page_id' => $pageId,
					'flags' => $flagsToAdd,
				]
			)->getData();
			$this->actionsStatus = $responseData[\FlagsApiController::FLAGS_API_RESPONSE_STATUS];
			if ( $this->actionsStatus !== true ) {
				$this->error( 'The adding operation failed.' );
			}
		}

		if ( !empty( $flagsToUpdate ) ) {
			$responseData = $app->sendRequest( 'FlagsApiController',
				'updateFlagsForPage',
				[
					'wiki_id' => $wikiId,
					'page_id' => $pageId,
					'flags' => $flagsToUpdate,
				]
			)->getData();
			$this->actionsStatus = $responseData[\FlagsApiController::FLAGS_API_RESPONSE_STATUS];
			if ( $this->actionsStatus !== true ) {
				$this->error( 'The updating operation failed.' );
			}
		}

		/**
		 * If the actions succeeded - make the actual edit as WikiaBot
		 */
		if ( $this->actionsStatus ) {
			$user = \User::newFromName( 'WikiaBot' );
			$wikiPage->doEdit(
				$content,
				'Templates converted to the new Flags feature.',
				EDIT_FORCE_BOT | EDIT_MINOR,
				false,
				$user
			);
		}
	}

	public function migrateTemplatesToFlags( $template ) {
		global $IP;

		$wikiId = $this->getWikiId();
		$escapedTemplate = wfEscapeShellArg( $template );

		$cmd = "SERVER_ID={$wikiId} /usr/bin/php {$IP}/extensions/wikia/Flags/maintenance/MoveNotice.php --template={$escapedTemplate} --replaceTop --add --remove";
		$output = wfShellExec( $cmd );
		$this->info( $output );
	}
}
