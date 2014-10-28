<?php

class ExactTargetSetupHooksTest extends WikiaBaseTest {

	/**
	 * Determine whether update should be performed on specific environment
	 * @dataProvider shouldUpdateProvider
	 * @param string $sProduction
	 * @param bool $bDevelopmentMode
	 * @param bool $bExpectsShouldUpdate
	 */
	function testShouldUpdate( $sEnvironment, $bDevelopmentMode, $bExpectsShouldUpdate ) {
		/* Mock global vars */
		$this->mockGlobalVariable( 'wgWikiaEnvironment', $sEnvironment );
		$this->mockGlobalVariable( 'wgExactTargetDevelopmentMode', $bDevelopmentMode );
		/* Get mock object of tested class */
		$exactTargetUpdatesHooksMock = $this->getMockBuilder( 'ExactTargetSetupHooks' )
			->setMethods( null )
			->getMock();

		/* Use reflection and set accessibility of method as some of tested methods may be private */
		$method = new ReflectionMethod( 'ExactTargetSetupHooks', 'shouldUpdate' );
		$method->setAccessible( true );

		/* Run tested method */
		$bActualResult = $method->invoke( $exactTargetUpdatesHooksMock );

		$this->assertEquals( $bActualResult, $bExpectsShouldUpdate );

	}

	function shouldUpdateProvider() {
		/* Define environment constants if not defined yet */
		if ( !defined( 'WIKIA_ENV_PROD' ) ) {
			define( WIKIA_ENV_PROD, 'test-prod') ;
		}
		if ( !defined( 'WIKIA_ENV_DEV' ) ) {
			define( WIKIA_ENV_DEV, 'test-dev') ;
		}
		if ( !defined( 'WIKIA_ENV_INTERNAL' ) ) {
			define( WIKIA_ENV_INTERNAL, 'test-internal' );
		}

		$bDevelopmentModeEnabled = true;
		$bDevelopmentModeDisabled = false;
		$bExpectsShouldUpdate = true;
		$bExpectsShouldNotUpdate = false;

		return [
			[ WIKIA_ENV_PROD, $bDevelopmentModeDisabled, $bExpectsShouldUpdate ],
			[ WIKIA_ENV_PROD, $bDevelopmentModeEnabled, $bExpectsShouldUpdate ],
			[ WIKIA_ENV_DEV, $bDevelopmentModeDisabled, $bExpectsShouldNotUpdate ],
			[ WIKIA_ENV_DEV, $bDevelopmentModeEnabled, $bExpectsShouldUpdate ],
			[ WIKIA_ENV_INTERNAL, $bDevelopmentModeDisabled, $bExpectsShouldNotUpdate ],
			[ WIKIA_ENV_INTERNAL, $bDevelopmentModeEnabled, $bExpectsShouldUpdate ],
		];
	}

}
