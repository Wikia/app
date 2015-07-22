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

use Flags\Models\FlaggedPages;
use Flags\FlagsApiBaseController;
use Flags\FlaggedPagesCache;

class FlaggedPagesApiController extends FlagsApiBaseController {

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
	public function getFlaggedPages() {
		try {
			$this->getRequestParams();

			$flagsForPage = $this->getFlaggedPagesRawData( $this->params['wiki_id'] );

			$this->makeSuccessResponse( $flagsForPage );
		} catch ( Exception $e ) {
			$this->logResponseException( $e, $this->request );
			$this->response->setException( $e );
		}
	}

	/**
	 * Returns a singleton instance of FlaggedPagesCache
	 * @return FlaggedPagesCache
	 */
	protected function getNewCacheInstance() {
		return new FlaggedPagesCache();
	}

	/**
	 * Tries to get the data on flagged pages from cache.
	 * If it is not cached it gets it from the database and caches it.
	 * @param $wikiId
	 * @return bool|mixed
	 */
	private function getFlaggedPagesRawData( $wikiId ) {
		$flagsCache = $this->getCache();
		$flaggedPages = $flagsCache->get();

		if ( !$flaggedPages ) {
			$flagModel = new FlaggedPages();
			$flagsForPage = $flagModel->getFlaggedPagesFromDatabase( $wikiId );

			$flagsCache->set( $flagsForPage );
		}

		return $flagsForPage;
	}

}
