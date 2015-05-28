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
use Flags\Models\Flag;
use Flags\Models\FlagType;

class FlagsApiController extends WikiaApiController {
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
	 * @requestParam int wiki_id
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
		$this->getRequestParams();

		if ( !isset( $this->params['page_id'] ) ) {
			return null;
		}

		$flagsForPage = $this->getFlagsForPageRawData( $this->params['wiki_id'], $this->params['page_id'] );

		$this->setResponseData( $flagsForPage );
	}

	/**
	 * Retrieves all data for all flag types available on the given wikia
	 * with an intent of rendering a modal with an edit form.
	 * It returns the types with instances on the page first and then all
	 * other types sorted alphabetically.
	 * To retrieve only types with instances on the given page:
	 * @see getFlagsForPage()
	 *
	 * @requestParam int wiki_id
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
		$this->getRequestParams();

		if ( !isset( $this->params['page_id'] ) ) {
			return null;
		}

		$allFlagTypes = $this->getAllFlagTypes( $this->params['wiki_id'], $this->params['page_id'] );

		$this->setResponseData( $allFlagTypes );
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
		# @TODO: CE-1849 Proper error handling
		if ( !$this->processRequest() ) {
			return false;
		}
		$flagModel = new Flag();

		if ( $flagModel->verifyParamsForAdd( $this->params ) ) {
			$this->status = $flagModel->addFlagsToPage( $this->params );
		}

		$this->setVal( 'status', $this->status );
	}

	/**
	 * Removes flags from the given page. It accepts only POST requests
	 * with a valid User edit token.
	 *
	 * Required parameters:
	 * @requestParam array flags_ids An array of IDs of flags to remove
	 */
	public function removeFlagsFromPage() {
		# @TODO: CE-1849 Proper error handling
		if ( !$this->processRequest() ) {
			return false;
		}
		$flagModel = new Flag();

		if ( $flagModel->verifyParamsForRemove( $this->params ) ) {
			$this->status = $flagModel->removeFlagsFromPage( $this->params['flags'] );
		}

		$this->setVal( 'status', $this->status );
	}

	/**
	 * Updates flags on the given page using a `flags` array passed as a request parameter.
	 * @return bool
	 */
	public function updateFlagsForPage() {
		# @TODO: CE-1849 Proper error handling
		if ( !$this->processRequest() ) {
			return false;
		}
		$flagModel = new Flag();

		$this->status = $flagModel->updateFlagsForPage( $this->params['flags'] );

		$this->setVal( 'status', $this->status );
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
		# @TODO: CE-1849 Proper error handling
		if ( !$this->processRequest() ) {
			return false;
		}
		$flagTypeId = null;
		$flagTypeModel = new FlagType();

		if ( $flagTypeModel->verifyParamsForAdd( $this->params ) ) {
			$flagTypeId = $flagTypeModel->addFlagType( $this->params );
			$this->status = (bool) $flagTypeId;
		}

		$this->setVal( 'flag_type_id', $flagTypeId );
		$this->setVal( 'status', $this->status );
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
		# @TODO: CE-1849 Proper error handling
		if ( !$this->processRequest() ) {
			return false;
		}
		$flagTypeModel = new FlagType();

		if ( $flagTypeModel->verifyParamsForRemove( $this->params ) ) {
			$this->status = $flagTypeModel->removeFlagType( $this->params );
		}

		$this->setVal( 'status', $this->status );
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

		foreach ( $this->params['flags'] as $key => $flag ) {
			if ( !isset( $flag['params'] ) ) {
				$this->params['flags'][$key] = [];
			}
		}
	}

	/**
	 * To prevent CSRF attacks it checks if a request is a POST one
	 * and if a sent token matches the user's one.
	 * Calls getRequestParams if the request is valid.
	 * @return bool
	 */
	private function processRequest() {
		if ( !$this->request->isInternal()
			&& ( !$this->request->wasPosted() || $this->wg->User->matchEditToken( $this->getVal( 'edit_token' ) ) )
		) {
			$this->response->setException( new \Exception( 'Invalid request' ) );
			return false;
		}

		$this->getRequestParams();
		return true;
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
