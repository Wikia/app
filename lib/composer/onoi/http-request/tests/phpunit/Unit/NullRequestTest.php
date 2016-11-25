<?php

namespace Onoi\HttpRequest\Tests;

use Onoi\HttpRequest\NullRequest;

/**
 * @covers \Onoi\HttpRequest\NullRequest
 * @group onoi-http-request
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class NullRequestTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$instance = new NullRequest();

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\NullRequest',
			$instance
		);

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\HttpRequest',
			$instance
		);
	}

	public function testNull() {

		$instance = new NullRequest();

		$this->assertInternalType(
			'boolean',
			$instance->ping()
		);

		$this->assertInternalType(
			'null',
			$instance->setOption( 'foo', 42 )
		);

		$this->assertInternalType(
			'null',
			$instance->getOption( 'foo' )
		);

		$this->assertInternalType(
			'null',
			$instance->getLastTransferInfo()
		);

		$this->assertInternalType(
			'string',
			$instance->getLastError()
		);

		$this->assertInternalType(
			'integer',
			$instance->getLastErrorCode()
		);

		$this->assertInternalType(
			'null',
			$instance->execute()
		);
	}

}
