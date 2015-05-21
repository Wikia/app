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
use Flags\Helper;
use Flags\Models\Flag;
use Flags\Models\FlagType;

class FlagsController extends WikiaApiController {
	private
		$params,
		$status = false;

	/**
	 * Assigns a request's parameters to the object's property
	 * and sets a wikiId if it hasn't been specified as one
	 * of the parameters.
	 */
	private function getRequestParams() {
		$this->params = $this->request->getParams();
		if ( !isset( $this->params['wikiId'] ) ) {
			$this->params['wikiId'] = $this->wg->CityId;
		}
	}

	/**
	 * To prevent CSRF attacks it checks if a request is a POST one
	 * and if a sent token matches the user's one.
	 * Calls getRequestParams if the request is valid.
	 * @return bool
	 */
	private function processRequest() {
		if ( !$this->request->wasPosted()
			|| !$this->wg->User->matchEditToken( $this->getVal( 'token' ) )
		) {
			$this->response->setException( new \Exception( 'Invalid request' ) );
			return false;
		}

		$this->getRequestParams();
		return true;
	}

	/**
	 * Article level API
	 */

	/**
	 * Retrieves all data for all flag types available on the given wikia
	 * with an intent of rendering a modal with an edit form.
	 * It returns the types with instances on the page first and then all
	 * other types sorted alphabetically.
	 * To retrieve only types with instances on the given page:
	 * @see getFlagsForPage()
	 *
	 * @requestParam int wikiId
	 * @requestParam int pageId
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

		if ( !isset( $this->params['pageId'] ) ) {
			return null;
		}

		$allFlagTypes = $this->getAllFlagTypes( $this->params['wikiId'], $this->params['pageId'] );

		$this->setResponseData( $allFlagTypes );
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
		$flagsCache = new FlagsCache();

		/**
		 * 1. Get flags assigned to the page
		 */
		$flagsForPage = $flagsCache->getFlagsForPage( $pageId );
		if ( !$flagsForPage ) {
			$flagModel = new Flag();
			$flagsForPage = $flagModel->getFlagsForPage( $wikiId, $pageId );
		}
		/**
		 * 2. Get all flag types for a wikia
		 */
		$flagTypesForWikia = $flagsCache->getFlagTypesForWikia();
		if ( !$flagTypesForWikia ) {
			$flagTypeModel = new FlagType();
			$flagTypesForWikia = $flagTypeModel->getFlagTypesForWikia( $wikiId );
		}

		/**
		 * 3. Return the united arrays if it's possible to merge them (both arrays use
		 * flag_type_id values as indexes)
		 */
		return $flagsForPage + $flagTypesForWikia;
	}

	/**
	 * Retrieves all data for flags assigned to the given page
	 * with an intent of rendering them. To get all types of flags:
	 * @see getFlagsForPageForEdit()
	 *
	 * @requestParam int wikiId
	 * @requestParam int pageId
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

		if ( !isset( $this->params['pageId'] ) ) {
			return null;
		}
		$wikiId = $this->params['wikiId'];
		$pageId = $this->params['pageId'];

		$flagsCache = new FlagsCache();
		$flagsForPage = $flagsCache->getFlagsForPage( $pageId );

		if ( !$flagsForPage ) {
			$flagModel = new Flag();
			$flagsForPage = $flagModel->getFlagsForPage( $wikiId, $pageId );

			$flagsCache->setFlagsForPage( $pageId, $flagsForPage );
		}

		$this->setResponseData( $flagsForPage );
	}

	/**
	 * This is the main entry point if you want to modify flags for a page using the edit form.
	 * The request HAS TO BE a POST one and include a `token` parameter that
	 * matches an edit token for $wgUser.
	 *
	 * The request should include:
	 * @requestParam int wikiId (if not provided a $wgCityId value is used)
	 * @requestParam int pageId
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
			return null;
		}
		$wikiId = $this->params['wikiId'];
		$pageId = $this->params['pageId'];

		/**
		 * Get the current status to compare
		 */
		$currentFlags = $this->getAllFlagTypes( $wikiId, $pageId );

		$helper = new Helper();
		$flagsToChange = $helper->compareDataAndGetFlagsToChange( $currentFlags, $this->params );
		if ( !empty( $flagsToChange ) ) {
			$this->performActionsUsingPostedData( $flagsToChange );

			/**
			 * Purge cache values for the page
			 */
			$flagsCache = new FlagsCache();
			$flagsCache->purgeFlagsForPage( $pageId );
		}

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
	private function performActionsUsingPostedData( Array $flagsToChange ) {
		$flagModel = new Flag();
		/**
		 * Add flags
		 */
		if ( !empty( $flagsToChange['toAdd'] ) ) {
			$flagsToAdd = [
				'wikiId' => $this->params['wikiId'],
				'pageId' => $this->params['pageId'],
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
	 * Adds flags to the given page. It accepts only POST requests
	 * with a valid User edit token.
	 *
	 * Required parameters:
	 * @requestParam int wikiId
	 * @requestParam int pageId
	 * @requestParam array flags
	 * @requestParam int flags['flagTypeId'] An ID of a flag type
	 *
	 * Optional parameters:
	 * @requestParam array flags['params'] An array of params structured like:
	 * [
	 * 	'paramName1' => 'paramValue1',
	 * 	'paramName2' => 'paramValue2',
	 * ]
	 */
	public function addFlagsToPage() {
		$this->processRequest();
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
	 * @requestParam array flagsIds An array of IDs of flags to remove
	 */
	public function removeFlagsFromPage() {
		$this->processRequest();
		$flagModel = new Flag();

		if ( $flagModel->verifyParamsForRemove( $this->params ) ) {
			$this->status = $flagModel->removeFlagsFromPage( $this->params );
		}

		$this->setVal( 'status', $this->status );
	}

	/**
	 * Flag type level API
	 */

	/**
	 * Adds a new type of flags.
	 *
	 * Required parameters:
	 * @requestParam int wikiId
	 * @requestParam int flagGroup One of the keys in flagGroups property of the FlagType model
	 * @requestParam string flagName A name of the flag (not longer than 128 characters)
	 * @requestParam string flagView A title of a template used for rendering the flag
	 * @requestParam int flagTargeting A level of targeting: 0 -> readers, 1 -> contibutors, 2 -> admins
	 *
	 * Optional parameters:
	 * @requestParam string flagParamsNames A JSON-encoded array of names of parameters
	 * 		It's used for rendering inputs in the "Add a flag" form.
	 */
	public function addFlagType() {
		$this->processRequest();
		$flagTypeModel = new FlagType();

		if ( $flagTypeModel->verifyParamsForAdd( $this->params ) ) {
			$this->status = $flagTypeModel->addFlagType( $this->params );
		}

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
		$this->processRequest();
		$flagTypeModel = new FlagType();

		if ( $flagTypeModel->verifyParamsForRemove( $this->params ) ) {
			$this->status = $flagTypeModel->removeFlagType( $this->params );
		}

		$this->setVal( 'status', $this->status );
	}
}
