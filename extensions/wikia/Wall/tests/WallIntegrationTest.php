<?php

/**
 * @group Integration
 */
class WallIntegrationTest extends WikiaDatabaseTest {
	private const NOT_WALL_ID = 885;
	private const VALID_WALL_ID = 1204;
	private const VALID_WALL_PAGE = 'ValidWallPage';

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		require_once __DIR__ . '/../Wall.setup.php';
	}

	public function testShouldReturnNullWhenPageWithGivenIdDoesNotExist(): void {
		$wall = Wall::newFromId( 256 );

		$this->assertNull( $wall );
	}

	public function testShouldReturnNullWhenGivenIdDoesNotBelongToWallPage(): void {
		$wall = Wall::newFromId( self::NOT_WALL_ID );

		$this->assertNull( $wall );
	}

	public function testShouldReturnNullWhenGivenTitleDoesNotBelongToWallPage(): void {
		$title = Title::makeTitle( NS_MAIN, 'NotWallEither');

		$wall = Wall::newFromTitle( $title );

		$this->assertNull( $wall );
	}

	public function testShouldCreateWallBasedOnIdOfWallPage(): void {
		$wall = Wall::newFromId( self::VALID_WALL_ID );

		$this->assertInstanceOf( Wall::class, $wall );
		$this->assertEquals( self::VALID_WALL_PAGE, $wall->getTitle()->getText() );
	}

	public function testShouldCreateWallBasedOnTitleOfWallPage(): void {
		$title = Title::makeTitle( NS_USER_WALL, self::VALID_WALL_PAGE );

		$wall = Wall::newFromTitle( $title );

		$this->assertInstanceOf( Wall::class, $wall );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/wall.yaml' );
	}
}
