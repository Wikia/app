<?php

class StarWarsDataProvider {

	public function getData() {
		$result = [ ];

		$doc = $this->getNewsPageDOM();

		$xpath = new DOMXPath($doc);

		$newsNodes = $xpath->query("//li[./../../h2/span[@class='mw-headline']]");
		foreach($newsNodes as $newsNode) {

			$month = $this->getNodeValueByXPath( $xpath, "./../preceding::p[1]/a/@title", $newsNode );
			if(!$month) {
				continue;
			}

			$year = $this->getNodeValueByXPath( $xpath, "./../preceding::h2[1]//a", $newsNode );
			if(!$year) {
				continue;
			}

			$link = $this->getNodeValueByXPath( $xpath, "(./a[last()])[last()]/@href", $newsNode );
			if(!$link) {
				continue;
			}

			$description = $newsNode->textContent;

			$result[ ] = [
				'date' => $year . ' ' . $month,
				'description' => $description,
				'link' => $link
			];
		}

		return $result;
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
		$article = \Article::newFromID( 105 );
		$html = $article->getPage()->getParserOutput( \ParserOptions::newFromContext( new RequestContext() ) )->getText();
		$doc = new \DOMDocument();
		$html = preg_replace("/\s+/", " ", $html);
		$doc->loadHTML("<?xml encoding=\"UTF-8\">\n<html><body>" . $html . "</body></html>");
		$doc->normalizeDocument();
		return $doc;
	}
}