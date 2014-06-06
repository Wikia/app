<?php

class Scribunto_LuaUriLibrary extends Scribunto_LuaLibraryBase {
	function register( $pureLua = false ) {
		$lib = array(
			'anchorEncode' => array( $this, 'anchorEncode' ),
			'localUrl' => array( $this, 'localUrl' ),
			'fullUrl' => array( $this, 'fullUrl' ),
			'canonicalUrl' => array( $this, 'canonicalUrl' ),
		);

		$this->getEngine()->registerInterface( 'mw.uri.lua', $lib, array(
			'defaultUrl' => $this->getTitle()->getFullUrl(),
		) );
	}

	public function anchorEncode( $s ) {
		return array( CoreParserFunctions::anchorencode(
			$this->getParser(), $s
		) );
	}

	private function getUrl( $func, $page, $query ) {
		$title = Title::newFromText( $page );
		if( !$title ) {
			$title = Title::newFromURL( urldecode( $page ) );
		}
		if( $title ) {
			# Convert NS_MEDIA -> NS_FILE
			if( $title->getNamespace() == NS_MEDIA ) {
				$title = Title::makeTitle( NS_FILE, $title->getDBkey() );
			}
			if( $query !== null ) {
				$text = $title->$func( $query );
			} else {
				$text = $title->$func();
			}
			return array( $text );
		} else {
			return array( null );
		}
	}

	public function localUrl( $page, $query ) {
		return $this->getUrl( 'getLocalURL', $page, $query );
	}

	public function fullUrl( $page, $query ) {
		return $this->getUrl( 'getFullURL', $page, $query );
	}

	public function canonicalUrl( $page, $query ) {
		return $this->getUrl( 'getCanonicalURL', $page, $query );
	}
}
