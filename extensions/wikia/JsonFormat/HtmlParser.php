<?php

namespace Wikia\JsonFormat;

class HtmlParser {
	/**
	 * @param string $html
	 * @return \JsonFormatNode
	 */
	public function parse( $html ) {
		$doc = new \DOMDocument();

		libxml_use_internal_errors(true);
		$doc->loadHTML("<?xml encoding=\"UTF-8\">\n<html><body>" . $html . "</body></html>");
		libxml_clear_errors();
		$body = $doc->getElementsByTagName('body')->item(0);

		$jsonFormatTraversingState = new \JsonFormatBuilder();
		$visitor = $this->createVisitor( $jsonFormatTraversingState );
		$visitor->visit( $body );
		return $jsonFormatTraversingState->getJsonRoot();
	}

	protected function visit( \DOMNode $node, $indent ) {
		for ( $i = 0; $i < $indent; $i++ ) echo ' ';
		if( $node instanceof \DOMText ) {
			echo "text {$node->textContent}\n";
		} else if ($node instanceof \DOMElement and $node->tagName == 'div') {

		} else {
			for( $i = 0; $i < $node->childNodes->length; $i++ ) {
				$child = $node->childNodes->item($i);
				$this->visit( $child, $indent+1 );
			}
		}
	}

	protected function createVisitor( $jsonFormatTraversingState ) {
		$compositeVisitor = new \CompositeVisitor();

		$compositeVisitor->addVisitor( new \TextNodeVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new \BodyVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \HeaderVisitor($compositeVisitor, $jsonFormatTraversingState) );

		/*
		 * special cases for special wikis :)
		 */
		$compositeVisitor->addVisitor( new \TruebloodScrollWrapperVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \AmericandadWrapperVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new \QuoteVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \PVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \ListVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new \DivContainingHeadersVisitor($compositeVisitor, $jsonFormatTraversingState) );


		$compositeVisitor->addVisitor( new \TableOfContentsVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \InfoboxTableVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \TableVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new \ImageFigureNoScriptVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \ImageFigureVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \ImageNoScriptVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \ImageVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \VideoVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \AVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \BrVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \BVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \IVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new \InlineVisitor($compositeVisitor, $jsonFormatTraversingState, ['span', 'center', "strong"]) );


		return $compositeVisitor;
	}
}
