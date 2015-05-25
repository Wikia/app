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

	private function isValidPostRequest() {
		return $this->request->wasPosted()
		&& $this->wg->User->matchEditToken( $this->getVal( 'edit_token' ) );
	}

	/**
	 * Sends a request for all instances of flags for the given page.
	 * A result of the request is transformed into a set of wikitext templates calls
	 * that are supposed to be injected into Parser before expanding templates.
	 * @param $pageId
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
	 * Generates html contents for Flags modal for editing flags
	 */
	public function editForm() {
		$pageId = $this->request->getVal( 'page_id' );
		if ( empty( $pageId ) ) {
			$this->response->setException( new \Exception( 'Required param page_id not provided' ) );
			return true;
		}

		$flags = $this->requestGetFlagsForPageForEdit( $pageId );

		$this->setVal( 'edit_token', $this->wg->User->getEditToken() );
		$this->setVal( 'flags', $flags );
		$this->setVal( 'form_submit_url', $this->getLocalUrl( 'postFlagsEditForm' ) );
		$this->setVal( 'input_name_prefix', FlagsHelper::FLAGS_INPUT_NAME_PREFIX );
		$this->setVal( 'input_name_checkbox', FlagsHelper::FLAGS_INPUT_NAME_CHECKBOX );
		$this->setVal( 'page_id', $pageId );

		$this->response->setFormat( 'html' );
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
		if ( !$this->isValidPostRequest() || !isset( $this->params['page_id'] ) ) {
			return null;
		}
		$this->params = $this->request->getParams();
		$pageId = $this->params['page_id'];

		$title = Title::newFromID( $pageId );
		if ( $title === null ) {
			$this->response->setException( new \Exception( "Article with ID {$pageId} doesn't exist" ) );
			return true;
		}

		/**
		 * Get the current status to compare
		 */
		$currentFlags = $this->requestGetFlagsForPageForEdit( $pageId );

		$helper = new FlagsHelper();
		$flagsToChange = $helper->compareDataAndGetFlagsToChange( $currentFlags, $this->params );
		if ( !empty( $flagsToChange ) ) {
			$this->sendRequestsUsingPostedData( $pageId, $flagsToChange );

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
	 * @param int $pageId
	 * @param Array $flagsToChange an array with three possible nested arrays:
	 * @return null
	 */
	private function sendRequestsUsingPostedData( $pageId, Array $flagsToChange ) {
		if ( !isset( $this->params['edit_token'] ) ) {
			return null;
		}
		$editToken = $this->params['edit_token'];

		/**
		 * Add flags
		 */
		if ( !empty( $flagsToChange['toAdd'] ) ) {
			$this->requestAddFlagsToPage( $editToken, $pageId, $flagsToChange['toAdd'] );
		}

		/**
		 * Remove flags
		 */
		if ( !empty( $flagsToChange['toRemove'] ) ) {
			$this->requestRemoveFlagsFromPage( $editToken, $pageId, $flagsToChange['toRemove'] );
		}

		/**
		 * Update flags
		 */
		if ( !empty( $flagsToChange['toUpdate'] ) ) {
			$this->requestUpdateFlagsForPage( $editToken, $pageId, $flagsToChange['toUpdate'] );
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

	/**
	 * Sends a request to the FlagsApiController with data on flags to add to the page.
	 * @param $editToken
	 * @param $pageId
	 * @param $flags
	 * @return array
	 * @see FlagsApiController::addFlagsToPage() for a structure of the $flags array
	 */
	private function requestAddFlagsToPage( $editToken, $pageId, $flags ) {
		return $this->sendRequest( 'FlagsApiController',
			'addFlagsToPage',
			[
				'edit_token' => $editToken,
				'page_id' => $pageId,
				'flags' => $flags,
			]
		)->getData();
	}

	/**
	 * Sends a request to the FlagsApiController with data on flags to add to the page.
	 * @param $editToken
	 * @param $pageId
	 * @param $flags
	 * @return array
	 * @see FlagsApiController::removeFlagsFromPage() for a structure of the $flagsIds array
	 */
	private function requestRemoveFlagsFromPage( $editToken, $pageId, $flags ) {
		return $this->sendRequest( 'FlagsApiController',
			'removeFlagsFromPage',
			[
				'edit_token' => $editToken,
				'page_id' => $pageId,
				'flags' => $flags,
			]
		)->getData();
	}

	/**
	 * Sends a request to the FlagsApiController with data on flags to update on the page.
	 * @param $editToken
	 * @param $pageId
	 * @param $flags
	 * @return array
	 * @see FlagsApiController::updateFlagsForPage() for a structure of the $flags array
	 */
	private function requestUpdateFlagsForPage( $editToken, $pageId, $flags ) {
		return $this->sendRequest( 'FlagsApiController',
		'updateFlagsForPage',
		[
			'edit_token' => $editToken,
			'page_id' => $pageId,
			'flags' => $flags
		]
		)->getData();
	}
}
