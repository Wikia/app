<?php

class SpotlightsModel extends WikiaModel {
	const IMG_WIDTH = 255;
	const IMG_HEIGHT = 123;
	const WIKI_VISUALIZATION_IMG = 'Wikia-Visualization-Main.png';

	/**
	 * Gets set of wikis from given vertical and community wikis
	 *
	 * @param string $vertical Vertical name
	 * @return array
	 */
	public function getOpenXSpotlights( $vertical ) {
		$spotlights = [];
		$verticalsData = $this->getOpenXVerticalData();

		if ( isset( $verticalsData[ $vertical ] ) ) {
			$spotlights = $verticalsData[ $vertical ];
		}

		return $spotlights;
	}

	/**
	 * Gets three recommended wikis from Tipsy for given wiki
	 *
	 * @param int $cityId Wiki ID
	 * @return array
	 */
	public function getTipsySpotlights( $cityId ) {
		$spotlights = [];
		$tipsy = $this->getTipsyData();

		if ( isset( $tipsy[ $cityId ] ) ) {
			$spotlights = $tipsy[ $cityId ];
			foreach ( $spotlights as &$spotlight ) {
				$spotlight[ 'image' ] = $this->getSpotlightImage( $spotlight[ 'url' ] );
			}
		}

		return $spotlights;
	}

	/**
	 * Gets wiki main image
	 *
	 * @param $url Wiki url
	 * @return null|string
	 */
	private function getSpotlightImage( $url ) {
		$imageUrl = null;
		$cityId = WikiFactory::UrlToID( $url );
		$helper = new WikiaHomePageHelper();
		$title = GlobalTitle::newFromText( self::WIKI_VISUALIZATION_IMG, NS_FILE, $cityId );
		if ( $title !== null ) {
			$file = new GlobalFile( $title );
			if ( $file !== null ) {
				$originalWidth = $file->getWidth();
				$originalHeight = $file->getHeight();
				$imageServing = $helper->getImageServingForResize(
					self::IMG_WIDTH,
					self::IMG_HEIGHT,
					$originalWidth,
					$originalHeight
				);
				$imageUrl = $imageServing->getUrl( $file, $originalWidth, $originalHeight );
			}
		}
		return $imageUrl;
	}

