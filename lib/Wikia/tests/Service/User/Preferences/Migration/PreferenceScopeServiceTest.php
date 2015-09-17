<?php

namespace Wikia\Service\User\Preferences\Migration;

use PHPUnit_Framework_TestCase;

class PreferenceScopeServiceTest extends PHPUnit_Framework_TestCase {

	public function testGlobalLiterals() {
		$service = new PreferenceScopeService( ['literals' => ['language']], [] );
		$this->assertTrue( $service->isGlobalPreference( 'language' ) );
		$this->assertFalse( $service->isGlobalPreference( 'marketingallowed' ) );
	}

	public function testGlobalRegex() {
		$service = new PreferenceScopeService( ['regexes' => ['([a-z]+)-toolbar-contents$']], [] );
		$this->assertTrue( $service->isGlobalPreference( 'oasis-toolbar-contents' ) );
	}

	public function testGlobal() {
		$service = new PreferenceScopeService(
			['literals' => ['language'], 'regexes' => ['([a-z]+)-toolbar-contents$']],
			[] );

		$this->assertTrue( $service->isGlobalPreference( 'language' ) );
		$this->assertFalse( $service->isGlobalPreference( 'marketingallowed' ) );
		$this->assertTrue( $service->isGlobalPreference( 'oasis-toolbar-contents' ) );
	}

	public function testLocal() {
		$service = new PreferenceScopeService( [], ['regexes' => ['^adoptionmails-([0-9]+)']] );
		$this->assertTrue( $service->isLocalPreference( 'adoptionmails-123' ) );
	}

	public function testNoneDefined() {
		$service = new PreferenceScopeService( [], [] );
		$this->assertFalse( $service->isGlobalPreference( 'language' ) );
		$this->assertFalse( $service->isLocalPreference( 'adoptionmails-123' ) );
	}

	public function testGlobalAndLocals() {
		$service = new PreferenceScopeService(
			['literals' => ['language'], 'regexes' => ['([a-z]+)-toolbar-contents$']],
			['regexes' => ['^adoptionmails-([0-9]+)']] );

		$this->assertTrue( $service->isGlobalPreference( 'language' ) );
		$this->assertTrue( $service->isGlobalPreference( 'oasis-toolbar-contents' ) );
		$this->assertTrue( $service->isLocalPreference( 'adoptionmails-123' ) );

		$this->assertFalse( $service->isLocalPreference( 'language' ) );
		$this->assertFalse( $service->isLocalPreference( 'oasis-toolbar-contents' ) );
		$this->assertFalse( $service->isGlobalPreference( 'adoptionmails-123' ) );
	}
}
