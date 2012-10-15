<?php
/**
 * @file
 * @ingroup SMWDataValues
 */

/**
 * This datavalue implements URL/URI/ANNURI/PHONE/EMAIL datavalues suitable for
 * defining the respective types of properties.
 *
 * @author Anna Kantorovitch
 * @author Benedikt Kämpgen
 */
class SWBResolvableUriValue extends SMWDataValue {

	/**
	 * The value as returned by getWikitext() and getLongText().
	 * @var string
	 */
	protected $m_wikitext;
	/**
	 * One of the basic modes of operation for this class (emails, URL,
	 * telephone number URI, ...).
	 * @var integer
	 */
	private $m_mode;

	protected function parseUserValue( $value ) {
		// echo "parseUserValue";

		smwfLoadExtensionMessages( 'SemanticMediaWiki' );
		$value = trim( $value );
		$this->m_wikitext = $value;
		if ( $this->m_caption === false ) {
			$this->m_caption = $this->m_wikitext;
		}

		$scheme = $hierpart = $query = $fragment = '';
		if ( $value == '' ) { // do not accept empty strings
			$this->addError( wfMsgForContent( 'smw_emptystring' ) );
			$this->m_dataitem = new SMWDIUri( 'http', '//example.com', '', '', $this->m_typeid ); // define data item to have some value
			return;
		}

		$parts = explode( ':', $value, 2 ); // try to split "schema:rest"
		if ( count( $parts ) == 1 ) { // possibly add "http" as default
			$value = 'http://' . $value;
			$parts[1] = $parts[0];
			$parts[0] = 'http';
		}
		// check against blacklist
		$uri_blacklist = explode( "\n", wfMsgForContent( 'smw_uri_blacklist' ) );
		foreach ( $uri_blacklist as $uri ) {
			$uri = trim( $uri );
			if ( $uri == mb_substr( $value, 0, mb_strlen( $uri ) ) ) { // disallowed URI!
				$this->addError( wfMsgForContent( 'smw_baduri', $value ) );
				$this->m_dataitem = new SMWDIUri( 'http', '//example.com', '', '', $this->m_typeid ); // define data item to have some value
				return;
			}
		}
		// decompose general URI components
		$scheme = $parts[0];
		$parts = explode( '?', $parts[1], 2 ); // try to split "hier-part?queryfrag"
		if ( count( $parts ) == 2 ) {
			$hierpart = $parts[0];
			$parts = explode( '#', $parts[1], 2 ); // try to split "query#frag"
			$query = $parts[0];
			$fragment = ( count( $parts ) == 2 ) ? $parts[1] : '';
		} else {
			$query = '';
			$parts = explode( '#', $parts[0], 2 ); // try to split "hier-part#frag"
			$hierpart = $parts[0];
			$fragment = ( count( $parts ) == 2 ) ? $parts[1] : '';
		}
		// We do not validate the URI characters (the data item will do this) but we do some escaping:
		// encode most characters, but leave special symbols as given by user:
		$hierpart = str_replace( array( '%3A', '%2F', '%23', '%40', '%3F', '%3D', '%26', '%25' ), array( ':', '/', '#', '@', '?', '=', '&', '%' ), rawurlencode( $hierpart ) );
		$query = str_replace( array( '%3A', '%2F', '%23', '%40', '%3F', '%3D', '%26', '%25' ), array( ':', '/', '#', '@', '?', '=', '&', '%' ), rawurlencode( $query ) );
		$fragment = str_replace( array( '%3A', '%2F', '%23', '%40', '%3F', '%3D', '%26', '%25' ), array( ':', '/', '#', '@', '?', '=', '&', '%' ), rawurlencode( $fragment ) );
		/// NOTE: we do not support raw [ (%5D) and ] (%5E), although they are needed for ldap:// (but rarely in a wiki)
		/// NOTE: "+" gets encoded, as it is interpreted as space by most browsers when part of a URL;
		///       this prevents tel: from working directly, but we have a datatype for this anyway.


		// Now create the URI data item:
		try {
			SWBSpecialBrowseWiki:: debug( $this->m_typeid, "typeid" );
			$this->m_dataitem = new SMWDIUri( $scheme, $hierpart, $query, $fragment, $this->m_typeid );
		} catch ( SMWDataItemException $e ) {
			$this->addError( wfMsgForContent( 'smw_baduri', $this->m_wikitext ) );
			$this->m_dataitem = new SMWDIUri( 'http', '//example.com', '', '', $this->m_typeid ); // define data item to have some value
		}
	}

