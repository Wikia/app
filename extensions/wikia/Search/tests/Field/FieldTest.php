<?php
/**
 * Class definition for Wikia\Search\Test\FieldTest
 */
namespace Wikia\Search\Test\Field;
use Wikia\Search\Field, Wikia\Search\Test\BaseTest, \ReflectionProperty, \ReflectionMethod;
/**
 * Tests Field\Field and Field\Expression
 */
class WikiaSearchFieldTest extends BaseTest {

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07849 ms
	 * @covers Wikia\Search\Field\Field::__construct
	 */
	public function test__construct() {
		$field = new Field\Field( 'html', 'en' );
		
		$reflFieldName = new ReflectionProperty( 'Wikia\Search\Field\Field', 'fieldName' );
		$reflFieldName->setAccessible( true );
		$this->assertEquals(
				'html',
				$reflFieldName->getValue( $field )
		);
		$reflLangCode = new ReflectionProperty( 'Wikia\Search\Field\Field', 'languageCode' );
		$reflLangCode->setAccessible( true );
		$this->assertEquals(
				'en',
				$reflLangCode->getValue( $field )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07819 ms
	 * @covers Wikia\Search\Field\Field::__toString()
	 */
	public function test__toString() {
		$field = new Field\Field( 'html', 'en' );
		$this->assertEquals(
				'html_en',
				$field->__toString()
		);
		$field = new Field\Field( 'html', 'zzzz' );
		$this->assertEquals(
				'html',
				$field->__toString()
		);
		$field = new Field\Field( 'redirect_titles', 'en' );
		$this->assertEquals(
				'redirect_titles_mv_en',
				$field->__toString()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.0808 ms
	 * @covers Wikia\Search\Field\FieldExpression::getFieldValueString
	 * @covers Wikia\Search\Field\FieldExpression::__toString()
	 */
	public function testFieldExpression__toString() {
		$mockFe = $this->getMockBuilder( 'Wikia\Search\Field\FieldExpression' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'getNegationString', 'getFieldValueString', 'getBoostString' ) )
		               ->getMock();
		
		$mockFe
		    ->expects( $this->once() )
		    ->method ( 'getNegationString' )
		    ->will   ( $this->returnValue( '-' ) )
		;
		$mockFe
		    ->expects( $this->once() )
		    ->method ( 'getFieldValueString' )
		    ->will   ( $this->returnValue( '(foo:bar)' ) )
		;
		$mockFe
		    ->expects( $this->once() )
		    ->method ( 'getBoostString' )
		    ->will   ( $this->returnValue( '^5' ) )
		;
		$this->assertEquals(
				'-(foo:bar)^5',
				$mockFe->__toString()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07788 ms
	 * @covers Wikia\Search\Field\FieldExpression::getFieldValueString
	 * @covers Wikia\Search\Field\FieldExpression::getNegationString
	 * @covers Wikia\Search\Field\FieldExpression::setNegate
	 */
	public function testNegation()
	{
		$field = new Field\Field( 'foo', 'en' );
		$expr = new Field\FieldExpression( $field, array( 'value' => 'bar' ) );
		
		$this->assertEquals(
				"(foo:bar)",
				$expr->__toString()
		);
		$expr->setNegate( true );
		$this->assertEquals(
				"-(foo:bar)",
				$expr->__toString()
		);
	}
	
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07862 ms
	 * @covers Wikia\Search\Field\FieldExpression::getFieldValueString
	 * @covers Wikia\Search\Field\FieldExpression::getBoostString
	 * @covers Wikia\Search\Field\FieldExpression::setBoost
	 */
	public function testBoosting()
	{
		$field = new Field\Field( 'foo', 'en' );
		$expr = new Field\FieldExpression( $field, array( 'value' => 'bar' ) );
		
		$this->assertEquals(
				"(foo:bar)",
				$expr->__toString()
		);
		$expr->setBoost( 5 );
		$this->assertEquals(
				"(foo:bar)^5",
				$expr->__toString()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07784 ms
	 * @covers Wikia\Search\Field\FieldExpression::getFieldValueString
	 * @covers Wikia\Search\Field\FieldExpression::setValueQuote
	 */
	public function testQuoting()
	{
		$field = new Field\Field( 'foo', 'en' );
		$expr = new Field\FieldExpression( $field, array( 'value' => 'bar' ) );
		
		$this->assertEquals(
				"(foo:bar)",
				$expr->__toString()
		);
		$expr->setValueQuote( '"' );
		$this->assertEquals(
				'(foo:"bar")',
				$expr->__toString()
		);
	}
}
