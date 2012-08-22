<?php

/**
 * Class for Hubs V2 slider module data provider
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class StaticWikiaHubsV2SliderModuleDataProvider extends MysqlWikiaHubsV2ModuleDataProvider {

	public function getData() {
		$data = array(
			'images' => array(
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'href' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'href' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'href' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'href' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
				array(
					'image' => 'File:Wikia-Visualization-Main,rappelz.png',
					'href' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'title' => 'Gaming Olympics',
					'headline' => 'Exclusively on Wikia!',
					'description' => 'Participate in the biggest gaming event of 2012'
				),
			)
		);

		foreach ($data['images'] as &$image) {
			$image['imagethumb'] = $this->getStandardThumbnailUrl($image['image']);
		}
		return $data;
	}

	public function storeData($data) {

	}
}