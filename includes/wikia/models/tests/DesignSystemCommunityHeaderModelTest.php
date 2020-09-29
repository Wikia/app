<?php

class DesignSystemCommunityHeaderModelTest extends WikiaBaseTest {
    private $fandomStoreData;
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
     * @dataProvider getApiProvider
     */
    public function testFormatFandomStoreData( $apiData, $expected ) {
        var_dump( $apiData );
        $formattedData = $this->communityHeaderModel->formatFandomStoreData( $apiData );

        $this->assertArrayEquals( $formattedData, $expected );
    }

    public function getApiProvider() {
        return [
            [
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
            ],
            [
                'url' => 'www.fandom.shop.com',
                'value' => 'Shop',
                'tracking' => 'explore-shop',
                'include' => true,
                'items' => [
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
                ]
            ]
        ];
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
