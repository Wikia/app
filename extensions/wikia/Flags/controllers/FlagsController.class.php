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

	/**
	 * Prevent modifying ParserOutput twice in the same request
	 *
	 * @see \Flags\Hooks::onBeforeParserCacheSave
	 */
	public static $parsed = false;

	private
		$helper,
		$editFlags;

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

	public function modifyParserOutputWithFlags( ParserOutput $parserOutput, $pageId, $currentFlags = [] ) {
		// Don't output Flags in Mercury for now
		if ( $this->wg->ArticleAsJson ) {
			return $parserOutput;
		}

		$mwf = \MagicWord::get( 'flags' );

		/**
		 * First, get ParserOutput for flags for the article.
		 * If it's null - return the original $parserOutput.
		 */
		if ( !empty( $currentFlags ) ) {
			$flagsParserOutput = $this->getFlagsForParserOutput( $currentFlags, $pageId );
		} else {
			$flagsParserOutput = $this->getFlagsForParserOutputFromDB( $pageId );
		}

		if ( $flagsParserOutput === null ) {
			/**
			 * If there is __FLAGS__ magic word present in the content
			 * replace it with an empty string
			 */
			if ( $mwf->match( $parserOutput->getText() ) ) {
				$parserOutput->setText( $mwf->replace( '', $parserOutput->getText() ) );
			}
			return $parserOutput;
		}

		$pageText = $parserOutput->getText();
		$flagsText = $flagsParserOutput->getText();

		/**
		 * Update the mText of the original ParserOutput object and merge other properties.
		 * If the __FLAGS__ magic word is matched - replace the CSS class of the flags container
		 * to an inline one.
		 */
		if ( $mwf->match( $pageText ) ) {
			$flagsText = $this->makeFlagsInline( $flagsText );
			$pageText = $mwf->replace( $flagsText, $pageText );
		} else {
			$pageText = $flagsText . $pageText;
		}

		$parserOutput->setText( $pageText );

		$parserOutput->mergeExternalParserOutputVars( $flagsParserOutput );

		return $parserOutput;
	}

	/**
	 * Generates html contents for Flags modal for editing flags
	 */
	public function editForm() {
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
			$exceptionDetails = $response->getException()->getDetails();
			$this->setVal(
				'exceptionMessage',
				wfMessage( 'flags-edit-modal-exception' )->params( $exceptionDetails )->parse()
			);
		} elseif ( $this->getResponseStatus( $response ) ) {
			$flags = array_values( $this->getResponseData( $response ) );

			foreach ( $flags as $i => $flag ) {
				$title = Title::newFromText( $flag['flag_view'], NS_TEMPLATE );
				$flags[$i]['flag_view_link'] = Linker::link(
					$title,
					wfMessage( 'flags-edit-form-more-info' )->plain(),
					[
						'target' => '_blank',
					]
				);
			}

			$this->setVal( 'editToken', $this->wg->User->getEditToken() );
			$this->setVal( 'flags', $flags );
			$this->setVal( 'formSubmitUrl', $this->getLocalUrl( 'postFlagsEditForm' ) );
			$this->setVal( 'inputNamePrefix', FlagsHelper::FLAGS_INPUT_NAME_PREFIX );
			$this->setVal( 'inputNameCheckbox', FlagsHelper::FLAGS_INPUT_NAME_CHECKBOX );
			$this->setVal( 'pageId', $pageId );
		} else {
			$this->setVal(
				'emptyMessage',
				wfMessage( 'flags-edit-modal-no-flags-on-community' )->parse()
			);
		}
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
		try {
			$this->skipRendering();

			/**
			 * Validate the request
			 */
			if ( !$this->isValidPostRequest() ) {
				throw new BadRequestApiException();
			}

			$pageId = $this->request->getInt( 'page_id' );
			if ( $pageId === 0 ) {
				throw new MissingParameterApiException( 'page_id' );
			}

			$title = Title::newFromID( $pageId );
			if ( $title === null ) {
				throw new InvalidParameterApiException( 'page_id' );
			}

			/**
			 * Get the current status to compare
			 */
			$currentFlags = $this->getResponseData( $this->requestGetFlagsForPageForEdit( $pageId ) );
			$this->editFlags = $this->request->getArray( 'editFlags' );

			$flagsToChange = $this->getFlagsHelper()->compareDataAndGetFlagsToChange( $currentFlags, $this->editFlags );

			if ( !empty( $flagsToChange ) ) {
				$this->sendRequestsUsingPostedData( $pageId, $flagsToChange );

				/**
				 * Purge article after updating flags and update links
				 */
				$wikiPage = WikiPage::factory( $title );
				$wikiPage->doPurge();

				$parserOptions = ParserOptions::newFromUser( $this->wg->User );
				$parserOutput = $wikiPage->getParserOutput( $parserOptions, null, false );

				$parserOutput = $this->modifyParserOutputWithFlags( $parserOutput, $pageId, $currentFlags );

				self::$parsed = true;

				ParserCache::singleton()->save($parserOutput, $wikiPage, $parserOptions);

				( new LinksUpdate(
					$wikiPage->getTitle(), $parserOutput )
				)->doUpdate();
			}

			/**
			 * Redirect back to article view after saving flags
			 */
			$pageUrl = $title->getFullURL();
			$this->response->redirect( $pageUrl );
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
	 * Transform all flags for the given page from POST data into a set of wikitext templates calls
	 * that are supposed to be injected into Parser before expanding templates.
	 * @param $pageId
	 * @return ParserOutput|null
	 */
	private function getFlagsForParserOutput( $currentFlags, $pageId ) {
		$flagsOnPage = [];

		foreach ( $this->editFlags as $flagTypeId => $flag ) {
			if ( isset( $flag[FlagsHelper::FLAGS_INPUT_NAME_CHECKBOX] ) ) {
				$flagsOnPage[$flagTypeId] = $this->getFlagsHelper()->getFlagFromPostData(
					$currentFlags[$flagTypeId],
					$this->editFlags
				);

				$flagsOnPage[$flagTypeId]['flag_targeting'] = $currentFlags[$flagTypeId]['flag_targeting'];
				$flagsOnPage[$flagTypeId]['flag_view'] = $currentFlags[$flagTypeId]['flag_view'];
			}
		}

		return $this->getParsedFlags( $flagsOnPage, $pageId );
	}

	/**
	 * Sends a request for all instances of flags for the given page.
	 * A result of the request is transformed into a set of wikitext templates calls
	 * that are supposed to be injected into Parser before expanding templates.
	 * @param $pageId
	 * @return ParserOutput|null
	 */
	private function getFlagsForParserOutputFromDB( $pageId ) {
		try {
			$response = $this->requestGetFlagsForPage( $pageId );

			if ( $this->getResponseStatus( $response ) ) {
				$flags = $this->getResponseData( $response );

				return $this->getParsedFlags( $flags, $pageId );
			}

			return null;
		} catch ( Exception $exception ) {
			$this->logResponseException( $exception, $response->getRequest() );
		}
	}

	/**
	 * Wrap and parse flags
	 *
	 * @param Array $flags
	 * @param int $pageId
	 * @return ParserOutput
	 */
	private function getParsedFlags( $flags, $pageId ) {
		$templatesCalls = [];

		$flagView = new FlagView();

		foreach ( $flags as $flag ) {
			$templatesCalls[] = $flagView->wrapSingleFlag(
				$flag['flag_type_id'],
				$flag['flag_targeting'],
				$flag['flag_view'],
				$flag['params']
			);
		}

		return $flagView->renderFlags( $templatesCalls, $pageId );
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
		$editToken = $this->request->getVal( 'edit_token' );
		$responseData = [];

		foreach ( self::$flagsActionsToMethodsMapping as $action => $requestMethodName ) {
			if ( empty( $flagsToChange[$action] ) ) {
				continue;
			}

			$response = $this->$requestMethodName( $editToken, $pageId, $flagsToChange[$action] );

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

	private function getFlagsHelper() {
		if ( empty( $this->helper ) ) {
			$this->helper = new FlagsHelper();
		}

		return $this->helper;
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

	private function makeFlagsInline( $flagsHtml ) {
		return str_replace( FlagView::FLAGS_CSS_CLASS, FlagView::FLAGS_CSS_CLASS_INLINE, $flagsHtml );
	}
}
