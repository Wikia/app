<?php

class RssFeedService {

	/** This is DateTime::RFC822 with one small change. We use 4 digits year after recommendation from feedvalidator.org */
	const DATE_FORMAT = "D, d M Y H:i:s O";
	protected $feedDescription = "";
	protected $feedTitle = "";
	protected $feedUrl = "";
	protected $feedLang = "en";
	protected $data = [];
	protected $ref = "";

	/**
	 * @param string $ref
	 */
	public function setRef( $ref ) {
		$this->ref = $ref;
	}

	/**
	 * @param string $feedDescription
	 */
	public function setFeedDescription( $feedDescription ) {
		$this->feedDescription = $feedDescription;
	}

	/**
	 * @param string $feedLang
	 */
	public function setFeedLang( $feedLang ) {
		$this->feedLang = $feedLang;
	}

	/**
	 * @param string $feedTitle
	 */
	public function setFeedTitle( $feedTitle ) {
		$this->feedTitle = $feedTitle;
	}

	/**
	 * @param string $feedUrl
	 */
	public function setFeedUrl( $feedUrl ) {
		$this->feedUrl = $feedUrl;
	}

	public function getData() {
		return $this->data;
	}

	/**
	 * @param $data
	 */
	public function setData($data) {
		$this->data = $data;
	}

	public function addElem($title, $descr, $url, $timestamp, $img = null) {
		$this->data[$url] = array(
			"title" => $title,
			"description" => $descr,
			"timestamp" => $timestamp,
			"img" => $img
		);
	}

	public function getArticleDetails($wikiId, $articleId, $url) {
		$domain = WikiFactory::DBtoUrl(WikiFactory::IDtoDB($wikiId));
		//TODO: REFACTOR THE HACK

		if ( $domain ) {
			$callUrl = sprintf( '%sapi/v1/Articles/Details?ids=%u', $domain, $articleId );
			$details = Http::get($callUrl);
			if (empty($details)) {
				$details = file_get_contents($callUrl);
			}
			$data = json_decode( $details );
			if ( $data ) {
				return $data;
			}
			return false;
		}
		return false;
	}

	public function toXml() {
		$doc = new DOMDocument();
		$doc->loadXML( file_get_contents( dirname( __FILE__ ) . '/templates/rss.xml' ) );
		$rssList = $doc->getElementsByTagName( 'rss' );
		$rss = $rssList->item( 0 );
		$channel = $rss->appendChild( new DOMElement('channel') );

		self::appendTextNode( $doc, $channel, 'title', $this->feedTitle );
		self::appendTextNode( $doc, $channel, 'description', $this->feedDescription );
		self::appendAtomLink( $doc, $channel, $this->feedUrl );
		self::appendTextNode( $doc, $channel, 'link', $this->feedUrl);
		self::appendTextNode( $doc, $channel, 'language', $this->feedLang );
		self::appendTextNode( $doc, $channel, 'generator', 'MediaWiki 1.19.7' );

		$data = $this->getData();

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
			self::appendTextNode( $doc, $itemNode, 'link', $this->makeUrlWithRef( $url ) );
			self::appendTextNode( $doc, $itemNode, 'guid', $this->makeUrlWithRef( $url ) );
			$itemNode->appendChild( new DOMElement('pubDate', date( self::DATE_FORMAT, $item[ 'timestamp' ] )) );
			$itemNode->appendChild( new DOMElement('creator', 'Wikia', 'http://purl.org/dc/elements/1.1/') );

			if ( isset($item[ 'img' ]) ) {
				$img = $doc->createElementNS( 'http://search.yahoo.com/mrss/', 'content' );
				$img->setAttribute( 'type', 'image/jpeg' );
				$img->setAttribute( 'url', $this->makeUrlWithRef( $item[ 'img' ][ 'url' ] ) );
				$img->setAttribute( 'width', $item[ 'img' ][ 'width' ] );
				$img->setAttribute( 'height', $item[ 'img' ][ 'height' ] );
				$itemNode->appendChild( $img );
			}

		}
		return $doc->saveXML();
	}

	/**
	 * Appends $this->'ref' parameter to $url
	 * If $this->'ref' is empty - returns unchanged $url
	 * Works correctly whenever $url contains any parameters, or not
	 *
	 * @param $url - valid URL
	 * @return string
	 */
	protected function makeUrlWithRef( $url ) {

		if( empty( $url ) ) {
			return '';
		}

		if( empty( $this->ref ) ) {
			return $url;
		}

		if( strpos( $url, '?' ) !== FALSE ) {
			// Check if $url already contains some parameters
			// e.g. http://test.com?key=value
			$url .= '&';
		} else {
			// Or, $url doesn't contain any parameters
			// e.g. http://test.com
			$url .= '?';
		}
		$url .= 'ref='.$this->ref;

		return $url;
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