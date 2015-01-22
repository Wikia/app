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
	 * @requestParam string $query search term for suggestions
	 *
	 * @responseParam array $items The list of phrases matching the query
	 *
	 * @example &query=los
	 */
	public function getList() {
		wfProfileIn(__METHOD__);

		if ( !empty( $this->wg->EnableLinkSuggestExt ) ) {

			$query = trim( $this->request->getVal( self::PARAMETER_QUERY, null ) );

			if ( empty( $query ) ) {
				throw new MissingParameterApiException( self::PARAMETER_QUERY );
			}

			$request = new WebRequest();
			$request->setVal('format', 'array');

			$linkSuggestions = LinkSuggest::getLinkSuggest( $request );

			if ( !empty( $linkSuggestions ) ) {

				foreach( $linkSuggestions as $suggestion ){
					$searchSuggestions[]['title'] = $suggestion;
				}
				$this->response->setVal( 'items', $searchSuggestions );

			} else {
				throw new NotFoundApiException();
			}

			$this->response->setCacheValidity(WikiaResponse::CACHE_STANDARD);
		} else {
			throw new NotFoundApiException( wfMessage( 'link-suggest-extension-not-available' )->text() );
		}

		wfProfileOut( __METHOD__ );
	}

}