<?php

namespace Wikia\JsonFormat;

use Wikia\Measurements\Time;

class HtmlParser {

	/**
	 * Prevention from circular references, when parsing articles with tabs.
	 * Used for storing titles of articles, which been visited.
	 * @var array
	 * @see DivContainingHeadersVisitor::parseTabview
	 */
	protected static $VISITED_ARTICLES = [ ];

	public static function markAsVisited( $articleTitle ) {
		self::$VISITED_ARTICLES[ $articleTitle ] = true;
	}

	public static function isVisited( $articleTitle ) {
		return isset( self::$VISITED_ARTICLES[ $articleTitle ] );
	}

	public static function clearVisited() {
		self::$VISITED_ARTICLES = [ ];
	}

	/**
	 * @param string $html
	 * @return \JsonFormatNode
	 */
	public function parse( $html ) {
		$time = Time::start([__CLASS__, __METHOD__]);
		$doc = new \DOMDocument();

		$libxmlErrorSetting = libxml_use_internal_errors(true);
		$html = preg_replace("/\s+/", " ", $html);
		$doc->loadHTML("<?xml encoding=\"UTF-8\">\n<html><body>" . $html . "</body></html>");
		libxml_clear_errors();
		libxml_use_internal_errors($libxmlErrorSetting);
		$body = $doc->getElementsByTagName('body')->item(0);

		$jsonFormatTraversingState = new \JsonFormatBuilder();
		$visitor = $this->createVisitor( $jsonFormatTraversingState );
		$visitor->visit( $body );
		$root = $jsonFormatTraversingState->getJsonRoot();
		$time->stop();
		return $root;
	}

	public function createVisitor( $jsonFormatTraversingState ) {
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

		$compositeVisitor->addVisitor( new \TableOfContentsVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \SliderVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \InfoboxTableVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \TableVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \DivContainingHeadersVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new \ImageFigureNoScriptVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \ImageFigureVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \ImageNoScriptVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \ImageVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \DivImageVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \VideoVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \AVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \BrVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \BVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new \IVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new \InlineVisitor($compositeVisitor, $jsonFormatTraversingState, ['span', 'center', "strong", "strike", "u"]) );


		return $compositeVisitor;
	}
}
