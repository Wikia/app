<?php

class StarWarsDataProvider {

	const WOOKIEENEWS_PAGE_ID = 105;

	public function getData( $startTimestamp ) {
		$result = [ ];

		$doc = $this->getNewsPageDOM();

		$xpath = new DOMXPath($doc);

		$newsNodes = $xpath->query("//li[./../../h2/span[@class='mw-headline']]");
		foreach($newsNodes as $newsNode) {

			$timestamp = $this->getTimestamp( $xpath, $newsNode );
			if( !$timestamp ) {
				continue;
			}

			$link = $this->getNodeValueByXPath( $xpath, "(.//a[last()])[last()]/@href", $newsNode );
			if( !$link ) {
				continue;
			}

			$description = $newsNode->textContent;

			$result[ ] = [
				'timestamp' => $timestamp,
				'description' => $description,
				'link' => $link
			];
		}

		return $result;
	}

	protected function getTimestamp( $xpath, $contextNode ) {
		$dayAndMonth = $this->getNodeValueByXPath( $xpath, "./../preceding::p[1]/a/@title", $contextNode );
		if(!$dayAndMonth) {
			return null;
		}

		$year = $this->getNodeValueByXPath( $xpath, "./../preceding::h2[1]//a", $contextNode );
		if(!$year) {
			return null;
		}

		$timestamp = strtotime( $dayAndMonth . ' ' . $year );
		return $timestamp;
	}

	protected function getNodeValueByXPath( $xpath, $query, $contextNode ) {
		$node = $xpath->query($query, $contextNode)->item(0);
		if(!$node) {
			return null;
		} else {
			return $node->nodeValue;
		}
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