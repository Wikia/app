<?php
/**
 * Class definition for Wikia\Search\Field\Expression
 */
namespace Wikia\Search\Field;

use Wikia\Search\Traits;

/**
 * Wrap a field in a field expression.
 *
 * @author relwell
 * @package Search
 * @subpackage Field
 */
class FieldExpression {
	use Traits\ArrayConfigurableTrait;

	/**
	 * Allows us to express a field.
	 *
	 * @var Field
	 */
	protected $field;

	/**
	 * Allows us to express a field with a boost.
	 *
	 * @var int
	 */
	protected $boost;

	/**
	 * Allows us to express a negated field.
	 *
	 * @var bool
	 */
	protected $negate;

	/**
	 * Allows us to express a value for a field.
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * Allows us to express a quoted value.
	 *
	 * @var string
	 */
	protected $valueQuote = '';

	/**
	 * Constructor method.
	 *
	 * @param Field $field the field name
	 * @param array $params array-configurable settings for the expression
	 */
	public function __construct( Field $field, array $params ) {
		$this->field = $field;
		$this->configureByArray( $params );
	}

	/**
	 * Concatenates logic based on attribute settings to provide the appropriate field expression.
	 *
	 * @return string
	 */
	public function __toString() {
		return sprintf( '%s%s%s', $this->getNegationString(), $this->getFieldValueString(), $this->getBoostString() );
	}

	/**
	 * Returns the Lucene query syntax symbol for negation, if the negate attribute it set to true.
	 *
	 * @return string
	 */
	protected function getNegationString() {
		return $this->negate ? '-' : '';
	}

	/**
	 * Returns a boost value if a boost has been provided.
	 *
	 * @return string
	 */
	protected function getBoostString() {
		return $this->boost !== null ? "^{$this->boost}" : '';
	}

	/**
	 * Returns a string representing the basic expression of a field and its value according to Lucene query syntax.
	 *
	 * @return string
	 */
	protected function getFieldValueString() {
		return sprintf( '(%s:%s)', $this->field, $this->getValueString() );
	}

	/**
	 * Returns a the value of a string, optionally delineated in quotes.
	 * If a value is not set, the value for the expression defaults to '*', which means any value.
	 *
	 * @return string
	 */
	protected function getValueString() {
		$value = $this->value !== null ? $this->value : '*';

		return sprintf( '%s%s%s', $this->valueQuote, $value, $this->valueQuote );
	}

	/**
	 * Mutator method for boost attribute
	 *
	 * @param int $boost
	 *
	 * @return FieldExpression
	 */
	public function setBoost( $boost ) {
		$this->boost = $boost;

		return $this;
	}

	/**
	 * Mutator method for negation attribute
	 *
	 * @param bool $negate
	 *
	 * @return FieldExpression
	 */
	public function setNegate( $negate ) {
		$this->negate = $negate;

		return $this;
	}

	/**
	 * Mutator method for value attribute
	 *
	 * @param mixed $value
	 *
	 * @return FieldExpression
	 */
	public function setValue( $value ) {
		$this->value = $value;

		return $this;
	}

	/**
	 * Mutator method for whether or not to quote the value
	 *
	 * @param string $quote
	 *
	 * @return FieldExpression
	 */
	public function setValueQuote( $quote ) {
		$this->valueQuote = $quote;
	}
}
