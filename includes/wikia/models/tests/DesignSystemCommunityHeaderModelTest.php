<?php

class DesignSystemCommunityHeaderModelTest extends WikiaBaseTest {
    private $communityHeaderModel;

    /**
	 * Test IntentX API
	 */
    public function setUp() {
        parent::setUp();
        require_once __DIR__ . '/../DesignSystemCommunityHeaderModel.class.php';
        
        $this->communityHeaderModel = new DesignSystemCommunityHeaderModel( 'en' );
    }


    /**
     *  Test formatting of fandom store data
     */
    public function testFormatFandomStoreData() {
        $mockApiData = array(
            (object)[
            'text' => 'Shop',
            'url' => 'www.fandom.shop.com'
            ],
            (object)[
                'text' => 'Apparel',
                'url' => 'www.fandom.shop.com/apparel'
            ],
            (object)[
                'text' => 'Games',
                'url' => 'www.fandom.shop.com/games'
            ]
        );

        $expected = array(
            'url' => 'www.fandom.shop.com',
            'value' => 'Shop',
            'tracking' => 'explore-shop',
            'include' => true,
            'items' => array(
                [
                    'tracking' => 'explore-shop-apparel',
                    'url' => 'www.fandom.shop.com/apparel',
                    'value' => 'Apparel'
                ],
                [
                    'tracking' => 'explore-shop-games',
                    'url' => 'www.fandom.shop.com/games',
                    'value' => 'Games'
                ]
            )
        );

        $formattedData = $this->communityHeaderModel->formatFandomStoreData( $mockApiData );

        // test function returns properly formatted data
        $this->assertArrayEquals( $formattedData, $expected );

        $noDataPassedIn = $this->communityHeaderModel->formatFandomStoreData( [] );

        // test returns null when no data is passed in
        $this->assertEquals( $noDataPassedIn, NULL );
    }

    protected function objectAssociativeSort( array &$array ) {
		uasort(
			$array,
			function ( $a, $b ) {
				return serialize( $a ) > serialize( $b ) ? 1 : -1;
			}
		);
	}

    protected function assertArrayEquals( array $expected, array $actual, $ordered = false, $named = false ) {
		if ( !$ordered ) {
			$this->objectAssociativeSort( $expected );
			$this->objectAssociativeSort( $actual );
		}

		if ( !$named ) {
			$expected = array_values( $expected );
			$actual = array_values( $actual );
		}

		call_user_func_array(
			array( $this, 'assertEquals' ),
			array_merge( array( $expected, $actual ), array_slice( func_get_args(), 4 ) )
		);
	}
}
