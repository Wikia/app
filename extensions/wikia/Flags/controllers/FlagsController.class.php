<?php

/**
 * The public interface of the extension and the main entry point for all requests.
 * It provides a set of CRUD methods to manipulate Flags instances and their types.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

use Flags\Views\FlagView;
use Flags\FlagsHelper;

class FlagsController extends WikiaController {
	private
		$params;

	/**
	 * A wrapper for a request to the FlagsApiController for flags for the given page
	 * that returns a wikitext string with calls to templates of the flags.
	 * @return null|string
	 */
	public function getFlagsForPageWikitext( $pageId ) {
		$flags = $this->requestGetFlagsForPage( $pageId );

		if ( !empty( $flags ) ) {
			$flagsWikitext = '';

			$flagView = new FlagView();
			foreach ( $flags as $flagId => $flag ) {
				$flagsWikitext .= $flagView->createWikitextCall( $flag['flag_view'], $flag['params'] );
			}

			return $flagsWikitext;
		}

		return null;
	}

	/**
	 * This is the main entry point if you want to modify flags for a page using the edit form.
	 * The request HAS TO BE a POST one and include a `token` parameter that
	 * matches an edit token for $wgUser.
	 *
	 * The request should include:
	 * @requestParam int wiki_id (if not provided a $wgCityId value is used)
	 * @requestParam int page_id
	 * @requestParam string token
	 *
	 * Input fields of the form should have a prefix `editFlags:flag_type_id:`
	 * @see const values in FlagsHelper.class.php
	 *
	 * @return null|bool
	 */
	public function postFlagsEditForm() {
		$this->processRequest();
		if ( !isset( $this->params['pageId'] ) ) {
			$this->response->setException( new \Exception( 'Required param pageId not provided' ) );
			return true;
		}
		$pageId = $this->params['page_id'];

		$title = Title::newFromID( $pageId );
		if ( $title === null ) {
			$this->response->setException( new \Exception( "Article with ID {$this->params['pageId']} doesn't exist" ) );
			return true;
		}

		/**
		 * Get the current status to compare
		 */
		$currentFlags = $this->requestGetFlagsForPageForEdit( $pageId );

		$helper = new FlagsHelper();
		$flagsToChange = $helper->compareDataAndGetFlagsToChange( $currentFlags, $this->params );
		if ( !empty( $flagsToChange ) ) {
			$this->sendRequestsUsingPostedData( $flagsToChange );

			/**
			 * Purge cache values for the page
			 */
			$flagsCache = new FlagsCache();
			$flagsCache->purgeFlagsForPage( $pageId );

			/**
			 * Purge article after updating flags
			 */
			$wikiPage = WikiPage::factory( $title );
			$wikiPage->doPurge();
		}

		/**
		 * Redirect back to article view after saving flags
		 */
		$pageUrl = $title->getFullURL();
		$this->response->redirect( $pageUrl );
		return true;
	}

	/**
	 * A method that wraps performing appropriate actions for flags specified in $flagsToChange.
	 * The array should have one or more of the following indexes:
	 * 1. `toAdd` an array with data for adding new flags
	 * 2. `toUpdate` an array with data for updating the existing flags
	 * 3. `toRemove` an array with IDs of flags to remove
	 * @param Array $flagsToChange an array with three possible nested arrays:
	 */
	private function sendRequestsUsingPostedData( Array $flagsToChange ) {
		/**
		 * Add flags
		 */
		if ( !empty( $flagsToChange['toAdd'] ) ) {
			$flagsToAdd = [
				'wiki_id' => $this->params['wiki_id'],
				'page_id' => $this->params['page_id'],
				'flags' => $flagsToChange['toAdd'],
			];

			if ( $flagModel->verifyParamsForAdd( $flagsToAdd ) ) {
				$flagModel->addFlagsToPage( $flagsToAdd );
			}
		}

		/**
		 * Remove flags
		 */
		if ( !empty( $flagsToChange['toRemove'] ) ) {
			$flagsToRemove = [
				'flagsIds' => $flagsToChange['toRemove'],
			];
			if ( $flagModel->verifyParamsForRemove( $flagsToRemove ) ) {
				$flagModel->removeFlagsFromPage( $flagsToRemove );
			}
		}

		/**
		 * Update flags
		 */
		if ( !empty( $flagsToChange['toUpdate'] ) ) {
			$flagModel->updateFlagsForPage( $flagsToChange['toUpdate'] );
		}
	}

	/**
	 * Sends a request to the FlagsApiController to get data on flags for the given page.
	 * @param int $pageId
	 * @return array
	 */
	private function requestGetFlagsForPage( $pageId ) {
		return $this->sendRequest( 'FlagsApiController',
			'getFlagsForPage',
			[
				'page_id' => $pageId,
			]
		)->getData();
	}

	/**
	 * Sends a request to the FlagsApiController to get data on flag types
	 * with and without instances to display in the edit form.
	 * @param int $pageId
	 * @return array
	 */
	private function requestGetFlagsForPageForEdit( $pageId ) {
		return $this->sendRequest( 'FlagsApiController',
			'getFlagsForPageForEdit',
			[
				'page_id' => $pageId,
			]
		)->getData();
	}

	private function requestAddFlagsToPage( $pageId, $flags ) {
		return $this->sendRequest( 'FlagsApiController',
			'addFlagsToPage',
			[
				'page_id' => $pageId,
				'flags' => $flags,
			]
		)->getData();
	}
}
