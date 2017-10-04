<?php

use PHPUnit\Framework\TestCase;

class UserRegistrationInfoTest extends TestCase {
	/**
	 * @dataProvider provideJsonRepresentations
	 * @param string $jsonInput
	 */
	public function testJsonRoundTrip( string $jsonInput ) {
		$jsonObject = json_decode( $jsonInput, true );
		$userRegistrationInfo = UserRegistrationInfo::newFromJson( $jsonObject );

		$jsonOutput = json_encode( $userRegistrationInfo );

		$this->assertJsonStringEqualsJsonString(
			$jsonInput,
			$jsonOutput
		);
	}

	/**
	 * @dataProvider provideJsonRepresentations
	 * @param string $jsonInput
	 */
	public function testJsonDeserialize( string $jsonInput ) {
		$jsonObject = json_decode( $jsonInput, true );
		$userRegistrationInfo = UserRegistrationInfo::newFromJson( $jsonObject );

		$this->assertInstanceOf( UserRegistrationInfo::class, $userRegistrationInfo );

		$this->assertEquals(
			$jsonObject['registrationDomain'],
			$userRegistrationInfo->getRegistrationDomain()
		);

		$this->assertEquals(
			$jsonObject['userName'],
			$userRegistrationInfo->getUserName()
		);

		$this->assertEquals(
			$jsonObject['wikiId'],
			$userRegistrationInfo->getWikiId()
		);

		$this->assertEquals(
			$jsonObject['clientIp'],
			$userRegistrationInfo->getClientIp()
		);

		$this->assertEquals(
			$jsonObject['langCode'],
			$userRegistrationInfo->getLangCode()
		);

		$this->assertEquals(
			$jsonObject['emailConfirmed'],
			$userRegistrationInfo->isEmailConfirmed()
		);
	}

	public function provideJsonRepresentations(): Generator {
		yield ['{"registrationDomain":"swfanon.wikia.com","userName":"Jenkins", "wikiId": 177, "clientIp": "8.8.8.8", "langCode": "en", "emailConfirmed": false}' ];
		yield ['{"registrationDomain":"pl.wikia.com","userName":"Jan Kowalski", "wikiId": 256, "clientIp": "8.8.8.8", "langCode": "pl", "emailConfirmed": true}' ];
		yield ['{"registrationDomain":"starwars.wikia.com","userName":"Darth Vader", "wikiId": 147, "clientIp": "8.8.8.8", "langCode": "en", "emailConfirmed": false}' ];
	}
}
