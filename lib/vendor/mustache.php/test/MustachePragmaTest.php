<?php

require_once '../Mustache.php';

/**
 * @group pragmas
 */
class MustachePragmaTest extends PHPUnit_Framework_TestCase {

	public function testUnknownPragmaException() {
		$m = new MustachePHP();

		try {
			$m->render('{{%I-HAVE-THE-GREATEST-MUSTACHE}}');
		} catch (MustachePHPException $e) {
			$this->assertEquals(MustachePHPException::UNKNOWN_PRAGMA, $e->getCode(), 'Caught exception code was not MustacheException::UNKNOWN_PRAGMA');
			return;
		}

		$this->fail('Mustache should have thrown an unknown pragma exception');
	}

	public function testSuppressUnknownPragmaException() {
		$m = new LessWhinyMustache();

		try {
			$this->assertEquals('', $m->render('{{%I-HAVE-THE-GREATEST-MUSTACHE}}'));
		} catch (MustachePHPException $e) {
			if ($e->getCode() == MustachePHPException::UNKNOWN_PRAGMA) {
				$this->fail('Mustache should have thrown an unknown pragma exception');
			} else {
				throw $e;
			}
		}
	}

	public function testPragmaReplace() {
		$m = new MustachePHP();
		$this->assertEquals('', $m->render('{{%UNESCAPED}}'), 'Pragma tag not removed');
	}

	public function testPragmaReplaceMultiple() {
		$m = new MustachePHP();

		$this->assertEquals('', $m->render('{{%  UNESCAPED  }}'), 'Pragmas should allow whitespace');
		$this->assertEquals('', $m->render('{{% 	UNESCAPED 	foo=bar  }}'), 'Pragmas should allow whitespace');
		$this->assertEquals('', $m->render("{{%UNESCAPED}}\n{{%UNESCAPED}}"), 'Multiple pragma tags not removed');
		$this->assertEquals(' ', $m->render('{{%UNESCAPED}} {{%UNESCAPED}}'), 'Multiple pragma tags not removed');
	}

	public function testPragmaReplaceNewline() {
		$m = new MustachePHP();
		$this->assertEquals('', $m->render("{{%UNESCAPED}}\n"), 'Trailing newline after pragma tag not removed');
		$this->assertEquals("\n", $m->render("\n{{%UNESCAPED}}\n"), 'Too many newlines removed with pragma tag');
		$this->assertEquals("1\n23", $m->render("1\n2{{%UNESCAPED}}\n3"), 'Wrong newline removed with pragma tag');
	}

	public function testPragmaReset() {
		$m = new MustachePHP('', array('symbol' => '>>>'));
		$this->assertEquals('>>>', $m->render('{{{symbol}}}'));
		$this->assertEquals('>>>', $m->render('{{%UNESCAPED}}{{symbol}}'));
		$this->assertEquals('>>>', $m->render('{{{symbol}}}'));
	}
}

class LessWhinyMustache extends MustachePHP {
	protected $_throwsExceptions = array(
		MustachePHPException::UNKNOWN_VARIABLE         => false,
		MustachePHPException::UNCLOSED_SECTION         => true,
		MustachePHPException::UNEXPECTED_CLOSE_SECTION => true,
		MustachePHPException::UNKNOWN_PARTIAL          => false,
		MustachePHPException::UNKNOWN_PRAGMA           => false,
	);
}