	/**
	 * Returns true if the argument is a valid RFC 3966 phone number.
	 * Only global phone numbers are supported, and no full validation
	 * of parameters (appended via ;param=value) is performed.
	 */
	protected static function isValidTelURI( $s ) {
		$tel_uri_regex = '<^tel:\+[0-9./-]*[0-9][0-9./-]*(;[0-9a-zA-Z-]+=(%[0-9a-zA-Z][0-9a-zA-Z]|[0-9a-zA-Z._~:/?#[\]@!$&\'()*+,;=-])*)*$>';
		return (bool) preg_match( $tel_uri_regex, $s );
	}

	/**
	 * @see SMWDataValue::loadDataItem()
	 * @param $dataitem SMWDataItem
	 * @return boolean
	 */
	protected function loadDataItem( SMWDataItem $dataItem ) {
		SWBSpecialBrowseWiki:: debug( "loadItem" );
		if ( $dataItem->getDIType() == SMWDataItem::TYPE_URI ) {
			$this->m_dataitem = $dataItem;
			if ( $this->m_mode == SMW_URI_MODE_EMAIL ) {
				$this->m_wikitext = substr( $dataItem->getURI(), 7 );
			} elseif ( $this->m_mode == SMW_URI_MODE_TEL ) {
				$this->m_wikitext = substr( $dataItem->getURI(), 4 );
			} else {
				$this->m_wikitext = $dataItem->getURI();
			}
			$this->m_caption = $this->m_wikitext;
			return true;
		} else {
			return false;
		}
	}

	public function getShortWikiText( $linked = null ) {
		SWBSpecialBrowseWiki:: debug( "shortWiki" );
		$url = $this->getURL();
		if ( ( $linked === null ) || ( $linked === false ) || ( $this->m_outformat == '-' ) || ( $url == '' ) || ( $this->m_caption == '' ) ) {
			return $this->m_caption;
		} else {
			return '[' . $url . ' ' . $this->m_caption . ']';
		}
	}

	public function getShortHTMLText( $linker = null ) {
		SWBSpecialBrowseWiki:: debug( "shortHTML" );
		$url = $this->getURL();
		if ( ( $linker === null ) || ( !$this->isValid() ) || ( $this->m_outformat == '-' ) || ( $url == '' ) || ( $this->m_caption == '' ) ) {
			return $this->m_caption;
		} else {
			return $linker->makeExternalLink( $url, $this->m_caption );
		}
	}

	public function getLongWikiText( $linked = null ) {
		SWBSpecialBrowseWiki:: debug( "longWiki" );
		if ( !$this->isValid() ) {
			return $this->getErrorText();
		}
		$url = $this->getURL();
		if ( ( $linked === null ) || ( $linked === false ) || ( $this->m_outformat == '-' ) || ( $url == '' ) ) {
			return $this->m_wikitext;
		} else {
			return '[' . $url . ' ' . $this->m_wikitext . ']';
		}
	}

	public function getLongHTMLText( $linker = null ) {
		SWBSpecialBrowseWiki:: debug( "longHTML" );
		if ( !$this->isValid() ) {
			return $this->getErrorText();
		}
		$url = $this->getURL();
		if ( ( $linker === null ) || ( $this->m_outformat == '-' ) || ( $url == '' ) ) {
			return htmlspecialchars( $this->m_wikitext );
		} else {
			return $linker->makeExternalLink( $url, $this->m_wikitext );
		}
	}

	public function getWikiValue() {
		return $this->m_wikitext;
	}

	public function getURI() {
		SWBSpecialBrowseWiki:: debug( "uri" );
		return $this->m_dataitem->getURI();
	}

	protected function getServiceLinkParams() {
		// Create links to mapping services based on a wiki-editable message. The parameters
		// available to the message are:
		// $1: urlencoded version of URI/URL value (includes mailto: for emails)
		return array( rawurlencode( $this->m_dataitem->getURI() ) );
	}

	/**
	 * Get a URL for hyperlinking this URI, or the empty string if this URI
	 * is not hyperlinked in MediaWiki.
	 * @return string
	 */
	public function getURL() {
		SWBSpecialBrowseWiki:: debug( "getURL" );
		global $wgUrlProtocols;
		foreach ( $wgUrlProtocols as $prot ) {
			if ( ( $prot == $this->m_dataitem->getScheme() . ':' ) || ( $prot == $this->m_dataitem->getScheme() . '://' ) ) {
				return $this->m_dataitem->getURI();
			}
		}
		return '';
	}

}

