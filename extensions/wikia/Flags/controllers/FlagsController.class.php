<?php

/**
 * The public interface of the extension and the main entry point for all requests.
 * It provides a set of CRUD methods to manipulate Flags instances and their types.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

use Flags\FlagsCache;
use Flags\FlagsHelper;
use Flags\Views\FlagView;
use Wikia\Logger\Loggable;

class FlagsController extends WikiaController {

	use Loggable;

	const FLAGS_CONTROLLER_ACTION_ADD = 'toAdd';
	const FLAGS_CONTROLLER_ACTION_REMOVE = 'toRemove';
	const FLAGS_CONTROLLER_ACTION_UPDATE = 'toUpdate';

	public static $flagsActionsToMethodsMapping = [
		self::FLAGS_CONTROLLER_ACTION_ADD => 'requestAddFlagsToPage',
		self::FLAGS_CONTROLLER_ACTION_REMOVE => 'requestRemoveFlagsFromPage',
		self::FLAGS_CONTROLLER_ACTION_UPDATE => 'requestUpdateFlagsForPage',
	];

	private
		$params;

	public function init() {
		global $wgLang;

		/**
		 * $wgLang (and some other global variables) is initialized after first use
		 * We need to force creating proper Language object, because of check
		 * $wgLang instanceof Language (in MWException::useMessageCache)
		 * which has impact on showing or hiding SQL query for DatabaseError exception
		 */
		$wgLang->getLangObj();
	}

	/**
	 * Sends a request for all instances of flags for the given page.
	 * A result of the request is transformed into a set of wikitext templates calls
	 * that are supposed to be injected into Parser before expanding templates.
	 * @param $pageId
	 * @return string
	 */
	public function getFlagsForPageWikitext( $pageId ) {
		wfProfileIn( __METHOD__ );

		try {
			$flagsWikitext = '';

			$response = $this->requestGetFlagsForPage( $pageId );

			if ( $this->getResponseStatus( $response ) ) {
				$templatesCalls = [];
				$flags = $this->getResponseData( $response );

				$flagView = new FlagView();

				foreach ( $flags as $flagId => $flag ) {
					$templatesCalls[] = $flagView->wrapSingleFlag(
						$flag['flag_type_id'],
						$flag['flag_targeting'],
						$flag['flag_view'],
						$flag['params']
					);
				}

				$flagsWikitext = $flagView->wrapAllFlags( $templatesCalls );
			}

			wfProfileOut( __METHOD__ );
			return $flagsWikitext;
		} catch ( Exception $exception ) {
			$this->logResponseException( $exception, $response->getRequest() );
		}
	}

	/**
	 * Generates html contents for Flags modal for editing flags
	 */
	public function editForm() {
		wfProfileIn( __METHOD__ );

		$pageId = $this->request->getVal( 'page_id' );
		if ( empty( $pageId ) ) {
			throw new MissingParameterApiException( 'page_id' );
		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		/**
		 * Disable caching for the rendered HTML. The API response is cached which is enough.
		 */
		$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED, 0 );

		$response = $this->requestGetFlagsForPageForEdit( $pageId );

		if ( $response->hasException() ) {
			$this->overrideTemplate( 'editFormException' );
			$this->setVal( 'exceptionMessage', $response->getException()->getDetails() );
		} elseif ( $this->getResponseStatus( $response ) ) {
			$flags = array_values( $this->getResponseData( $response ) );
			$this->setVal( 'editToken', $this->wg->User->getEditToken() );
			$this->setVal( 'flags', $flags );
			$this->setVal( 'formSubmitUrl', $this->getLocalUrl( 'postFlagsEditForm' ) );
			$this->setVal( 'inputNamePrefix', FlagsHelper::FLAGS_INPUT_NAME_PREFIX );
			$this->setVal( 'inputNameCheckbox', FlagsHelper::FLAGS_INPUT_NAME_CHECKBOX );
			$this->setVal( 'moreInfo', wfMessage( 'flags-edit-form-more-info' )->escaped() );
			$this->setVal( 'pageId', $pageId );
		} else {
			$this->overrideTemplate( 'editFormEmpty' );
		}

		wfProfileOut( __METHOD__ );
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
	 * @return bool|null
	 * @throws Exception
	 */
	public function postFlagsEditForm() {
		wfProfileIn( __METHOD__ );
		try {
			$this->skipRendering();

			/**
			 * Validate the request
			 */
			if ( !$this->isValidPostRequest() ) {
				throw new BadRequestApiException();
			}

			$this->params = $this->request->getParams();
			if ( !isset( $this->params['page_id'] ) ) {
				throw new MissingParameterApiException( 'page_id' );
			}
			$pageId = $this->params['page_id'];

			$title = Title::newFromID( $pageId );
			if ( $title === null ) {
				throw new InvalidParameterApiException( 'page_id' );
			}

			/**
			 * Get the current status to compare
			 */
			$currentFlags = $this->getResponseData( $this->requestGetFlagsForPageForEdit( $pageId ) );

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

			wfProfileOut( __METHOD__ );
		} catch ( MWException $exception ) {
			if ( $title === null ) {
				throw $exception;
			}

			/**
			 * Show a friendly error message to a user after redirect
			 */
			BannerNotificationsController::addConfirmation(
				wfMessage( 'flags-edit-modal-post-exception' )
					->params( $exception->getText() )
					->parse(),
				BannerNotificationsController::CONFIRMATION_ERROR,
				true
			);

			$pageUrl = $title->getFullURL();
			$this->response->redirect( $pageUrl );
		}
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
	 * @throws MissingParameterApiException
	 */
	private function sendRequestsUsingPostedData( $pageId, Array $flagsToChange ) {
		if ( !isset( $this->params['edit_token'] ) ) {
			throw new MissingParameterApiException( 'edit_token' );
		}

		$responseData = [];

		foreach ( self::$flagsActionsToMethodsMapping as $action => $requestMethodName ) {
			if ( empty( $flagsToChange[$action] ) ) {
				continue;
			}

			$response = $this->$requestMethodName( $this->params['edit_token'], $pageId, $flagsToChange[$action] );

			if ( $response->hasException() ) {
				throw $response->getException();
			} elseif ( $this->getResponseStatus( $response ) ) {
				$responseData[$action] = $this->getResponseData( $response );
			} else {
				$responseData[$action] = $this->getResponseStatus( $response );
			}
		}

		return $responseData;
	}

	/**
	 * Checks if a request is a POST one and if it carries a valid edit_token for the user.
	 * @return bool
	 */
	private function isValidPostRequest() {
		return $this->request->wasPosted()
		&& $this->wg->User->matchEditToken( $this->getVal( 'edit_token' ) );
	}

	/**
	 * Sends a request to the FlagsApiController to get data on flags for the given page.
	 * @param int $pageId
	 * @return WikiaResponse
	 */
	private function requestGetFlagsForPage( $pageId ) {
		return $this->sendRequestAcceptExceptions( 'FlagsApiController',
			'getFlagsForPage',
			[
				'page_id' => $pageId,
			]
		);
	}

	/**
	 * Sends a request to the FlagsApiController to get data on flag types
	 * with and without instances to display in the edit form.
	 * @param int $pageId
	 * @return WikiaResponse
	 */
	private function requestGetFlagsForPageForEdit( $pageId ) {
		return $this->sendRequestAcceptExceptions( 'FlagsApiController',
			'getFlagsForPageForEdit',
			[
				'page_id' => $pageId,
			]
		);
	}

	/**
	 * Sends a request to the FlagsApiController with data on flags to add to the page.
	 * @param $editToken
	 * @param $pageId
	 * @param $flags
	 * @return WikiaResponse
	 * @see FlagsApiController::addFlagsToPage() for a structure of the $flags array
	 */
	private function requestAddFlagsToPage( $editToken, $pageId, $flags ) {
		return $this->sendRequestAcceptExceptions( 'FlagsApiController',
			'addFlagsToPage',
			[
				'edit_token' => $editToken,
				'page_id' => $pageId,
				'flags' => $flags,
			]
		);
	}

	/**
	 * Sends a request to the FlagsApiController with data on flags to add to the page.
	 * @param $editToken
	 * @param $pageId
	 * @param $flags
	 * @return WikiaResponse
	 * @see FlagsApiController::removeFlagsFromPage() for a structure of the $flagsIds array
	 */
	private function requestRemoveFlagsFromPage( $editToken, $pageId, $flags ) {
		return $this->sendRequestAcceptExceptions( 'FlagsApiController',
			'removeFlagsFromPage',
			[
				'edit_token' => $editToken,
				'page_id' => $pageId,
				'flags' => $flags,
			]
		);
	}

	/**
	 * Sends a request to the FlagsApiController with data on flags to update on the page.
	 * @param $editToken
	 * @param $pageId
	 * @param $flags
	 * @return WikiaResponse
	 * @see FlagsApiController::updateFlagsForPage() for a structure of the $flags array
	 */
	private function requestUpdateFlagsForPage( $editToken, $pageId, $flags ) {
		return $this->sendRequestAcceptExceptions( 'FlagsApiController',
			'updateFlagsForPage',
			[
				'edit_token' => $editToken,
				'page_id' => $pageId,
				'flags' => $flags
			]
		);
	}

	private function getResponseData( WikiaResponse $response ) {
		return $response->getData()[FlagsApiController::FLAGS_API_RESPONSE_DATA];
	}

	private function getResponseStatus( WikiaResponse $response ) {
		return $response->getData()[FlagsApiController::FLAGS_API_RESPONSE_STATUS];
	}

	private function logResponseException( Exception $e, WikiaRequest $request ) {
		$this->error(
			'FlagsLog Exception',
			[
				'exception' => $e,
				'prms' => $request->getParams(),
			]
		);
	}
}
