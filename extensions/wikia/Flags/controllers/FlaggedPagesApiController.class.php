<?php

/**
 * The public interface for retrieving pages marked with flags.
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

use Flags\Models\FlaggedPages;
use Flags\FlagsApiBaseController;
use Flags\FlaggedPagesCache;

class FlaggedPagesApiController extends FlagsApiBaseController {

	/**
	 * Retrieves list of page ids that have flags
	 *
	 * @requestParam int wiki_id (optional) You can overwrite a default wiki_id with it
	 * @requestParam int flagTypeId (optional) You can filter results by flag type
	 * @response Array A list of pages IDs marked with flags
	 */
	public function getFlaggedPages() {
		try {
			$this->getRequestParams();

			if ( !isset( $this->params['flag_type_id'] ) ) {
				throw new \MissingParameterApiException( 'flag_type_id' );
			}

			$flaggedPages = $this->getFlaggedPagesRawData( $this->params['wiki_id'] );

			$this->makeSuccessResponse( $flaggedPages );

		} catch ( Exception $e ) {
			$this->logResponseException( $e, $this->getRequest() );
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
	 * If that's not cached it gets data from the database and caches it.
	 * @param $wikiId
	 * @return bool|mixed
	 */
	private function getFlaggedPagesRawData( $wikiId ) {
		$flagTypeId = $this->params['flag_type_id'];
		$flagsCache = $this->getCache();
		$flaggedPages = $flagsCache->get( $flagTypeId );

		if ( !$flaggedPages ) {
			$flagModel = new FlaggedPages();
			$flaggedPages = $flagModel->getFlaggedPagesFromDatabase(
				$wikiId,
				$flagTypeId
			);

			$flagsCache->set( $flaggedPages, $flagTypeId );
		}

		return $flaggedPages;
	}

}
