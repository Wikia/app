<?php
/**
 * Class definition for Wikia\Search\Field\Field
 */
namespace Wikia\Search\Field;
use \Wikia\Search\MediaWikiService;
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
			'sitename', // wiki
			'description', // wiki
			'top_categories', // wiki
			'top_articles', // wiki
	);

	/**
	 * Responsible for encapsulating MediaWiki logic.
	 * @var Wikia\Search\MediaWikiService
	 */
	protected $service;
	
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
	public static $multiValuedFields = array( 'categories', 'redirect_titles', 'headings', 'top_categories', 'top_articles' );
	
	/**
	 * Constructs a field.
	 * @param string $fieldName
	 * @param string $languageCode
	 */
	public function __construct( $fieldName, $languageCode = null ) {
		$this->fieldName = $fieldName;
		$this->service = (new \Wikia\Search\ProfiledClassFactory)->get( 'Wikia\Search\MediaWikiService' );
		$this->languageCode = $languageCode ?: $this->service->getLanguageCode();
	}
	
	/**
	 * Provides the logic for the appropriate field name, dynamic or not.
	 * @return string
	 */
	public function __toString() {
		if ( in_array( $this->fieldName, self::$languageFields ) && $this->service->searchSupportsLanguageCode( $this->languageCode ) ) {
			$lang = preg_replace( '/([^-]+)(-.*)?/', '_$1', $this->languageCode );
			$mv = in_array( $this->fieldName, self::$multiValuedFields ) ? '_mv' : '';
			return sprintf( '%s%s%s', $this->fieldName, $mv, $lang );
		}
		return $this->fieldName;
	}
}