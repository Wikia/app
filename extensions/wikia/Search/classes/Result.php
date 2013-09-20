<?php
/**
 * Class definition for Wikia\Search\Result
 */
namespace Wikia\Search;
use \Solarium_Document_ReadWrite as ReadWrite; #forward compatibility with v3
/**
 * This is a wrapper for the Solarium_Document_ReadWrite class based on code we 
 * originally wrote for an entirely hand-rolled search result class.
 * @author Robert Elwell
 * @package Search
 */
class Result extends ReadWrite {
	
	/**
	 * Encapsulates MediaWiki logic.
	 * @var MediaWikiService
	 */
	protected $service;

	/**
	 * Constructs the result and stores MW service
	 * @param array $fields
	 * @param array $boosts
	 */
	public function __construct( $fields = array(), $boosts = array() ) {
		parent::__construct( $fields, $boosts );
		$this->service = (new \Wikia\Search\ProfiledClassFactory)->get( 'Wikia\Search\MediaWikiService' );
	}
	
	/**
	 * Backwards compatibility, since Solarium_Document_ReadWrite instances have array access.
	 * @see    WikiaSearchResult::testGetCityId
	 * @return int;
	 */
	public function getCityId() {
		return $this->_fields['wid'];
	}
	
	/**
	 * This field is specially set to handle highlighting, which is separate from the result doc in Solarium.
	 * @see    WikiaSearchResultTest::testTextFieldMethods
	 * @param  string $value
	 * @param  bool $addEllipses whether to add ellipses to the end if the string is shortened
	 * @return WikiaSearchResult provides fluent interface
	 */
	public function setText( $value, $addEllipses = true ) {
		$this->_fields[ 'text' ] = $this->fixSnippeting( $value, $addEllipses);
		return $this;
	}
	
	/**
	 * Get the string value of a given field. If it's multi-valued, we implode it on whitespace.
	 * Defaults to "text", which we set from highlighting for certain searches.
	 * @see    WikiaSearchResultTest::testTextFieldMethods
	 * @param string|null $field allows us to assert the value must be text, not an array
	 * @param int|null $wordLimit allows us to ellipsize
	 * @return string
	 */
	public function getText( $field = 'text', $wordLimit = null ) {
		$text = isset( $this->_fields[$field] ) ? $this->_fields[$field] : '';
		$textAsString = is_array( $text ) ? implode( " ", $text ) : $text;
		if ( $wordLimit !== null ) {
			$wordsExploded = explode( ' ', $textAsString );
			$textAsString = implode( ' ', array_slice( $wordsExploded, 0, $wordLimit ) );
			if ( count( $wordsExploded ) > $wordLimit ) {
				$textAsString = $this->fixSnippeting( $textAsString, true );
			} 
		}
		return $textAsString;
	}
	
	/**
	 * Get the hub name, translated to content language
	 * @return string
	 */
	public function getHub() {
		return wfMessage('hub-'.$this->getText( 'hub_s' ))->text(); 
	}

	/**
	 * Returns the string value of the document's title
	 * @see    WikiaSearchResultTest::testTitleFieldMethods
	 * @return string
	 */
	public function getTitle() {
		if ( isset( $this->_fields[Utilities::field('title')] )  ) {
			return $this->_fields[Utilities::field('title')];
		}
		
		if ( isset( $this->_fields['title'] ) ) {
			return $this->_fields['title'];
		}
		
		// for video wiki
		if ( isset( $this->_fields[Utilities::field('title', 'en')] )  ) {
			return $this->_fields[Utilities::field('title', 'en')];
		}
		
		return '';
	}

	/**
	 * Allows you to set the title for the search result.
	 * @see    WikiaSearchResultTest::testTitleFieldMethods
	 * @param  string $value
	 * @return WikiaSearchResult provides fluent interface
	 */
	public function setTitle($value) {
		$this->_fields[Utilities::field('title')] = $this->fixSnippeting($value);
		return $this;
	}

	/**
	 * Returns the URL based on the value stored in the search document.
	 * @see    WikiaSearchResult::testUrlMethods
	 * @return string
	 */
	public function getUrl() {
		return isset( $this->_fields['url'] ) ? $this->_fields['url'] : '';
	}

	/**
	 * Returns the view-readable URL
	 * @see    WikiaSearchResult::testUrlMethods
	 * @return string
	 */
	public function getTextUrl() {
		return urldecode( $this->getUrl() );
	}
	

