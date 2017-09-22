<?php
class WikiaRssHelper {

	/**
	 * @brief Renders a placeholder or cached feed's data
	 * @param String $input user's options
	 *
	 * @return String
	 */
	public static function renderRssPlaceholder($input) {
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
	private static function getJSSnippet($options) {
		$html = JSSnippets::addToStack(
			array(
				'/extensions/wikia/WikiaRSS/css/WikiaRss.scss',
				'/extensions/wikia/WikiaRSS/js/WikiaRss.js',
			),
			array(),
			'WikiaRss.init',
			$options
		);

		return $html;
	}

	/**
	 * @param string Feed url $url
	 * @return array
	 *	'errorMessageKey' - string| null error type message key - used for localizing error messages
	 *	'error' - string|null raw error message returned by magpierss
	 *	'rss' - null|MagpieRSS parsed feed data
	 */
	public static function getFeedData( $url ) {
		\Wikia\Logger\WikiaLogger::instance()->info(
			'WikiaRSS calling RSS provider',
			[ 'providerUrl' => $url ]
		);

		$status = null;
		$rss = @fetch_rss( $url, $status );

		$errorMessageKey = null;
		$error = null;

		if ( !is_null( $status ) && $status !== 200 ) {
			$errorMessageKey = 'wikia-rss-error-wrong-status-' . $status;
		} else if ( !is_object( $rss ) || !is_array($rss->items) ) {
			$errorMessageKey = 'wikia-rss-empty';
		} else if ( $rss->ERROR ) {
			$errorMessageKey = 'wikia-rss-error';
			$error = $rss->ERROR;
		}

		if ( !empty( $errorMessageKey ) ) {
			\Wikia\Logger\WikiaLogger::instance()->error(
				'Error: WikiaRSS calling RSS provider ',
				[ 'providerUrl' => $url, 'error' => $errorMessageKey ]
			);
		}

		return [
			'errorMessageKey' => $errorMessageKey,
			'error' => $error,
			'rss' => $rss
		];
	}
}
