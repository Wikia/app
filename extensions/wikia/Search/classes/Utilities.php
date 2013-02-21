<?php
/**
 * Class definition for Wikia\Search\Utilities
 */
namespace Wikia\Search;
use \Solarium_Query_Helper;
/**
 * A placeholder for utilities used across the search lib. 
 * @author relwell
 */
class Utilities
{
	/**
	 * @var \Solarium_Query_Helper
	 */
	private static $queryHelper;
	
	/**
	 * Used to compose field name, value, boosts, and quotes in support of dynamic language fields
	 * @param  string $field
	 * @param  string $value
	 * @param  array  $params
	 * @return string the lucene-ready string
	 **/
	public static function valueForField( $field, $value, array $params = array() )
	{
		$expression = new Field\FieldExpression( new Field\Field( $field ), array_merge( array( 'value' => $value ), $params ) );
		return $expression->__toString();
	}
	
	/**
	 * Accepts a string and, checks it against a known set of dynamic language fields, and composes
	 * a field namebased on the language context and field set membership.
	 * @param  string $field
	 * @return string the dynamic field, or the field name if not dynamic
	 **/
	public static function field( $field, $lang = null )
	{
		$field = new Field\Field( $field, $lang );
		return $field->__toString();
	}
	
	/**
	 * Prevents XSS and escapes characters used in Lucene query syntax.
	 * Any query string transformations before sending to backend should be placed here.
	 * @see    WikiaSearchTest::testSanitizeQuery
	 * @param  string $query
	 * @return string
	 */
	public static function sanitizeQuery( $query )
	{
		if ( self::$queryHelper === null ) {
			self::$queryHelper = new Solarium_Query_Helper();
		}
		// non-indexed number-string phrases issue workaround (RT #24790)
		$query = preg_replace('/(\d+)([a-zA-Z]+)/i', '$1 $2', $query);
	
		// escape all lucene special characters: + - && || ! ( ) { } [ ] ^ " ~ * ? : \ (RT #25482)
		// added html entity decoding now that we're doing extra work to prevent xss
		return self::$queryHelper->escapeTerm( html_entity_decode( $query,  ENT_COMPAT, 'UTF-8' ) );
	}
}