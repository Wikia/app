<?php

/**
 * The public interface of the extension and the main entry point for all requests.
 * It provides a set of CRUD methods to manipulate Flags instances and their types.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

use Flags\FlaggedPagesCache;
use Flags\FlagsApiBaseController;
use Flags\FlagsCache;
use Flags\FlagsLogTask;
use Flags\Models\Flag;
use Flags\Models\FlagType;
use Flags\FlagsHelper;

class FlagsApiController extends FlagsApiBaseController {

	/**
	 * Messages generated using following constants
	 * logentry-flags-flag-added
	 * logentry-flags-flag-removed
	 */
	const LOG_ACTION_FLAG_ADDED = 'flag-added';
	const LOG_ACTION_FLAG_REMOVED = 'flag-removed';

	/**
	 * Article level API
	 */

	/**
	 * Retrieves all data for flags assigned to the given page
	 * with an intent of rendering them. To get all types of flags:
	 * @see getFlagsForPageForEdit()
	 *
	 * @requestParam int wiki_id (optional) You can overwrite a default wiki_id with it
	 * @requestParam int page_id
	 * @response Array A list of flags with flag_type_id values as indexes.
	 *  One item contains the following fields:
	 *	 	int flag_id
	 * 		int flag_type_id
	 * 		int wiki_id
	 *		int page_id
	 * 		int flag_group
	 * 		string flag_name
	 * 		string flag_view
	 * 		int flag_targeting
	 * 		string|null flag_params_names
	 *
	 * 	@if flag_params_names is not empty
	 * 		params = [
	 * 			param_name => param_value
	 *		]
	 */
	public function getFlagsForPage() {
		try {
			$this->getRequestParams();
			$this->validatePageId();

			$flagsForPage = $this->getFlagsForPageRawData( $this->params['wiki_id'], $this->params['page_id'] );

			$this->makeSuccessResponse( $flagsForPage );
		} catch ( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Retrieves all data for all flag types available on the given wikia
	 * with an intent of rendering a modal with an edit form.
	 * It returns the types with instances on the page first and then all
	 * other types sorted alphabetically.
	 * To retrieve only types with instances on the given page:
	 * @see getFlagsForPage()
	 *
	 * @requestParam int wiki_id (optional) You can overwrite a default wiki_id with it
	 * @requestParam int page_id
	 * @response Array A list of flags with flag_type_id values as indexes.
	 *  One item contains the following fields:
	 * @if The page has an instance of the flag type
	 *	 	int flag_id
	 *
	 * 		int flag_type_id
	 * 		int wiki_id
	 *		int page_id
	 * 		int flag_group
	 * 		string flag_name
	 * 		string flag_view A name of a template of the flag
	 * 		int flag_targeting
	 * 		string|null flag_params_names
	 *
	 * 	@if flag_params_names is not empty
	 * 		params = [
	 * 			param_name => param_value
	 *		]
	 */
	public function getFlagsForPageForEdit() {
		try {
			$this->getRequestParams();
			$this->validatePageId();

			$allFlagTypes = $this->getAllFlagTypes( $this->params['wiki_id'], $this->params['page_id'] );

			$this->makeSuccessResponse( $allFlagTypes );
		} catch ( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Adds flags to the given page. It accepts only POST requests
	 * with a valid User edit token.
	 *
	 * Required parameters:
	 * @requestParam int page_id
	 * @requestParam array flags
	 * @requestParam int flags[]['flag_type_id'] An ID of a flag type
	 *
	 * Optional parameters:
	 * @requestParam int wiki_id You can overwrite the current city_id
	 * @requestParam array flags[]['params'] An array of params structured like:
	 * [
	 * 	'paramName1' => 'paramValue1',
	 * 	'paramName2' => 'paramValue2',
	 * ]
	 */
	public function addFlagsToPage() {
		try {
			$this->processRequest();

			$flagModel = new Flag();
			$modelResponse = $flagModel->addFlagsToPage( $this->params );

			$this->getCache()->purgeFlagsForPage( $this->params['page_id'] );
			$this->purgeFlaggedPages( $this->params['flags'] );
			$this->purgeFlagInsights( $this->params['flags'] );

			$this->makeSuccessResponse( $modelResponse );
			$this->logFlagChange( $this->params['flags'], $this->params['wiki_id'], $this->params['page_id'], self::LOG_ACTION_FLAG_ADDED );
		} catch ( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Removes flags from the given page. It accepts only POST requests
	 * with a valid User edit token.
	 *
	 * Required parameters:
	 * @requestParam array flags_ids An array of IDs of flags to remove
	 * @requestParam int page_id
	 */
	public function removeFlagsFromPage() {
		try {
			$this->processRequest();
			$this->validatePageId();

			$flagModel = new Flag();
			$modelResponse = $flagModel->removeFlagsFromPage( $this->params['flags'] );

			$this->getCache()->purgeFlagsForPage( $this->params['page_id'] );
			$this->purgeFlaggedPages( $this->params['flags'] );
			$this->purgeFlagInsights( $this->params['flags'], $this->params['page_id'] );

			$this->makeSuccessResponse( $modelResponse );
			$this->logFlagChange( $this->params['flags'], $this->params['wiki_id'], $this->params['page_id'], self::LOG_ACTION_FLAG_REMOVED );
		} catch ( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Updates flags on the given page using a `flags` array passed as a request parameter.
	 *
	 * @requestParam int page_id
	 * @requestParam array $flags Should have flag_id values as indexes
	 *
	 * @return bool
	 */
	public function updateFlagsForPage() {
		try {
			$this->processRequest();
			$this->validatePageId();

			if ( !isset( $this->params['page_id'] ) ) {
				throw new \MissingParameterApiException( 'page_id' );
			}

			$oldFlags = $this->app->sendRequest(
				'FlagsApiController',
				'getFlagsForPage',
				[ 'page_id' => $this->params['page_id'] ]
			)->getData();

			$flagModel = new Flag();
			$modelResponse = $flagModel->updateFlagsForPage( $this->params['flags'] );

			$this->getCache()->purgeFlagsForPage( $this->params['page_id'] );

			$this->makeSuccessResponse( $modelResponse );
			$this->logParametersChange( $oldFlags, $this->params['flags'], $this->params['wiki_id'], $this->params['page_id'] );
		} catch ( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Flag type level API
	 */

	/**
	 * Adds a new type of flags.
	 *
	 * Required parameters:
	 * @requestParam int wiki_id
	 * @requestParam int flag_group One of the keys in flagGroups property of the FlagType model
	 * @requestParam string flag_name A name of the flag (not longer than 128 characters)
	 * @requestParam string flag_view A title of a template used for rendering the flag
	 * @requestParam int flag_targeting A level of targeting: 1 -> readers, 2 -> contibutors, 3 -> admins
	 *
	 * Optional parameters:
	 * @requestParam boolean fetch_params if set to true, tries to fetch all variables
	 * 		in template passed via flag_view parameter
	 * @requestParam string flag_params_names A JSON-encoded array of names of parameters
	 * 		It's used for rendering inputs in the "Add a flag" form.
	 */
	public function addFlagType() {
		$this->checkAdminPermissions();

		try {
			$this->processRequest();

			$fetchParams = $this->request->getBool( 'fetch_params' );

			if ( $fetchParams && !empty( $this->params['flag_view'] ) ) {
				$params = $this->getTemplateVariables( $this->params['flag_view'] );

				$flagParams = json_decode( $this->params['flag_params_names'], true );

				foreach ( $flagParams as $param => $description ) {
					$params[$param] = $description;
				}

				$this->params['flag_params_names'] = json_encode( $params, JSON_FORCE_OBJECT );
			}

			$flagTypeModel = new FlagType();
			$modelResponse = $flagTypeModel->addFlagType( $this->params );

			$this->getCache()->purgeFlagTypesForWikia();

			$this->makeSuccessResponse( $modelResponse );
		} catch ( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Fetch template variables from template markup
	 *
	 * Required parameters:
	 * @requestParam string flag_view A title of a template used for rendering the flag
	 */
	public function getFlagParamsFromTemplate() {
		try {
			$this->getRequestParams();

			if ( empty( $this->params['flag_view'] ) ) {
				throw new MissingParameterApiException( 'flag_view' );
			}

			$params = $this->getTemplateVariables( $this->params['flag_view'] );

			$this->makeSuccessResponse( $params );
		} catch( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Fetch template variables from template markup
	 *
	 * @param string $template name of template treated as view and source of params
	 * @return Array parameters
	 */
	private function getTemplateVariables( $template ) {
		$params = [];

		$title = \Title::newFromText( $template, NS_TEMPLATE );
		if ( ! $title instanceof Title ) {
			return [];
		}

		$article = new \Article( $title );
		if ( !$article->exists() ) {
			return [];
		}

		$flagParams = ( new \TemplateDataExtractor( $title ) )->getTemplateVariables( $article->getContent() );

		if ( !empty( $flagParams ) ) {
			foreach ( $flagParams as $paramName => $paramData ) {
				$params[$paramName] = '';
			}
		}

		return $params;
	}

	/**
	 * Removes a type of flags.
	 *
	 * Required parameters:
	 * @requestParam int flag_type_id
	 *
	 * IMPORTANT!
	 * When using this method be aware that it removes ALL instances of this type
	 * of flags with ALL of their parameters per the database's configuration.
	 */
	public function removeFlagType() {
		$this->checkAdminPermissions();

		try {
			$this->processRequest();

			$flagTypeModel = new FlagType();
			$modelResponse = $flagTypeModel->removeFlagType( $this->params );

			$this->getCache()->purgeFlagTypesForWikia();
			$this->purgePagesWithFlag( $this->params['flag_type_id'] );

			$this->makeSuccessResponse( $modelResponse );
		} catch( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Updates a flag type
	 *
	 * Required parameters:
	 * @requestParam int flag_type_id
	 *
	 * Optional parameters:
	 * @requestParam int flag_group One of the keys in flagGroups property of the FlagType model
	 * @requestParam string flag_name A name of the flag (not longer than 128 characters)
	 * @requestParam string flag_view A title of a template used for rendering the flag
	 * @requestParam int flag_targeting A level of targeting: 1 -> readers, 2 -> contibutors, 3 -> admins
	 * @requestParam string flags_params_names parameters names with its descriptions in JSON format
	 */
	public function updateFlagType() {
		$this->checkAdminPermissions();

		try {
			$this->processRequest();

			$flagTypeModel = new FlagType();
			$modelResponse = $flagTypeModel->updateFlagType( $this->params );

			$this->getCache()->purgeFlagTypesForWikia();
			$this->purgePagesWithFlag( $this->params['flag_type_id'] );

			$this->makeSuccessResponse( $modelResponse );
		} catch ( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Updates parameters assigned to a given type of flags.
	 *
	 * Required parameters:
	 * @requestParam int flag_type_id
	 * @requestParam string flags_params_names parameters names with its descriptions in JSON format
	 */
	public function updateFlagTypeParameters() {
		$this->checkAdminPermissions();

		try {
			$this->processRequest();

			$flagTypeModel = new FlagType();
			$modelResponse = $flagTypeModel->updateFlagTypeParameters( $this->params );

			$this->getCache()->purgeFlagTypesForWikia();
			$this->purgePagesWithFlag( $this->params['flag_type_id'] );

			$this->makeSuccessResponse( $modelResponse );
		} catch ( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Get all flag types for given wiki
	 *
	 * Optional parameters:
	 * @requestParam int wiki_id (optional) You can overwrite the current city_id
	 * @requestParam int flag_targeting (optional) @see FlagType::{flag_targeting constants}
	 *
	 * @response Array all flag types
	 */
	public function getFlagTypes() {
		try {
			$this->getRequestParams();

			$flagTypes = $this->getFlagTypesForWikiaRawData(
				$this->params['wiki_id'],
				$this->params['flag_targeting']
			);

			$this->makeSuccessResponse( $flagTypes );
		} catch( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Get flag type id by template (view) name
	 *
	 * Required parameter:
	 * @requestParam string flag_view
	 *
	 * Optional parameters:
	 * @requestParam int wiki_id You can overwrite the current city_id
	 *
	 * @return int|null
	 */
	public function getFlagTypeIdByTemplate() {
		try {
			$this->getRequestParams();

			if ( empty( $this->params['flag_view'] ) ) {
				throw new MissingParameterApiException( 'flag_view' );
			}

			$flagTypeModel = new FlagType();
			$flagTypeId = $flagTypeModel->getFlagTypeIdByTemplate( $this->params['wiki_id'], $this->params['flag_view']);

			$this->makeSuccessResponse( $flagTypeId );
		} catch( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Get pages ids on which given flag type is enabled
	 *
	 * Required parameter:
	 * @requestParam string flag_type_id
	 *
	 * @return array|null
	 */
	public function getPagesWithFlag() {
		try {
			$this->getRequestParams();

			if ( empty( $this->params['flag_type_id'] ) ) {
				throw new MissingParameterApiException( 'flag_type_id' );
			}

			$flagTypeModel = new FlagType();
			$pagesIds = $flagTypeModel->getPagesWithFlag( $this->params['flag_type_id'] );

			$this->makeSuccessResponse( $pagesIds );
		} catch( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Private methods
	 */

	/**
	 * Returns a singleton instance of FlagsCache
	 * @return FlagsCache
	 */
	protected function getNewCacheInstance() {
		return new FlagsCache();
	}

	/**
	 * Private methods
	 */

	private function validatePageId() {
		if ( !isset( $this->params['page_id'] ) ) {
			throw new MissingParameterApiException( 'page_id' );
		}
		if ( !is_numeric( $this->params['page_id'] ) ) {
			throw new InvalidParameterApiException( 'page_id' );
		}
	}

	/**
	 * To prevent CSRF attacks it checks if a request is a POST one
	 * and if a sent token matches the user's one.
	 * Calls getRequestParams if the request is valid.
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	private function processRequest() {
		if ( !$this->request->isInternal() ) {
			if ( !$this->request->wasPosted() ) {
				throw new BadRequestApiException;
			}
			if ( !$this->wg->User->matchEditToken( $this->getVal( 'edit_token' ) ) ) {
				throw new MissingParameterApiException( 'edit_token' );
			}
		}
		$this->getRequestParams();
	}

	private function purgeFlaggedPages( Array $flags = [] ) {
		$flagTypesIds = $this->prepareFlagTypesIds( $flags );

		if ( !empty( $flagTypesIds ) ) {
			( new FlaggedPagesCache() )->purgeFlagTypesByIds( $flagTypesIds );
		} else {
			( new FlaggedPagesCache() )->purgeAllFlagTypes();
		}
	}

	private function purgeFlagInsights( Array $flags = [], $pageId = null ) {
		global $wgEnableInsightsExt;

		if ( !empty( $wgEnableInsightsExt ) ) {
			$flagsIds = $this->prepareFlagTypesIds( $flags );

			$insightsFlagsModel = new InsightsFlagsModel();

			foreach ( $flagsIds as $flagId ) {
				$insightsFlagsModel->initModel( [ 'flagTypeId' => $flagId ] );
				if ( !is_null( $pageId ) ) {
					$insightsFlagsModel->updateInsightsCache( $pageId );
				} else {
					$insightsFlagsModel->purgeInsightsCache();
				}
			}
		}
	}

	private function prepareFlagTypesIds( Array $flags ) {
		$flagTypesIds = [];

		foreach ( $flags as $flag ) {
			if ( !empty( $flag['flag_type_id'] ) ) {
				$flagTypesIds[] = $flag['flag_type_id'];
			}
		}

		return $flagTypesIds;
	}

	/**
	 * Tries to get the data on Flags instances for the given page from cache.
	 * If it is not cached it gets it from the database and caches it.
	 * @param $wikiId
	 * @param $pageId
	 * @return bool|mixed
	 */
	private function getFlagsForPageRawData( $wikiId, $pageId ) {
		$flagsCache = $this->getCache();
		$flagsForPage = $flagsCache->getFlagsForPage( $pageId );

		if ( !$flagsForPage ) {
			$flagModel = new Flag();
			$flagsForPage = $flagModel->getFlagsForPage( $wikiId, $pageId );

			$flagsCache->setFlagsForPage( $pageId, $flagsForPage );
		}

		return $flagsForPage;
	}

	/**
	 * Tries to get the data on types of flags available for the given wikia from cache.
	 * If it is not cached it gets it from the database and caches it.
	 * @param int $wikiId
	 * @param int $targeting @see FlagType::{flag_targeting constants}
	 * @return bool|mixed
	 */
	private function getFlagTypesForWikiaRawData( $wikiId, $targeting = 0 ) {
		$flagsCache = $this->getCache();

		$flagTypesForWikia = $flagsCache->getFlagTypesForWikia( $targeting );
		if ( !$flagTypesForWikia ) {
			$flagTypeModel = new FlagType();
			$flagTypesForWikia = $flagTypeModel->getFlagTypesForWikia( $wikiId, $targeting );

			$flagsCache->setFlagTypesForWikia( $flagTypesForWikia, $targeting );
		}

		return $flagTypesForWikia;
	}

	/**
	 * A method that combines data from two models - Flag and FlagTypes.
	 * The Flag model gives it data on instances of flags assigned to the given page.
	 * The FlagType model provides data on every type of a flag available on the wikia.
	 * The union operator used on arrays lets us safely merge these two arrays.
	 * In case of an index duplication it preserves an item from the left array and adds a new
	 * item if an index is not set.
	 *
	 * @param $wikiId
	 * @param $pageId
	 * @return Array An array of all types of flags, with and without instances
	 */
	private function getAllFlagTypes( $wikiId, $pageId ) {
		$flagsForPage = $this->getFlagsForPageRawData( $wikiId, $pageId );
		$flagTypesForWikia = $this->getFlagTypesForWikiaRawData( $wikiId );

		return $flagsForPage + $flagTypesForWikia;
	}

	/**
	 * Tries to get groups and targeting of flags available for the given wikia
	 */
	public function getGroupsAndTargetingAsJson() {
		$this->response->setVal( 'groups', array_values( FlagsHelper::getFlagGroupsFullNames() ) );
		$this->response->setVal( 'targeting', array_values( FlagsHelper::getFlagTargetFullNames() ) );
	}

	/**
	 * Logging methods
	 */
	/**
	 * Queue task for logging flag change
	 * @param array $flags list of flags changed, each item of that list is an array with flag fields as items
	 * @param int $wikiId ID of wiki where flags were changed
	 * @param int $pageId ID of article where flags were changed
	 * @param string $actionType Type of action performed on flag represented by constants in \FlagsApiController class
	 */
	private function logFlagChange( Array $flags, $wikiId, $pageId, $actionType ) {
		$task = new FlagsLogTask();
		$task->wikiId( $wikiId );
		$task->createdBy( $this->wg->User->getId() );
		$task->execute( 'logFlagChange', [ $flags, $pageId, $actionType ] );
	}

	/**
	 * Queue task for logging flag parameters change
	 *
	 * @param Array $oldFlags flags values before update
	 * @param Array $flags new flags values
	 * @param int $wikiId
	 * @param int $pageId
	 */
	private function logParametersChange( Array $oldFlags, Array $flags, $wikiId, $pageId ) {
		$task = new FlagsLogTask();
		$task->wikiId( $wikiId );
		$task->createdBy( $this->wg->User->getId() );
		$task->execute( 'logParametersChange', [ $oldFlags, $flags, $pageId ] );
	}

	/**
	 * Purges the data on instances of flags for all pages on which given flag is enabled
	 *
	 * @param int $flagTypeId
	 */
	private function purgePagesWithFlag( $flagTypeId ) {
		$pagesIds = $this->app->sendRequest(
			'FlagsApiController',
			'getPagesWithFlag',
			[ 'flag_type_id' => $flagTypeId ]
		)->getData();

		if ( $pagesIds[self::FLAGS_API_RESPONSE_STATUS] ) {
			$this->getCache()->purgeFlagsForPages( $pagesIds[self::FLAGS_API_RESPONSE_DATA] );
		}
	}

	private function checkAdminPermissions() {
		if ( !$this->wg->user->isAllowed( 'flags-administration' ) ) {
			throw new PermissionsException( 'flags-administration' );
		}
	}
}
