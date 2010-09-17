<?php

class SpecialLandingPage extends UnlistedSpecialPage {

	function __construct() {
		wfLoadExtensionMessages('LandingPage');
		parent::__construct('LandingPage');
	}

	function execute($par) {
		global $wgOut, $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgShowMyToolsOnly, $wgExtensionsPath, $wgBlankImgUrl;
		wfProfileIn(__METHOD__);

		$this->setHeaders();
		$wgOut->addStyle(wfGetSassUrl('extensions/wikia/LandingPage/css/LandingPage.scss'));

		// hide wiki and page header
		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;

		// only shown "My Tools" on floating toolbar
		$wgShowMyToolsOnly = true;

		// example wikis
		$wikis = array(
			array(
				'name' => 'Muppet Wiki',
				'url' => 'http://muppet.wikia.com',
				'image' => 'muppet-wiki.jpg',
			),
			array(
				'name' => 'Healty Recipes',
				'url' => 'http://healthyrecipes.wikia.com',
				'image' => 'healthy-recipes.jpg',
			),
			array(
				'name' => 'Twilight Saga',
				'url' => 'http://twilight.wikia.com',
				'image' => 'twilight-saga.jpg',
			),
			array(
				'name' => 'Glee',
				'url' => 'http://glee.wikia.com',
				'image' => 'glee.jpg',
			),
			array(
				'name' => 'Red Dead Redemption',
				'url' => 'http://reddead.wikia.com',
				'image' => 'red-dead-redemption.jpg',
			),

		);

		// render HTML
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'imagesPath' => $wgExtensionsPath . '/wikia/LandingPage/images/',
			'wgBlankImgUrl' => $wgBlankImgUrl,
			'wikis' => $wikis,
		));

		$wgOut->addHTML($template->render('main'));
		wfProfileOut(__METHOD__);
	}
}
