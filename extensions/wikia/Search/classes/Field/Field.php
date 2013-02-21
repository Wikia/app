<?php
/**
 * Class definition for Wikia\Search\Field\Field
 */
namespace Wikia\Search\Field;
/**
 * Allows us to abstract fields and dynamically handle languages.
 * @author relwell
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
	 * @param string $language
	 */
	public function __construct( $fieldName, $languageCode = null ) {
		$this->fieldName = $fieldName;
		$this->interface = \Wikia\Search\MediaWikiInterface::getInstance();
		$this->languageCode = $languageCode ?: $this->interface->getLanguageCode();
	}
	
	public function __toString() {
		if ( in_array( $this->languageCode, self::$languageFields ) ) {
			$lang = $this->interface->searchSupportsLanguageCode( $this->languageCode ) ? preg_replace( '/([^-]+)(-.*)?/', '_$1', $this->languageCode ) : '';
			$mv = in_array( $this->fieldName, self::$multiValuedFields ) ? '_mv' : '';
			return sprintf( '%s%s%s', $this->fieldName, $mv, $lang );
		}
		return $this->fieldName;
	}
}