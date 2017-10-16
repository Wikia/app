<?php

class OasisControllerTest extends WikiaBaseTest {

	/**
	 * @param $themeSettings array
	 * @param $expectedBodyClasses array
	 * @dataProvider testGetOasisBackgroundClassesDataProvider
	 */
	public function testGetOasisBackgroundClasses( $themeSettings, $expectedBodyClasses ) {
		$class = new ReflectionClass( 'OasisController' );
		$method = $class->getMethod( 'getOasisBackgroundClasses' );
		$method->setAccessible( true );

		$oasisController = new OasisController();
		$actualBodyClasses = $method->invokeArgs( $oasisController, [ $themeSettings ] );

		$this->assertEquals( $expectedBodyClasses, $actualBodyClasses );
	}


	public function testGetOasisBackgroundClassesDataProvider() {
		return [
			[
				// nothing set, no classes
				[ ],
				[ ]
			],
			[
				// background-fixed
				[ 'background-fixed' => true ],
				[ 'background-fixed' ]
			],
			[
				// background-fixed explicitly false
				[ 'background-fixed' => false ],
				[ ]
			],
			[
				// background-fixed, string
				[ 'background-fixed' => 'true' ],
				[ 'background-fixed' ]
			],
			[
				// background-fixed explicitly false, string
				[ 'background-fixed' => 'false' ],
				[ ]
			],
			[
				// background-fixed, tiled enabled
				[
					'background-fixed' => true,
					'background-tiled' => true
				],
				[ 'background-fixed' ]
			],
			[
				// background-fixed, tiled enabled, string
				[
					'background-fixed' => 'true',
					'background-tiled' => 'true'
				],
				[ 'background-fixed' ]
			],
			[
				// background-not-tiled
				[
					'background-fixed' => false,
					'background-tiled' => false
				],
				[ 'background-not-tiled' ]

			],
			[
				// background-not-tiled, string
				[
					'background-fixed' => 'false',
					'background-tiled' => 'false'
				],
				[ 'background-not-tiled' ]

			],
			[
				// background-tiled, image set
				[
					'background-tiled' => true,
					'background-image-width' => ThemeSettings::MIN_WIDTH_FOR_SPLIT
				],
				[ ]

			],
			[
				// background-tiled, image set, string
				[
					'background-tiled' => 'true',
					'background-image-width' => '\'' . ThemeSettings::MIN_WIDTH_FOR_SPLIT . '\''
				],
				[ ]

			],
			[
				// dynamic background from image size
				[
					'background-tiled' => false,
				  	'background-image-width' => ThemeSettings::MIN_WIDTH_FOR_SPLIT
				],
				[
					'background-not-tiled',
					'background-dynamic'
				]
			],
			[
				// dynamic background from image size, string
				[
					'background-tiled' => 'false',
					'background-image-width' => '\'' . ThemeSettings::MIN_WIDTH_FOR_SPLIT . '\''
				],
				[
					'background-not-tiled',
				]
			],
			[
				// dynamic background, explicit
				[
					'background-tiled' => false,
					'background-dynamic' => true
				],
				[
					'background-not-tiled',
					'background-dynamic'
				]
			],
			[
				// dynamic background, explicit, string
				[
					'background-tiled' => 'false',
					'background-dynamic' => 'true'
				],
				[
					'background-not-tiled',
					'background-dynamic'
				]
			],
		];
	}

}
