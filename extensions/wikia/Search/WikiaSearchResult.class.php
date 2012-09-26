<?php

class WikiaSearchResult extends Solarium_Document_ReadWrite
{
	protected $titleObject;
	protected $thumbnail;
	protected $text;
	protected $url;
	protected $linkUrl;
	protected $canonical = null	;
	

	public function getCityId() {
		return $this->_fields['wid'];
	}
	
	public function setText($value) {
        $this->_fields[WikiaSearch::field('text')] = $this->fixSnippeting($value, true);
	}
	
	public function getText() {
		return $this->_fields['text']; 
	}

	public function getTitle() {
		if ( isset($this->_fields[WikiaSearch::field('title')])  ) {
			return $this->_fields[WikiaSearch::field('title')];
		}
		
		if ( isset($this->_fields['title']) ) {
			return $this->_fields['title'];
		}
		var_dump($this->_fields); die;
		
		return '';
	}

	public function setTitle($value) {
		$this->_fields[WikiaSearch::field('title')] = $this->fixSnippeting($value);
	}

	public function getUrl() {
		return $this->_fields['url'];
	}

	public function getTextUrl() {
		return urldecode($this->_fields['url']);
	}
	
	// The following two methods have been copied over from Parser. We need to copy over the 
	// first method because it refers to the callback that follows it.
	
	/**
	 * Replace unusual URL escape codes with their equivalent characters
	 *
	 * @param $url String
	 * @return String
	 *
	 * @todo  This can merge genuinely required bits in the path or query string,
	 *        breaking legit URLs. A proper fix would treat the various parts of
	 *        the URL differently; as a workaround, just use the output for
	 *        statistical records, not for actual linking/output.
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

	public function setUrl($value) {
			$this->_fields['url'] = $value;
	}

	public function getCanonical() {
		return $this->canonical;
	}

	public function setCanonical($value) {
		$this->canonical = $value;
	}

	public function hasCanonical() {
		return !empty($this->canonical) ? true : false;
	}

	public function setVar($name, $value) {
		$this->_fields[$name] = $value;
	}

	public function getVar($name, $default = null) {
		if(isset($this->_fields[$name])) {
			return $this->_fields[$name];
		}
		else {
			return $default;
		}
	}

	public function getVars() {
		return $this->_fields;
	}

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

	public function getTitleObject() {
		if (!isset($this->titleObject)) {
			$this->titleObject = Title::makeTitle( $this->getVar('ns'), 
													preg_replace('/^'.MWNamespace::getCanonicalName($this->getVar('ns')).':/', 
																 '', $this->title)
											 	 );
		}
		return $this->titleObject;
	}

	public function getThumbnail() {
		if ((!isset($this->thumbnail)) && ($this->getVar('ns') == NS_FILE)) {
			$img = wfFindFile( $this->getTitleObject() );
			if (! empty( $img ) ) {
				$thumb = $img->transform( array( 'width' => 120, 'height' => 120 ) );
				if (! empty( $thumb ) ) {
					$this->thumbnail = $thumb;
				}
	    	}
	  	}
	  return $this->thumbnail;
	}

	public function toArray($keys){
		$array = array();
		foreach ($this as $key => $value)
		{
			if(in_array($key, $keys))
			$array[$key] = $value;
		}
		return $array;
	}

}
