<?php
/**
 * Class processes book information requests
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
class BookInformation {
	/**
	 * Perform a book information request and output the result
	 * if available, or an error if appropriate
	 *
	 * @param string $isbn ISBN to be queried
	 * @param OutputPage $output OutputPage object to use
	 */
	public static function show( $isbn, $output ) {
		if ( self::isValidISBN( $isbn ) ) {
			$result = BookInformationCache::get( $isbn );
			if ( $result === false ) {
				$driver = self::getDriver();
				if ( $driver !== false ) {
					$result = $driver->submitRequest( $isbn );
					if ( $result->isCacheable() )
						BookInformationCache::set( $isbn, $result );
				} else {
					$output->addHTML( self::makeError( 'nodriver' ) );
					return;
				}
			}
			if ( $result->getResponseCode() == BookInformationResult::RESPONSE_OK ) {
				$output->addHTML( self::makeResult( $result ) );
			} elseif ( $result->getResponseCode() == BookInformationResult::RESPONSE_NOSUCHITEM ) {
				$output->addHTML( self::makeError( 'nosuchitem' ) );
			} else {
				$output->addHTML( self::makeError( 'noresponse' ) );
			}
		} else {
			$output->addHTML( self::makeError( 'invalidisbn' ) );
		}
	}

	/**
	 * Get an instance of the appropriate driver object
	 *
	 * @return mixed BookInformationDriver or false
	 */
	private static function getDriver() {
		global $wgBookInformationDriver;
		$class = $wgBookInformationDriver;
		if ( class_exists( $class ) ) {
			return new $class;
		} elseif ( class_exists( ( $class = 'BookInformation' . $class ) ) ) {
			return new $class;
		} else {
			wfDebugLog( 'bookinfo', "Unable to initialise driver {$wgBookInformationDriver}\n" );
			return false;
		}
	}

	/**
	 * Format result output
	 *
	 * @param BookInformationDriver $result Driver with result
	 * @return string
	 */
	private static function makeResult( $result ) {
		$html  = '<div class="bookinfo-result">';
		$html .= '<h2>' . wfMsgHtml( 'bookinfo-header' ) . '</h2>';
		$html .= '<table>';
		foreach ( array(
			'title' => 'getTitle',
			'author' => 'getAuthor',
			'publisher' => 'getPublisher',
			'year' => 'getYear',
		) as $label => $func ) {
			if ( ( $$label = $result->$func() ) !== false )
				$html .= self::makeResultRow( $label, $$label );
		}
		$html .= '</table>';
		$html .= '<p class="otherinfo">';
		if ( ( $purchase = $result->getPurchaseLink() ) !== false )
			$html .= wfMsgHtml( 'bookinfo-purchase', $purchase ) . '<br />';
		$html .= wfMsgHtml( 'bookinfo-provider', $result->getProviderLink() ) . '</p>';
		$html .= '</div>';
		return $html;
	}

	/**
	 * Format a single row for output
	 *
	 * @param string $label Data label fragment
	 * @param string $value Data value
	 * @return string
	 */
	private static function makeResultRow( $label, $value ) {
		$label = wfMsgHtml( 'bookinfo-result-' . $label );
		return '<tr><th>' . $label . '</th><td>' . htmlspecialchars( $value ) . '</td></tr>';
	}

	/**
	 * Format an error for output
	 *
	 * @param string $error Error message fragment
	 * @return string
	 */
	private static function makeError( $error ) {
		$html  = '<div class="bookinfo-error">';
		$html .= '<h2>' . wfMsgHtml( 'bookinfo-header' ) . '</h2>';
		$html .= '<p>' . wfMsgHtml( 'bookinfo-error-' . $error ) . '</p>';
		$html .= '</div>';
		return $html;
	}

	/**
	 * Basic ISBN validation
	 *
	 * @todo ISBNs have check digits; do some proper validation
	 * @param string $isbn ISBN to check
	 * @return bool Valid
	 */
	public static function isValidISBN( $isbn ) {
		return preg_match( '!^[0-9X]+$!', $isbn )
				&& ( strlen( $isbn ) == 10 || strlen( $isbn ) == 13 );
	}
}
