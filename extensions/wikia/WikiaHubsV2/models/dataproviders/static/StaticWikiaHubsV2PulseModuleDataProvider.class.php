<?php

/**
 * Class for Hubs V2 pulse module data provider
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class StaticWikiaHubsV2PulseModuleDataProvider extends MysqlWikiaHubsV2ModuleDataProvider {

	public function getData() {
		return array(
			'title' => array(
				'anchor' => 'WoWwiki',
				'href' => 'http://www.wowwiki.com'
			),
			'socialmedia' => array(
				'facebook' => 'link to facebook',
				'googleplus' => 'link to G+',
				'twitter' => 'link to twitter',
			),
			'boxes' => array(
				array(
					'headline' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'unit' => 'editors',
					'link' => array(
						'anchor' => 'see more',
						'href' => 'http://www.wowwiki.com'
					),
				),
				array(
					'headline' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'unit' => 'pages',
					'link' => array(
						'anchor' => 'see more',
						'href' => 'http://www.wowwiki.com'
					),
				),
				array(
					'headline' => array(
						'anchor' => 'WoWwiki',
						'href' => 'http://www.wowwiki.com'
					),
					'number' => 10000,
					'unit' => 'videos',
					'link' => array(
						'anchor' => 'see more',
						'href' => 'http://www.wowwiki.com'
					),
				)
			)
		);
	}

	public function storeData($data) {

	}
}