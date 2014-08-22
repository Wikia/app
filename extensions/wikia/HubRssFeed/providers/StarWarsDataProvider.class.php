<?php

class StarWarsDataProvider {

	const SOURCE = 'xpath';

	const WOOKIEENEWS_PAGE_ID = 105;

	const STAR_WARS_WIKIA_ID = 147;

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
			$link = $this->normalizeLink( $link );

			$title = $this->getTitle( $xpath, $newsNode );

			$description = $newsNode->textContent;
			$description = $this->cleanDescription( $description );

			$result[ ] = [
				'timestamp' => $timestamp,
				'title' => $title,
				'description' => $description,
				'url' => $link,
				'wikia_id' => self::STAR_WARS_WIKIA_ID,
				'page_id' => self::WOOKIEENEWS_PAGE_ID,
				'source' => self::SOURCE
			];
		}

		if( $startTimestamp ) {
			$result = $this->filterAfterTimestamp( $result, $startTimestamp );
		}

		return $result;
	}

	/**
	 * Cut endings, like: 'Read more...', 'Watch here...', 'Watch it here...', 'Watch the video here...'
	 */
	protected function cleanDescription( $description ) {
		$regexp = '/^(.+\.)\s*(Read more[^a-zA-Z]*|Watch( it| the videos?)? here[^a-zA-Z]*)$/i';
		if( preg_match( $regexp, $description ) ) {
			$cleanedDescription = preg_replace( $regexp, '$1', $description );
			return $cleanedDescription;
		}
		return $description;
	}

	protected function normalizeLink( $link ) {
		if( strpos( $link, 'http://' ) === 0 ) {
			return $link;
		}

		if( preg_match( '/^\/wiki\/.+$/', $link ) ) {
			$pageTitle = preg_replace( '/^\/wiki\/(.+)$/', '$1', $link );
			$pageTitle = urldecode( $pageTitle );
			$title = GlobalTitle::newFromText( $pageTitle, NS_MAIN, self::STAR_WARS_WIKIA_ID );
			if( $title ) {
				$link = $title->getFullUrl();
			}
		}

		return $link;
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
		foreach( $linkNodes as $linkNode ) {
			$text = $linkNode->textContent;
			if( $this->canBeTitle( $text ) ) {
				return $text;
			}
		}
		// Fallback: consider date of article as a title
		return $this->getDate( $xpath, $contextNode );
	}

	/**
	 * If text of link doesn't contain dot, doesn't contain 'Read more' and contains uppercase later -
	 * we consider that it can be a title
	 */
	protected function canBeTitle( $text ) {
		return ( strpos( $text, '.' ) === false )
			&& ( preg_match( '/[A-Z]/', $text ) )
			&& ( ! ( (bool) preg_match( '/^read more.*$/i', $text ) ) );
	}

	protected function getNewsPageDOM() {
		$t = GlobalTitle::newFromId( self::WOOKIEENEWS_PAGE_ID, self::STAR_WARS_WIKIA_ID );
		$doc = new \DOMDocument();
		$doc->loadHTML( Http::request( "GET",  $t->getFullURL() , [ 'followRedirects' => true ] ) );
		return $doc;
	}
}