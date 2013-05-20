<?php

require_once '../Mustache.php';

class MustacheExceptionTest extends PHPUnit_Framework_TestCase {

	const TEST_CLASS = 'Mustache';

	protected $pickyMustache;
	protected $slackerMustache;

	public function setUp() {
		$this->pickyMustache      = new PickyMustache();
		$this->slackerMustache    = new SlackerMustache();
	}

	/**
	 * @group interpolation
	 * @expectedException MustachePHPException
	 */
	public function testThrowsUnknownVariableException() {
		$this->pickyMustache->render('{{not_a_variable}}');
	}

	/**
	 * @group sections
	 * @expectedException MustachePHPException
	 */
	public function testThrowsUnclosedSectionException() {
		$this->pickyMustache->render('{{#unclosed}}');
	}

	/**
	 * @group sections
	 * @expectedException MustachePHPException
	 */
	public function testThrowsUnclosedInvertedSectionException() {
		$this->pickyMustache->render('{{^unclosed}}');
	}

	/**
	 * @group sections
	 * @expectedException MustachePHPException
	 */
	public function testThrowsUnexpectedCloseSectionException() {
		$this->pickyMustache->render('{{/unopened}}');
	}

	/**
	 * @group partials
	 * @expectedException MustachePHPException
	 */
	public function testThrowsUnknownPartialException() {
		$this->pickyMustache->render('{{>impartial}}');
	}

	/**
	 * @group pragmas
	 * @expectedException MustachePHPException
	 */
	public function testThrowsUnknownPragmaException() {
		$this->pickyMustache->render('{{%SWEET-MUSTACHE-BRO}}');
	}

	/**
	 * @group sections
	 */
	public function testDoesntThrowUnclosedSectionException() {
		$this->assertEquals('', $this->slackerMustache->render('{{#unclosed}}'));
	}

	/**
	 * @group sections
	 */
	public function testDoesntThrowUnexpectedCloseSectionException() {
		$this->assertEquals('', $this->slackerMustache->render('{{/unopened}}'));
	}

	/**
	 * @group partials
	 */
	public function testDoesntThrowUnknownPartialException() {
		$this->assertEquals('', $this->slackerMustache->render('{{>impartial}}'));
	}

	/**
	 * @group pragmas
	 * @expectedException MustachePHPException
	 */
	public function testGetPragmaOptionsThrowsExceptionsIfItThinksYouHaveAPragmaButItTurnsOutYouDont() {
		$mustache = new TestableMustache();
		$mustache->testableGetPragmaOptions('PRAGMATIC');
	}

	public function testOverrideThrownExceptionsViaConstructorOptions() {
		$exceptions = array(
			MustachePHPException::UNKNOWN_VARIABLE,
			MustachePHPException::UNCLOSED_SECTION,
			MustachePHPException::UNEXPECTED_CLOSE_SECTION,
			MustachePHPException::UNKNOWN_PARTIAL,
			MustachePHPException::UNKNOWN_PRAGMA,
		);

		$one = new TestableMustache(null, null, null, array(
			'throws_exceptions' => array_fill_keys($exceptions, true)
		));

		$thrownExceptions = $one->getThrownExceptions();
		foreach ($exceptions as $exception) {
			$this->assertTrue($thrownExceptions[$exception]);
		}

		$two = new TestableMustache(null, null, null, array(
			'throws_exceptions' => array_fill_keys($exceptions, false)
		));

		$thrownExceptions = $two->getThrownExceptions();
		foreach ($exceptions as $exception) {
			$this->assertFalse($thrownExceptions[$exception]);
		}
	}
}

class PickyMustache extends MustachePHP {
	protected $_throwsExceptions = array(
		MustachePHPException::UNKNOWN_VARIABLE         => true,
		MustachePHPException::UNCLOSED_SECTION         => true,
		MustachePHPException::UNEXPECTED_CLOSE_SECTION => true,
		MustachePHPException::UNKNOWN_PARTIAL          => true,
		MustachePHPException::UNKNOWN_PRAGMA           => true,
	);
}

class SlackerMustache extends MustachePHP {
	protected $_throwsExceptions = array(
		MustachePHPException::UNKNOWN_VARIABLE         => false,
		MustachePHPException::UNCLOSED_SECTION         => false,
		MustachePHPException::UNEXPECTED_CLOSE_SECTION => false,
		MustachePHPException::UNKNOWN_PARTIAL          => false,
		MustachePHPException::UNKNOWN_PRAGMA           => false,
	);
}

class TestableMustache extends MustachePHP {
	public function testableGetPragmaOptions($pragma_name) {
		return $this->_getPragmaOptions($pragma_name);
	}

	public function getThrownExceptions() {
		return $this->_throwsExceptions;
	}
}