	/**
	 * Sets the URL
	 * @see    WikiaSearchResult::testUrlMethods
	 * @param  string $value
	 * @return WikiaSearchResult provides fluent interface
	 */
	public function setUrl( $value ) {
		$this->_fields['url'] = $value;
		return $this;
	}

	/**
	 * general-purpose value-setting method (backwards compatibility)
	 * @see    WikiaSearchResultTest::testVarMethods
	 * @param  string $name
	 * @param  mixed  $value
	 * @return WikiaSearchResult provides fluent interface
	 */
	public function setVar($name, $value) {
		$this->_fields[$name] = $value;
		return $this;
	}

	/**
	 * Returns a field value (backwards compatibility)
	 * @see    WikiaSearchResultTest::testVarMethods
	 * @param string $name
	 * @param mixed  $default
	 */
	public function getVar($name, $default = null) {
		return isset( $this->_fields[$name] ) ? $this->_fields[$name] : $default;
	}

	/**
	 * Returns the fields array (backwards compatibility)
	 * @see    WikiaSearchResultTest::testVarMethods
	 * @return array
	 */
	public function getVars() {
		return $this->_fields;
	}

	/**
	 * Removes junk values from snippeting
	 * @see   WikiaSearchResultTest::testFixSnippeting
	 * @param string  $text
	 * @param boolean $addEllipses
	 */
	private function fixSnippeting($text, $addEllipses=false) {
		$text = preg_replace('/^(span class="searchmatch">)/', '<$1', 
							preg_replace("/^[[:punct:]]+ ?/", '',
							preg_replace("/(<\\/span>)('s)/i", '$2$1',
							preg_replace('/ +$/', '',
							preg_replace('/ ?\.{2,3}$/', '', 
							preg_replace('/ ?&hellip;$/', '',
							str_replace('�', '', $text)))))));
		$text = strlen($text) > 0 && $addEllipses 
				? preg_replace('/(<\/span)$/', '$1>', preg_replace('/[[:punct:]]+$/', '', $text)).'&hellip;' 
				: $text;
		$text = strip_tags( $text, '<span>' );
		return $text;
	}

	public function getThumbnailUrl() {
		wfProfileIn( __METHOD__ );
		if (! isset( $this['thumbnail'] ) ) {
			try {
				$this['thumbnail'] = $this->service->getThumbnailUrl( $this['pageid'] );
			} catch ( \Exception $e ) {
				$this['thumbnail'] = '';
			}
		}
		wfProfileOut( __METHOD__ );
		return $this['thumbnail'];
	}

	public function getThumbnailHtml() {
		wfProfileIn( __METHOD__ );
		if (! isset( $this['thumbnail'] ) ) {
			try {
				$this['thumbnail'] = $this->service->getThumbnailHtml( $this['pageid'] );
			} catch ( \Exception $e ) {
				$this['thumbnail'] = '';
			}
		}
		wfProfileOut( __METHOD__ );
		return $this['thumbnail'];
	}

	/**
	 * get video views
	 * @return string $videoViews
	 */
	public function getVideoViews() {
		try {
			return $this->service->getFormattedVideoViewsForPageId( $this['pageid'] );
		} catch ( \Exception $e ) {
			return 0;
		}
	}

	/**
	 * Helper method for turning results into nested arrays for JSON encoding
	 * @param array $keys list of fields you want in your json output. You can use associative arrays to map from key to mapped value.
	 * @return array
	 */
	public function toArray( $keys ) {
		$array = array();
		foreach ( $keys as $key => $mapped  ) {
			$key = is_int( $key ) ? $mapped : $key;
			$array[$mapped] = $this[$key];
		}
		return $array;
	}
	
	/**
	 * Allows us to overload parent offsetGet with getTitle(), getText(), etc.
	 * This is good when using $result->toArray()
	 * @see Solarium_Document_ReadOnly::offsetGet()
	 */
	public function offsetGet( $key ) {
		$value = null;
		$keyParts = explode( '_', $key );
		$nolangKey = reset( $keyParts );
		switch ( $nolangKey ) {
		    case 'title':
		    	$value = $this->getTitle(); break;
		    case 'text':
		    	$value = $this->getText(); break;
		    case 'videoViews':
		    	$value = $this->getVideoViews(); break;
		    default:
		    	$value = parent::offsetGet( Utilities::field( $nolangKey ) );
		    	// e.g. infoboxes_txt
		    	if ( empty( $value ) ) {
		    		$value = parent::offsetGet( $key );
		    	}
		}
		return $value;
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
