<?php
/**
 * Class definition for Wikia\Search\Field\Field
 */
namespace Wikia\Search\Field;
use \Wikia\Search\MediaWikiInterface;
/**
 * Allows us to abstract fields and dynamically handle languages.
 * @author relwell
 * @package Search
 * @subpackage Field
 */
class Field
{
	/**
	 * These fields are actually dynamic language fields supported in 36 different languages
	 * @staticvar array
	 */
	public static $languageFields  = array(
			'title',
	        'html',
	        'wikititle',
	        'first500',
	        'beginningText',
	        'headings',
	        'redirect_titles',
	        'categories',
	);

	/**
	 * Responsible for encapsulating MediaWiki logic.
	 * @var Wikia\Search\MediaWikiInterface
	 */
	protected $interface;
	
	/**
	 * Stores the actual name of the field as constructed
	 * @var string
	 */
	protected $fieldName;
	
	/**
	 * Stores the language code
	 * @var string
	 */
	protected $languageCode;
	
	/**
	 * Used for dynamically composing multivalued language fields
	 * @see WikiaSearch::field
	 * @staticvar array
	 */
	public static $multiValuedFields = array( 'categories', 'redirect_titles', 'headings' );
	
	/**
	 * Constructs a field.
	 * @param string $fieldName
	 * @param string $languageCode
	 */
	public function __construct( $fieldName, $languageCode = null ) {
		$this->fieldName = $fieldName;
		$this->interface = new MediaWikiInterface;
		$this->languageCode = $languageCode ?: $this->interface->getLanguageCode();
	}
	
	/**
	 * Provides the logic for the appropriate field name, dynamic or not.
	 * @return string
	 */
	public function __toString() {
		if ( in_array( $this->fieldName, self::$languageFields ) && $this->interface->searchSupportsLanguageCode( $this->languageCode ) ) {
			$lang = preg_replace( '/([^-]+)(-.*)?/', '_$1', $this->languageCode );
			$mv = in_array( $this->fieldName, self::$multiValuedFields ) ? '_mv' : '';
			return sprintf( '%s%s%s', $this->fieldName, $mv, $lang );
		}
		return $this->fieldName;
	}
}