<?php

/**
 * This is a wrapper for the Solarium_Document_ReadWrite class based on code we 
 * originally wrote for an entirely hand-rolled search result class.
 * @author Robert Elwell
 *
 */
class WikiaSearchResult extends Solarium_Document_ReadWrite {
	protected $titleObject;
	protected $thumbnailObject;
	

	/**
	 * Backwards compatibility, since Solarium_Document_ReadWrite instances have array access.
	 * @return int;
	 */
	public function getCityId() {
		return $this->_fields['wid'];
	}
	
	/**
	 * This field is specially set to handle highlighting, which is separate from the result doc in Solarium.
	 * @param string $value
	 * @return WikiaSearchResult provides fluent interface
	 */
	public function setText( $value ) {
		$this->_fields[ 'text' ] = $this->fixSnippeting( $value, true );
		return $this;
	}
	
	/**
	 * Get the text found via highlighting fields
	 * @return string
	 */
	public function getText() {
		return isset( $this->_fields['text'] ) ? $this->_fields['text'] : ''; 
	}

	/**
	 * Returns the string value of the document's title
	 * @return string
	 */
	public function getTitle() {
		if ( isset( $this->_fields[WikiaSearch::field('title')] )  ) {
			return $this->_fields[WikiaSearch::field('title')];
		}
		
		if ( isset( $this->_fields['title'] ) ) {
			return $this->_fields['title'];
		}
		
		return '';
	}

	/**
	 * Allows you to set the title for the search result.
	 * @param string $value
	 * @return WikiaSearchResult provides fluent interface
	 */
	public function setTitle($value) {
		$this->_fields[WikiaSearch::field('title')] = $this->fixSnippeting($value);
		return $this;
	}

	/**
	 * Returns the URL based on the value stored in the search document.
	 * @return string
	 */
	public function getUrl() {
		return isset( $this->_fields['url'] ) ? $this->_fields['url'] : '';
	}

	/**
	 * Returns the view-readable URL
	 * @return string
	 */
	public function getTextUrl() {
		return urldecode( $this->getUrl() );
	}
	

	/**
	 * Sets the URL
	 * @param string $value
	 * @return WikiaSearchResult provides fluent interface
	 */
	public function setUrl( $value ) {
		$this->_fields['url'] = $value;
		return $this;
	}

	/**
	 * general-purpose value-setting method (backwards compatibility)
	 * @param string $name
	 * @param mixed  $value
	 * @return WikiaSearchResult provides fluent interface
	 */
	public function setVar($name, $value) {
		$this->_fields[$name] = $value;
		return $this;
	}

	/**
	 * Returns a field value (backwards compatibility)
	 * @param string $name
	 * @param mixed  $default
	 */
	public function getVar($name, $default = null) {
		return isset( $this->_fields[$name] ) ? $this->_fields[$name] : $default;
	}

	/**
	 * Returns the fields array (backwards compatibility)
	 * @return array
	 */
	public function getVars() {
		return $this->_fields;
	}

	/**
	 * Removes junk values from snippeting
	 * @param string  $text
	 * @param boolean $addEllipses
	 */
	private function fixSnippeting($text, $addEllipses=false) {
		$text = preg_replace('/^(span class="searchmatch">)/', '<$1', 
							preg_replace("/^[[:punct:]] ?/", '',
							preg_replace("/(<\\/span>)('s)/i", '$2$1',
							preg_replace('/ +$/', '',
							preg_replace('/ ?\.{1,3}$/', '', 
							preg_replace('/ ?&hellip;$/', '',
							str_replace('�', '', $text)))))));
		return strlen($text) > 0 && $addEllipses 
				? preg_replace('/(<\/span)$/', '$1>', preg_replace('/[[:punct:]]+$/', '', $text)).'&hellip;' 
				: $text;

	}

	/**
	 * Retrieves the title object for this
	 * @return Title 
	 */
	public function getTitleObject() {
		if (!isset($this->titleObject)) {
			$this->titleObject = Title::makeTitle( $this->getVar('ns'), 
													preg_replace('/^'.MWNamespace::getCanonicalName($this->getVar('ns')).':/', 
																 '', $this->title)
											 	 );
		}
		return $this->titleObject;
	}

	/**
	 * Returns the thumbnail object that is used to render thumbnails in a search result
	 * @return ThumbnailImage (i think?)
	 */
	public function getThumbnail() {
		if ((!isset($this->thumbnailObject)) && ($this->getVar('ns') == NS_FILE)) {
			$img = wfFindFile( $this->getTitleObject() );
			if (! empty( $img ) ) {
				$thumb = $img->transform( array( 'width' => 120, 'height' => 120 ) );
				if (! empty( $thumb ) ) {
					$this->thumbnailObject = $thumb;
				}
			}
	  	}
	  return $this->thumbnailObject;
	}

	/**
	 * Helper method for turning results into nested arrays for JSON encoding
	 * @param array $keys
	 * @return array
	 */
	public function toArray($keys) {
		$array = array();
		foreach ($this as $key => $value)
		{
			if(in_array($key, $keys))
			$array[$key] = $value;
		}
		return $array;
	}
	
	/**
	 * The following two methods have been copied over from MediaWiki's Parser class. 
	 * We need to copy over the first method because it refers to the callback that follows it.
	 * Also, we had to fix something in it just for this class, which is why we're doing this in the first place.
	 */
	
	/**
	 * Replace unusual URL escape codes with their equivalent characters
	 *
	 * @param $url String
	 * @return String
	 *
	 * @todo  This can merge genuinely required bits in the path or query string,
	 *		breaking legit URLs. A proper fix would treat the various parts of
	 *		the URL differently; as a workaround, just use the output for
	 *		statistical records, not for actual linking/output.
	 */
	static function replaceUnusualEscapes( $url ) {
	    return preg_replace_callback( '/%[0-9A-Fa-f]{2}/',
	            array( __CLASS__, 'replaceUnusualEscapesCallback' ), $url );
	}
	
	/**
	 * Callback function used in replaceUnusualEscapes().
	 * Replaces unusual URL escape codes with their equivalent character
	 *
	 * @param $matches array
	 *
	 * @return string
	 */
	private static function replaceUnusualEscapesCallback( $matches ) {
	    $char = urldecode( $matches[0] );
	    $ord = ord( $char );
	    # Is it an unsafe or HTTP reserved character according to RFC 1738?
	    # Or, according to bugid 46673, will it create a bad request if left in a URL?
	    if ( $ord > 32 && $ord < 127 && strpos( '<>"#{}|\^~[]`;%/?', $char ) === false ) {
	        # No, shouldn't be escaped
	        return $char;
	    } else {
	        # Yes, leave it escaped
	        return $matches[0];
	    }
	}
}
