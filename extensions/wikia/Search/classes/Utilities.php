<?php
/**
 * Class definition for Wikia\Search\Utilities
 */
namespace Wikia\Search;
use \Solarium_Query_Helper;
/**
 * A placeholder for utilities used across the search lib. 
 * @author relwell
 * @package Search
 */
class Utilities
{
	/**
	 * We use this helper to escape terms in sanitizeQuery.
	 * @staticvar \Solarium_Query_Helper
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
	 * Generates range query on given field. Params are integers
	 * @param string $field
	 * @param int $from
	 * @param int $to
	 * @return string
	 */
	public static function rangeIntValueField( $field, $from = null , $to = null )
	{
		$res = '(' . $field . ':[';
		$res .= $from !== null ? (int)$from : '*';
		$res .= ' TO ';
		$res .= $to !== null ? (int)$to : '*';
		return $res.'])';
	}

	/**
	 * Accepts a string and, checks it against a known set of dynamic language fields, and composes
	 * a field namebased on the language context and field set membership.
	 * @param  string $field
	 * @param  string $lang the non-global language code, if needed
	 * @return string the dynamic field, or the field name if not dynamic
	 **/
	public static function field( $field, $lang = null )
	{
		$field = new Field\Field( $field, $lang );
		return $field->__toString();
	}
}