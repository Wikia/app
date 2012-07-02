<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( !$IP ) {
	if ( file_exists( "../../includes/DefaultSettings.php" ) ) {
		$IP = '../..';
	} elseif ( file_exists( "../../phase3/includes/DefaultSettings.php" ) ) {
		$IP = '../../phase3';
	} else {
		die( 'Please set MW_INSTALL_PATH' );
	}
}

require_once( "$IP/includes/AutoLoader.php" );
require_once( "$IP/includes/normal/UtfNormalUtil.php" );
require_once( dirname( __FILE__ ) . '/SpoofUser.php' );
require_once( dirname( __FILE__ ) . '/AntiSpoof_body.php' );

class TestSpoof extends PHPUnit_Framework_TestCase {

	public function providePositives() {
		return array(
			array( 'Laura Fiorucci', 'Låura Fiorucci' ),
			array( 'Lucien leGrey', 'Lucien le6rey' ),
			array( 'Poco a poco', 'Poco a ƿoco' ),
			array( 'Comae', 'Comæ' ),
			array( 'Sabbut', 'ЅаЬЬцт'),
			array( 'BetoCG', 'ВетоС6' )
		);
	}

	/**
	 * @dataProvider providePositives
	 * See http://www.phpunit.de/manual/3.4/en/appendixes.annotations.html#appendixes.annotations.dataProvider
	 */
	public function testCheckSpoofing( $userName, $spooferName ) {
		$Alice = new SpoofUser( $userName );
		$Eve = new SpoofUser( $spooferName );

		if ( $Eve->isLegal() ) {
			$this->assertEquals( $Alice->getNormalized(), $Eve->getNormalized(), "Check that '$spooferName' can't spoof account '$userName'");
		}
	}
}
