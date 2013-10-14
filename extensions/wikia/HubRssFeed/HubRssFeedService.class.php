<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 07.10.13
 * Time: 09:05
 * To change this template use File | Settings | File Templates.
 */

class HubRssFeedService {

	const DATE_FORMAT = 'D, d M Y H:i:s e';

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

		self::appendTextNode( $doc, $channel, 'link', $this->url );
		self::appendTextNode( $doc, $channel, 'language', $this->lang );
		self::appendTextNode( $doc, $channel, 'generator', 'MediaWiki 1.19.7' );

		$maxTimestamp = 0;

		foreach ( $data as $url => $item ) {
			$itemNode = $channel->appendChild( new DOMElement('item') );
			self::appendCDATA( $doc, $itemNode, 'title', $item[ 'title' ] );
			self::appendCDATA( $doc, $itemNode, 'description', '<img src="' . $item[ 'img' ] . '"/><p>' . $item[ 'description' ] . '</p>' );
			self::appendCDATA( $doc, $itemNode, 'url', $url );
			//var_dump($item[ 'timestamp' ], date( self::DATE_FORMAT, $item[ 'timestamp' ] ) );
			$itemNode->appendChild( new DOMElement('pubDate', date( self::DATE_FORMAT, $item[ 'timestamp' ] )) ); //date('c') ?
			$itemNode->appendChild( new DOMElement('creator', 'Wikia', 'http://purl.org/dc/elements/1.1/') );

			if($item[ 'timestamp' ]  > $maxTimestamp ){
				$maxTimestamp = $item[ 'timestamp' ]  ;
			}
		}

		self::appendTextNode( $doc, $channel, 'lastBuildDate',  date( self::DATE_FORMAT,$maxTimestamp ) );
		return $doc->saveXML();
	}


	private static function appendCDATA( DOMDocument $doc, DOMElement $node, $name, $data = '' ) {
		$cdata = $doc->createCDATASection( $data );
		$element = $node->appendChild( new DOMElement($name) );
		$element->appendChild( $cdata );
	}


	private static function appendTextNode( DOMDocument $doc, DOMElement $node, $name, $data = '' ) {
		$cdata = $doc->createTextNode( $data );
		$element = $node->appendChild( new DOMElement($name) );
		$element->appendChild( $cdata );
	}
}