<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 07.10.13
 * Time: 09:05
 * To change this template use File | Settings | File Templates.
 */

class HubRssFeedService {
	/** This is DateTime::RFC822 with one small change. We use 4 digits year after recommendation from feedvalidator.org */
	const DATE_FORMAT = "D, d M Y H:i:s O";

	protected $descriptions = [
		WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT =>
		['t' => 'Wikia Entertainment Community feed',
			'd' => 'From Wikia community - Entertainment'],

		WikiFactoryHub::CATEGORY_ID_GAMING =>
		['t' => 'Wikia Gaming Community feed',
			'd' => 'From Wikia community - Gaming'],

		WikiFactoryHub::CATEGORY_ID_LIFESTYLE =>
		['t' => 'Wikia Lifestyle Community feed',
			'd' => 'From Wikia community - Lifestyle'],
	];

	protected $lang;

	protected $url;

	public function __construct( $lang, $url ) {
		$this->lang = $lang;
		$this->url = $url;
	}


	public function dataToXml( $data, $verticalId ) {
		$doc = new DOMDocument();
		$doc->loadXML( file_get_contents( dirname( __FILE__ ) . '/templates/rss.xml' ) );
		$rssList = $doc->getElementsByTagName( 'rss' );
		$rss = $rssList->item( 0 );
		$channel = $rss->appendChild( new DOMElement('channel') );

		self::appendTextNode( $doc, $channel, 'title', $this->descriptions[ $verticalId ][ 't' ] );
		self::appendTextNode( $doc, $channel, 'description', $this->descriptions[ $verticalId ][ 'd' ] );
		self::appendAtomLink( $doc, $channel, $this->url );
		self::appendTextNode( $doc, $channel, 'link', $this->url);
		self::appendTextNode( $doc, $channel, 'language', $this->lang );
		self::appendTextNode( $doc, $channel, 'generator', 'MediaWiki 1.19.7' );

		$maxTimestamp = 0;
		foreach ( $data as $url => $item ) {
			if($item[ 'timestamp' ]  > $maxTimestamp ){
				$maxTimestamp = $item[ 'timestamp' ]  ;
			}
		}
		self::appendTextNode( $doc, $channel, 'lastBuildDate',  date( self::DATE_FORMAT,$maxTimestamp ) );

		foreach ( $data as $url => $item ) {
			$itemNode = $channel->appendChild( new DOMElement('item') );
			self::appendCDATA( $doc, $itemNode, 'title', $item[ 'title' ] );
			self::appendCDATA( $doc, $itemNode, 'description', $item[ 'description' ] );
			self::appendTextNode( $doc, $itemNode, 'link', $url );
			self::appendTextNode( $doc, $itemNode, 'guid', $url );
			$itemNode->appendChild( new DOMElement('pubDate', date( self::DATE_FORMAT, $item[ 'timestamp' ] )) );
			$itemNode->appendChild( new DOMElement('creator', 'Wikia', 'http://purl.org/dc/elements/1.1/') );

			if ( isset($item[ 'img' ]) ) {
				$img = $doc->createElementNS( 'http://search.yahoo.com/mrss/', 'content' );
				$img->setAttribute( 'type', 'image/jpeg' );
				$img->setAttribute( 'url', $item[ 'img' ][ 'url' ] );
				$img->setAttribute( 'width', $item[ 'img' ][ 'width' ] );
				$img->setAttribute( 'height', $item[ 'img' ][ 'height' ] );
				$itemNode->appendChild( $img );
			}

		}
		return $doc->saveXML();
	}


	private static function appendCDATA( DOMDocument $doc, DOMElement $node, $name, $data = '' ) {
		$cdata = $doc->createCDATASection( $data );
		$element = $node->appendChild( new DOMElement($name) );
		$element->appendChild( $cdata );
	}


	private static function appendTextNode( DOMDocument $doc, DOMElement $node, $name, $data = '' ) {
		$cdata = $doc->createTextNode( $data );
		$element = $node->appendChild( new DOMElement( $name ) );
		$element->appendChild( $cdata );
	}

	private static function  appendAtomLink( DOMDocument $doc, DOMElement $parentElement, $href ) {
		$link = $doc->createElementNS( "http://www.w3.org/2005/Atom", "link" );
		$link->setAttribute( "href", $href );
		$link->setAttribute( "rel", "self" );
		$parentElement->appendChild( $link );
	}
}
