<?php
/**
 * Book information driver for ISBNdb.com
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

class BookInformationIsbnDb implements BookInformationDriver {
	/**
	 * Submit a request to the information source and
	 * return the result
	 *
	 * @param string $isbn ISBN to obtain information for
	 * @return BookInformationResult
	 */
	public function submitRequest( $isbn ) {
		global $wgBookInformationService;
		if ( isset( $wgBookInformationService['accesskey'] ) ) {
			$ak = $wgBookInformationService['accesskey'];
			$uri = self::buildRequestURI( $ak, $isbn );
			if ( ( $xml = Http::get( $uri ) ) !== false ) {
				return $this->parseResponse( $xml );
			} else {
				return new BookInformationResult( BookInformationResult::RESPONSE_TIMEOUT );
			}
		} else {
			return new BookInformationResult( BookInformationResult::RESPONSE_FAILED );
		}
	}

	/**
	 * Build the URI for an ISBNdb.com request
	 *
	 * @param string $ak Access key
	 * @param string $isbn ISBN to be queried
	 * @return string
	 */
	private static function buildRequestURI( $ak, $isbn ) {
		$bits[] = 'access_key=' . urlencode( $ak );
		$bits[] = 'index1=isbn';
		$bits[] = 'value1=' . urlencode( $isbn );
		return 'http://isbndb.com/api/books.xml?' . implode( '&', $bits );
	}

	/**
	 * Parse an XML response from the service and extract
	 * the information we require
	 *
	 * @param string $response XML response
	 * @return BookInformationResult
	 */
	private function parseResponse( $response ) {
		try {
			$xml = new SimpleXMLElement( $response );
			if ( is_object( $xml ) && $xml instanceof SimpleXMLElement ) {
				if ( isset( $xml->BookList[0]->BookData[0] ) ) {
					$book =& $xml->BookList[0]->BookData[0];
					return $this->prepareResult(
						(string)$book->Title,
						(string)$book->AuthorsText,
						(string)$book->PublisherText
					);
				} else {
					return new BookInformationResult( BookInformationResult::RESPONSE_NOSUCHITEM );
				}
			} else {
				return new BookInformationResult( BookInformationResult::RESPONSE_FAILED );
			}
		} catch ( Exception $ex ) {
			return new BookInformationResult( BookInformationResult::RESPONSE_FAILED );
		}
	}

	/**
	 * Prepare a BookInformationResult corresponding to a successful
	 * request and containing the available book information
	 *
	 * @param string $title Title of the book
	 * @param string $author Author of the book
	 * @param string $publisher Publisher of the book
	 * @return BookInformationResult
	 */
	private function prepareResult( $title, $author, $publisher ) {
		$result = new BookInformationResult(
			BookInformationResult::RESPONSE_OK,
			$title,
			$author,
			$publisher
		);
		$result->setProviderData( self::buildProviderLink() );
		return $result;
	}

	/**
	 * Build a link to ISBNdb.com
	 *
	 * @return string
	 */
	private static function buildProviderLink() {
		return '<a href="http://www.isbndb.com">ISBNdb.com</a>';
	}
}
