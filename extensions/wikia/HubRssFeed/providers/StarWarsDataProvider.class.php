<?php

class StarWarsDataProvider {

	const WOOKIEENEWS_PAGE_ID = 105;

	public function getData( $startTimestamp = null ) {
		$result = [ ];

		$doc = $this->getNewsPageDOM();

		$xpath = new DOMXPath($doc);

		$newsNodes = $xpath->query( "//li[./../../h2/span[@class='mw-headline']]" );
		foreach($newsNodes as $newsNode) {

			$timestamp = $this->getTimestamp( $xpath, $newsNode );
			if( !$timestamp ) {
				continue;
			}

			$link = $this->getNodeValueByXPath( $xpath, "(.//a[last()])[last()]/@href", $newsNode );
			if( !$link ) {
				continue;
			}

			$title = $this->getTitle( $xpath, $newsNode );

			$description = $newsNode->textContent;

			$result[ ] = [
				'timestamp' => $timestamp,
				'title' => $title,
				'description' => $description,
				'link' => $link
			];
		}

		if( $startTimestamp ) {
			$result = $this->filterAfterTimestamp( $result, $startTimestamp );
		}

		return $result;
	}

	protected function filterAfterTimestamp( $items, $startTimestamp ) {
		$result = [ ];
		foreach( $items as $item ) {
			if( $item[ 'timestamp' ] >= $startTimestamp ) {
				$result[ ] = $item;
			}
		}
		return $result;
	}

	protected function getTimestamp( $xpath, $contextNode ) {
		$dayMonthYear = $this->getDate( $xpath, $contextNode );
		$timestamp = strtotime( $dayMonthYear );
		return $timestamp;
	}

	protected function getDate( $xpath, $contextNode ) {
		$dayAndMonth = $this->getNodeValueByXPath( $xpath, "./../preceding::p[1]/a/@title", $contextNode );
		if(!$dayAndMonth) {
			return null;
		}

		$year = $this->getNodeValueByXPath( $xpath, "./../preceding::h2[1]//a", $contextNode );
		if(!$year) {
			return null;
		}

		$dayMonthYear =  $dayAndMonth . ', ' . $year;
		return $dayMonthYear;
	}

	protected function getNodeValueByXPath( $xpath, $query, $contextNode ) {
		$node = $xpath->query($query, $contextNode)->item(0);
		if(!$node) {
			return null;
		} else {
			return $node->nodeValue;
		}
	}

	protected function getTitle( $xpath, $contextNode ) {
		$linkNodes = $xpath->query( ".//a", $contextNode );
		// Iterating across text of all links
		// If text of link doesn't contain dot, doesn't contain 'Read more' and contains uppercase later -
		// we consider that it is a title
		foreach( $linkNodes as $linkNode ) {
			$text = $linkNode->textContent;
			if( ( strpos( $text, '.' ) == false )
				&& ( (bool) preg_match( '/[A-Z]/', $text ) )
				&& ( ! ( (bool) preg_match( '/^read more.*$/i', $text ) ) ) ) {
				return $text;
			}
		}
		// Fallback
		return $this->getDate( $xpath, $contextNode );
	}

	protected function getNewsPageDOM() {
		$article = \Article::newFromID( self::WOOKIEENEWS_PAGE_ID );
		$requestContext = new RequestContext();
		$parserOptions = \ParserOptions::newFromContext( $requestContext );
		$html = $article->getPage()->getParserOutput( $parserOptions )->getText();
		$doc = new \DOMDocument();
		$html = preg_replace("/\s+/", " ", $html);
		$doc->loadHTML("<?xml encoding=\"UTF-8\">\n<html><body>" . $html . "</body></html>");
		$doc->normalizeDocument();
		return $doc;
	}
}