<?php

/**
 * The public interface of the extension and the main entry point for all requests.
 * It provides a set of CRUD methods to manipulate Flags instances and their types.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

use Flags\Exceptions;
use Flags\FlagsCache;
use Flags\Models\Flag;
use Flags\Models\FlagType;

class FlagsApiController extends WikiaApiController {
	const FLAGS_API_RESPONSE_STATUS = 'status';
	const FLAGS_API_RESPONSE_DATA = 'data';
	const FLAGS_API_RESPONSE_DETAILS = 'details';

	private
		$cache,
		$params,
		$status = false;

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
			if ( !isset( $this->params['page_id'] ) ) throw new MissingParameterApiException( 'page_id' );

			$flagsForPage = $this->getFlagsForPageRawData( $this->params['wiki_id'], $this->params['page_id'] );

			$this->makeSuccessResponse( $flagsForPage );
		} catch ( Exception $e ) {
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
	 * 		string flag_view_url A full URL of the template
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
			if ( !isset( $this->params['page_id'] ) ) throw new MissingParameterApiException( 'page_id' );
			$allFlagTypes = $this->getAllFlagTypes( $this->params['wiki_id'], $this->params['page_id'] );
			( new Flags\Models\FlagsBaseModel() )->debug( $allFlagTypes );

			$this->setResponseData( $allFlagTypes );
		} catch ( Exception $e ) {
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

			if ( $flagModel->verifyParamsForAdd( $this->params ) ) {
				$this->status = $flagModel->addFlagsToPage( $this->params );
			}

			$this->setVal( 'status', $this->status );
		} catch ( Exception $e ) {
			$this->response->setException( $e );
		}
	}

	/**
	 * Removes flags from the given page. It accepts only POST requests
	 * with a valid User edit token.
	 *
	 * Required parameters:
	 * @requestParam array flags_ids An array of IDs of flags to remove
	 */
	public function removeFlagsFromPage() {
		try {
			$this->processRequest();

			$flagModel = new Flag();
			$modelResponse = $flagModel->removeFlagsFromPage( $this->params['flags_ids'] );

			$this->makeSuccessResponse( $modelResponse );
		} catch ( Exception $e ) {
			$this->response->setException( $e );
		}
	}

	/**
	 * Updates flags on the given page using a `flags` array passed as a request parameter.
	 * @return bool
	 */
	public function updateFlagsForPage() {
		try {
			$this->processRequest();

			$flagModel = new Flag();
			$modelResponse = $flagModel->updateFlagsForPage( $this->params['flags'] );

			$this->makeSuccessResponse( $modelResponse );
		} catch ( Exception $e ) {
			$this->response->setException( $e );
			return;
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
	 * @requestParam int flag_targeting A level of targeting: 0 -> readers, 1 -> contibutors, 2 -> admins
	 *
	 * Optional parameters:
	 * @requestParam string flagParamsNames A JSON-encoded array of names of parameters
	 * 		It's used for rendering inputs in the "Add a flag" form.
	 */
	public function addFlagType() {
		try {
			$this->processRequest();

			$flagTypeModel = new FlagType();
			$modelResponse = $flagTypeModel->addFlagType( $this->params );

			$this->makeSuccessResponse( $modelResponse );
		} catch ( Exception $e ) {
			$this->response->setException( $e );
		}
	}

	/**
	 * Removes a type of flags.
	 *
	 * Required parameters:
	 * @requestParam int flagTypeId
	 *
	 * IMPORTANT!
	 * When using this method be aware that it removes ALL instances of this type
	 * of flags with ALL of their parameters per the database's configuration.
	 */
	public function removeFlagType() {
		try {
			$this->processRequest();

			$flagTypeModel = new FlagType();
			$modelResponse = $flagTypeModel->removeFlagType( $this->params );

			$this->makeSuccessResponse( $modelResponse );
		} catch( Exception $e ) {
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
	private function getCache() {
		if ( !isset( $this->cache ) ) {
			$this->cache = new FlagsCache();
		}

		return $this->cache;
	}

	/**
	 * Assigns a request's parameters to the object's property
	 * and sets a wiki_id if it hasn't been specified as one
	 * of the parameters.
	 */
	private function getRequestParams() {
		$this->params = $this->request->getParams();
		if ( !isset( $this->params['wiki_id'] ) ) {
			$this->params['wiki_id'] = $this->wg->CityId;
		}
	}

	/**
	 * To prevent CSRF attacks it checks if a request is a POST one
	 * and if a sent token matches the user's one.
	 * Calls getRequestParams if the request is valid.
	 * @throws BadRequestApiException
	 * @throws MissingParameterApiException
	 */
	private function processRequest() {
		if ( !$this->request->isInternal() ) {
			if ( !$this->request->wasPosted() ) throw new BadRequestApiException;
			if ( !$this->wg->User->matchEditToken( $this->getVal( 'edit_token' ) ) ) {
				throw new MissingParameterApiException( 'edit_token' );
			}
		}
		$this->getRequestParams();
	}

	private function makeSuccessResponse( $data ) {
		$this->response->setValues( [
			self::FLAGS_API_RESPONSE_STATUS => true,
			self::FLAGS_API_RESPONSE_DATA => $data,
		] );
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
	 * @param $wikiId
	 * @return bool|mixed
	 */
	private function getFlagTypesForWikiaRawData( $wikiId ) {
		$flagsCache = $this->getCache();

		$flagTypesForWikia = $flagsCache->getFlagTypesForWikia();
		if ( !$flagTypesForWikia ) {
			$flagTypeModel = new FlagType();
			$flagTypesForWikia = $flagTypeModel->getFlagTypesForWikia( $wikiId );

			$flagsCache->setFlagTypesForWikia( $flagTypesForWikia );
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
}
