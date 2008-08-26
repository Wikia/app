<?php

class SpecialNoticeLocal extends NoticePage {
	
	function __construct() {
		parent::__construct( "NoticeLocal" );
	}
	
	/**
	 * A couple hours? Squids can cache them longer...
	 */
	protected function maxAge() {
		return 7200;
	}
	
	function getJsOutput( $par ) {
		$text = '';
		if( $par == 'anon' ) {
			$text = wfGetCachedNotice( 'anonnotice' );
		}
		if( !$text ) {
			$text = wfGetCachedNotice( 'sitenotice' );
		}
		if( !$text ) {
			$text = wfGetCachedNotice( 'default' );
		}
		if( $text ) {
			// blah
			return
				'wgNoticeLocal="' .
				Xml::escapeJsString( $text ) .
				'";';
		}
	}
}