	/**
	 * Mocked set of recommended wiki from Tipsy
	 *
	 * @return array
	 */
	private function getTipsyData() {
		return [
			// Elder Scrolls
			1706 => [
				0 => [
					'url' => 'http://fallout.wikia.com/',
					'image' => '',
					'text' => 'Fallout Wiki',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://leagueoflegends.wikia.com/',
					'image' => '',
					'text' => 'League of Legends Wiki',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://gta.wikia.com/',
					'image' => '',
					'text' => 'GTA Wiki',
					'subtitle' => ''
				]
			],
			// RuneScape
			304 => [
				0 => [
					'url' => 'http://2007.runescape.wikia.com/',
					'image' => '',
					'text' => '"2007scape Wiki',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://leagueoflegends.wikia.com/',
					'image' => '',
					'text' => 'League of Legends Wiki',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://elderscrolls.wikia.com/',
					'image' => '',
					'text' => 'Elder Scrolls Wiki',
					'subtitle' => ''
				]
			],
			// League of Legends
			14764 => [
				0 => [
					'url' => 'http://elderscrolls.wikia.com/',
					'image' => '',
					'text' => 'Elder Scrolls Wiki',
					'subtitle' => ''

				],
				1 => [
					'url' => 'http://finalfantasy.wikia.com/',
					'image' => '',
					'text' => 'Final Fantasy Wiki',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://runescape.wikia.com/',
					'image' => '',
					'text' => 'Runescape Wiki',
					'subtitle' => ''
				]
			],
			// Warframe
			544934 => [
				0 => [
					'url' => 'http://leagueoflegends.wikia.com/',
					'image' => '',
					'text' => 'League of Legends Wiki',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://elderscrolls.wikia.com/',
					'image' => '',
					'text' => 'Elder Scrolls Wiki',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://dont-starve-game.wikia.com/',
					'image' => '',
					'text' => 'Dont\' Starve Wiki',
					'subtitle' => ''
				]
			],
			// Fallout
			3035 => [
				0 => [
					'url' => 'http://elderscrolls.wikia.com/',
					'image' => '',
					'text' => 'Elder Scrolls Wiki',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://gta.wikia.com/',
					'image' => '',
					'text' => 'GTA Wiki',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://leagueoflegends.wikia.com/',
					'image' => '',
					'text' => 'League of Legends Wiki',
					'subtitle' => ''
				]
			],
			// Disney
			374 => [
				0 => [
					'url' => 'http://pixar.wikia.com/',
					'image' => '',
					'text' => 'Pixar Wiki',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://villains.wikia.com/',
					'image' => '',
					'text' => 'Villains Wiki',
				],
				2 => [
					'url' => 'http://harrypotter.wikia.com/',
					'image' => '',
					'text' => 'Harry Potter Wiki',
					'subtitle' => ''
				]
			],
			// Yu-Gi-Oh!
			410 => [
				0 => [
					'url' => 'http://cardfight.wikia.com/',
					'image' => '',
					'text' => 'Cardfight Wiki',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://naruto.wikia.com/',
					'image' => '',
					'text' => 'Naruto Wiki',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://onepiece.wikia.com/',
					'image' => '',
					'text' => 'One Piece Wiki',
					'subtitle' => ''
				]
			],
			// Cardfight
			185111 => [
				0 => [
					'url' => 'http://yugioh.wikia.com/',
					'image' => '',
					'text' => 'Yu-Gi-Oh Wiki',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://buddyfight.wikia.com/',
					'image' => '',
					'text' => 'Buddy Fight Wiki',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://naruto.wikia.com/',
					'image' => '',
					'text' => 'Naruto Wiki',
					'subtitle' => ''
				]
			],
			// Lyrics
			43339 => [
				0 => [
					'url' => 'http://disney.wikia.com/',
					'image' => '',
					'text' => 'Disney Wiki',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://starwars.wikia.com/',
					'image' => '',
					'text' => 'Star Wars Wiki',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://harrypotter.wikia.com/',
					'image' => '',
					'text' => 'Harry Potter Wiki',
					'subtitle' => ''
				]
			],
			// Arrested Development
			2514 => [
				0 => [
					'url' => 'http://starwars.wikia.com/',
					'image' => '',
					'text' => 'Star Wars Wiki',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://harrypotter.wikia.com/',
					'image' => '',
					'text' => 'Harry Potter Wiki',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://gameofthrones.wikia.com',
					'image' => '',
					'text' => 'Game of Thrones Wiki',
					'subtitle' => ''
				]
			],
		];
	}

