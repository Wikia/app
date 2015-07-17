<?php
class WikiaRssHelper {

	/**
	 * @brief Renders a placeholder or cached feed's data
	 * @param String $input user's options
	 *
	 * @return String
	 */
	static public function renderRssPlaceholder($input) {
		$app = F::app();
		$rss = new WikiaRssModel($input);

		// Kill parser cache
		//$app->wg->Parser->disableCache();
		$app->wg->ParserCacheExpireTime = 600;
		//wfDebug( "soft disable Cache (wikia rss)\n" );

		$html = '';
		$options = $rss->getRssAttributes();
		if ( array_key_exists('nojs', $options) && $options['nojs'] ) {
			$response =  $app->sendRequest( 'WikiaRssExternal', 'getRssFeeds', array( 'options' => $options ) );
			$html .= $response->getVal( 'html', '' );
		} else {
			$html .= self::getJSSnippet( $options );
			$html .= $rss->getPlaceholder();
		}

		return $html;
	}

	/**
	 * @brief Gets JavaScript code snippet to be loaded
	 *
	 * @param Array $options passed to callback javascript function
	 *
	 * @return string
	 */
	static private function getJSSnippet($options) {
		$html = JSSnippets::addToStack(
			array(
//				'/extensions/wikia/WikiaRSS/css/WikiaRss.scss', //it's empty; we don't need it here...
				'/extensions/wikia/WikiaRSS/js/WikiaRss.js',
			),
			array(),
			'WikiaRss.init',
			$options
		);

		return $html;
	}

}
