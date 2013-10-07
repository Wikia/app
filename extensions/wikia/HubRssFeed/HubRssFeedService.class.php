<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 07.10.13
 * Time: 09:05
 * To change this template use File | Settings | File Templates.
 */

class HubRssFeedService {

	const DATE_FORMAT = 'D, m M Y H:i:s e';

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


	public function dataToXml( $data, $verticalId, $url ) {
		ini_set( 'html_errors', 0 );
		$doc = new DOMDocument();
		$doc->loadXML( file_get_contents( dirname( __FILE__ ) . '/templates/rss.xml' ) );
		$rssList = $doc->getElementsByTagName( 'rss' );
		$rss = $rssList->item( 0 );

		$date = date( self::DATE_FORMAT );

		self::appendTextNode( $doc, $rss, 'title', $this->descriptions[ $verticalId ][ 't' ] );
		self::appendTextNode( $doc, $rss, 'description', $this->descriptions[ $verticalId ][ 'd' ] );

		self::appendTextNode( $doc, $rss, 'link', $url );
		self::appendTextNode( $doc, $rss, 'language', 'en' );
		self::appendTextNode( $doc, $rss, 'generator', 'MediaWiki 1.19.7' );
		self::appendTextNode( $doc, $rss, 'lastBuildDate', $date );


		$channel = $rss->appendChild( new DOMElement('channel') );

		foreach ( $data as $url => $item ) {

			self::appendCDATA( $doc, $channel, 'title', $item[ 'title' ] );
			self::appendCDATA( $doc, $channel, 'description', '<img src="' . $item[ 'img' ] . '"/><p>' . $item[ 'description' ] . '</p>' );
			self::appendCDATA( $doc, $channel, 'url', $url );

			$channel->appendChild( new DOMElement('pubDate', $date) ); //date('c') ?
			$channel->appendChild( new DOMElement('creator', 'Wikia', 'http://purl.org/dc/elements/1.1/') );
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
		$element = $node->appendChild( new DOMElement($name) );
		$element->appendChild( $cdata );
	}
}