	/**
	 * Mocked set of recommended wikis for Gaming and Entertainment vertical
	 *
	 * @return array
	 */
	private function getOpenXVerticalData() {
		return [
			'Gaming' => [
				0 => [
					'url' => 'http://brokenage.wikia.com/wiki/Broken_Age_Wiki',
					'image' => 'http://spotlights.wikia.net/images//1f695a4d8cbe26c9bd85a836c03df857.jpg',
					'text' => '',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://dont-starve-game.wikia.com/',
					'image' => 'http://spotlights.wikia.net/images//7d7d99a9f712349feca0166bb1dd15c3.jpg',
					'text' => '',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://mario.wikia.com/wiki/MarioWiki',
					'image' => 'http://spotlights.wikia.net/images//cc8048a2c2b7cda4eb32cf14273acefd.jpg',
					'text' => '',
					'subtitle' => ''
				],
				3 => [
					'url' => 'http://starbound.wikia.com/wiki/Starbound_Wiki',
					'image' => 'http://spotlights.wikia.net/images//23391d82f84006be1a34dc1cbfde7d36.jpg',
					'text' => '',
					'subtitle' => ''
				],
				4 => [
					'url' => 'http://www.tomb-raider.wikia.com/wiki/Tomb_raider_wiki',
					'image' => 'http://spotlights.wikia.net/images//22deb6e6d56fef38bcc0c4a83c3b3aa8.jpg',
					'text' => '',
					'subtitle' => ''
				],
				5 => [
					'url' => 'http://walkingdead.wikia.com/wiki/The_Walking_Dead_Wiki',
					'image' => 'http://spotlights.wikia.net/images//79f9375761a536b74c753892038e0105.jpg',
					'text' => '',
					'subtitle' => ''
				],
			],
			'Entertainment' => [
				0 => [
					'url' => 'http://black-sails.wikia.com/wiki/Black_Sails_Wiki',
					'image' => 'http://spotlights.wikia.net/images//ed51aa0c6c9ffcba35c23a01df2202e8.jpg',
					'text' => '',
					'subtitle' => ''
				],
				1 => [
					'url' => 'http://chozen.wikia.com/wiki/Chozenpedia',
					'image' => 'http://spotlights.wikia.net/images//8c2aedcf43c8b603a6de0661795fca80.jpg',
					'text' => '',
					'subtitle' => ''
				],
				2 => [
					'url' => 'http://looking.wikia.com/wiki/Looking_Wiki',
					'image' => 'http://spotlights.wikia.net/images//d23229e7478535e958f033ad0549f3b6.jpg',
					'text' => '',
					'subtitle' => ''
				],
				3 => [
					'url' => 'http://rwbyfanon.wikia.com/wiki/RWBY_Fanon_Wiki',
					'image' => 'http://spotlights.wikia.net/images//1384da64904a22d325f6749f7fde5238.jpg',
					'text' => '',
					'subtitle' => ''
				],
				4 => [
					'url' => 'http://sleepyhollow.wikia.com/wiki/SleepyHollow_Wiki',
					'image' => 'http://spotlights.wikia.net/images//a75299997b1d1259e1edb2e59633773f.jpg',
					'text' => '',
					'subtitle' => ''
				],
				5 => [
					'url' => 'http://supernatural.wikia.com/wiki/Season_9',
					'image' => 'http://spotlights.wikia.net/images//a1abcb84b26d9fee393247674dc3adda.jpg',
					'text' => '',
					'subtitle' => ''
				],
				6 => [
					'url' => 'http://vampirediaries.wikia.com/wiki/The_Originals_(TV_Series)',
					'image' => 'http://spotlights.wikia.net/images//8156df572c011a3fa6aeef92d0dbf661.jpg',
					'text' => '',
					'subtitle' => ''
				],
				7 => [
					'url' => 'http://vsbattles.wikia.com/wiki/VS_Battles_Wiki',
					'image' => 'http://spotlights.wikia.net/images//729b6c43e955052c15117b1ca8054911.jpg',
					'text' => '',
					'subtitle' => ''
				],
			]
		];
	}

	/**
	 * Mocked set of wikis from community
	 *
	 * @return array
	 */
	public function getOpenXCommunityData() {
		return [
			0 => [
				'url' => 'http://community.wikia.com/wiki/Community_Central:Community_Development_Team/Requests',
				'image' => 'http://spotlights.wikia.net/images//c83b9213bdeaee20d20fd3ca347c7664.jpg',
				'text' => '',
				'subtitle' => '',
			],
			1 => [
				'url' => 'http://www.wikia.com/Special:CreateWiki',
				'image' => 'http://spotlights.wikia.net/images//ad4aa4b38e65ac7052ef490cdfc32718.jpg',
				'text' => '',
				'subtitle' => ''
			],
			2 => [
				'url' => 'http://shadowofmordor.wikia.com/wiki/Shadow_of_Mordor_Wikia',
				'image' => 'http://spotlights.wikia.net/images//13b98fae5aa5ff3094e0f013b8fda0f3.jpg',
				'text' => '',
				'subtitle' => ''
			],
		];
	}
}
