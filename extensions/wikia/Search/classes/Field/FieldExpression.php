<?php
/**
 * Class definition for Wikia\Search\Field\Expression
 */
namespace Wikia\Search\Field;
use Wikia\Search\Traits;
/**
 * Wrap a field in a field expression. 
 * @author relwell
 */
class FieldExpression
{
	use Traits\ArrayConfigurable;
	
	/**
	 * Allows us to express a field.
	 * @var Field
	 */
	protected $field;
	
	/**
	 * Allows us to express a field with a boost.
	 * @var int
	 */
	protected $boost;
	
	/**
	 * Allows us to express a negated field.
	 * @var bool
	 */
	protected $negated;
	
	/**
	 * Allows us to express a value for a field.
	 * @var string
	 */
	protected $value;
	
	/**
	 * Allows us to express a quoted value.
	 * @var string
	 */
	protected $valueQuote = '';
	
	
	public function __construct( Field $field, array $params ) {
		$this->field = $field;
		$this->configureByArray( $params );
	}
	
	public function __toString() {
		return sprintf( '%s%s%s', $this->getNegationString(), $this->getFieldValueString(), $this->getBoostString() );
	}
	
	protected function getNegationString() {
		return $this->negated ? '-' : '';
	}
	
	protected function getBoostString() {
		return $this->boost !== null ? "^{$this->boost}" : '';
	}
	
	protected function getFieldValueString() {
		return sprintf( '(%s:%s)', $this->field, $this->getValueString() );
	}
	
	protected function getValueString() {
		$value = $this->value ?: '*';
		return sprintf( '%s%s%s', $this->valueQuote, $value, $this->valueQuote );
	}
	
	public function setBoost( $boost ) {
		$this->boost = $boost;
		return $this;
	}
	
	public function setNegated( $negated ) {
		$this->negated = $negated;
		return $this;
	}
	
	public function setValue( $value ) {
		$this->value = $value;
		return $this;
	}
	
	public function setValueQuote( $quote ) {
		$this->valueQuote = $quote;
	}
}