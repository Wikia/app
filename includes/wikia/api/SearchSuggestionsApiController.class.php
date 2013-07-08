<?php
/**
* Controller to suggest searched phrases
*
* @author Artur Klajnerok <arturk@wikia-inc.com>
*/

class SearchSuggestionsApiController extends WikiaApiController {
	const PARAMETER_QUERY = 'query';

	/**
	 * Finds search suggestions phrases for chosen query
	 *
	 * @requestParam string $query search term fro
	 *
	 * @responseParam array $items The list of phrases matching the query
	 *
	 * @example http://gta..wikia.com/wikia.php?controller=SearchSuggestionsApi&method=getList&query=los
	 */
	public function getList() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		if ( !empty( $this->wg->EnableLinkSuggestExt ) ) {

			$query = trim( $this->request->getVal( self::PARAMETER_QUERY, null ) );

			if ( empty( $query ) ) {
				throw new MissingParameterApiException( self::PARAMETER_QUERY );
			}

			$linkSuggestions = LinkSuggest::getLinkSuggest($wgRequest);

			if ( !empty( $linkSuggestions ) ) {

				$linkSuggestions = explode("\n", $linkSuggestions);

				foreach($linkSuggestions as $suggestion){
					$searchSuggestions[]['title'] = $suggestion;
				}

				$this->response->setVal( 'items', $searchSuggestions );

			} else {
				throw new NotFoundApiException();
			}

			$this->response->setCacheValidity(
				86400 /* 24h */,
				86400 /* 24h */,
				array(
					WikiaResponse::CACHE_TARGET_BROWSER,
					WikiaResponse::CACHE_TARGET_VARNISH
				)
			);
		} else {
			throw new NotFoundApiException( 'Link Suggest extension not available' );
		}

		wfProfileOut( __METHOD__ );
	}

}