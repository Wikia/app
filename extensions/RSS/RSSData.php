<?php

class RSSData {
	public $error;
	public $items;

	/**
	 * Constructor, takes a DOMDocument and returns an array of parsed items.
	 * @param $xml DOMDocument: the pre-parsed XML Document
	 * @return Object RSSData object with a member items that is an array of parsed items,
	 */
	function __construct( $xml ) {
		if ( !( $xml instanceof DOMDocument ) ) {
			$this->error = "Not passed DOMDocument object.";
			return;
		}
		$xpath = new DOMXPath( $xml );
		$items = $xpath->query( '/rss/channel/item' );

		if( $items->length !== 0 ) {
			foreach ( $items as $item ) {
				$bit = array();
				foreach ( $item->childNodes as $n ) {
					$name = $this->rssTokenToName( $n->nodeName );
					if ( $name != null ) {
						/**
						 * Because for DOMElements the nodeValue is just
						 * the text of the containing element, without any
						 * tags, it makes this a safe, if unattractive,
						 * value to use. If you want to allow people to
						 * mark up their RSS, some more precautions are
						 * needed.
						 */
						$bit[$name] = $n->nodeValue;
					}
				}
				$this->items[] = $bit;
			}
		} else {
			$this->error = 'No RSS items found.';
			return;
		}
	}

	/**
	 * Return a string that will be used to map RSS elements that
	 * contain similar data (e.g. dc:date, date, and pubDate) to the
	 * same array key.  This works on WordPress feeds as-is, but it
	 * probably needs a way to concert dc:date format dates to be the
	 * same as pubDate.
	 *
	 * @param $n String: name of the element we have
	 * @return String Name to map it to
	 */
	protected function rssTokenToName( $n ) {
		switch( $n ) {
			case 'dc:date':
				return 'date';
				# parse "2010-10-18T18:07:00Z"
			case 'pubDate':
				return 'date';
				# parse RFC date
			case 'dc:creator':
				return 'author';
			case 'title':
				return 'title';
			case 'content:encoded':
				return 'encodedContent';

			case 'slash:comments':
			case 'slash:department':
			case 'slash:section':
			case 'slash:hit_parade':
			case 'feedburner:origLink':
			case 'wfw:commentRss':
			case 'comments':
			case 'category':
				return null;

			default:
				return $n;
		}
	}
}