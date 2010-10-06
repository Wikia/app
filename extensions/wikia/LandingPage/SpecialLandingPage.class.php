<?php

class SpecialLandingPage extends UnlistedSpecialPage {


	var $button_url;
	var $logged_in;
	var $logInClass;
	
	function __construct() {
		wfLoadExtensionMessages('LandingPage');
		parent::__construct('LandingPage');
	}

	function execute($par) {
		global $wgOut, $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgShowMyToolsOnly, $wgExtensionsPath, $wgBlankImgUrl, $wgJsMimeType, $wgStyleVersion, $wgTitle, $wgUser, $wgRequest;
		wfProfileIn(__METHOD__);


		// forces the skin to oasis
		if ($wgRequest->getVal("oasis_upgrade")) {;	
			$wgUser->setOption("skin", "oasis");
			$wgUser->saveSettings();
			
			NotificationsModule::addConfirmation(wfMsg('landingpage-change-notification'), array(), 1);
		}
		
		$this->button_url = $wgTitle->getLocalURL(array("oasis_upgrade"=> "true"));
		$this->setHeaders();
		$wgOut->addStyle(wfGetSassUrl('extensions/wikia/LandingPage/css/LandingPage.scss'));
		
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/LandingPage/js/LandingPage.js?{$wgStyleVersion}\" ></script>\n");
		// hide wiki and page header
		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;
		
		
		if ($wgUser->isLoggedIn() === true) {
			$this->logInClass = '';
		}
		else {
			$this->logInClass = ' class="ajaxLogin"';
		}
	
		
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
				'name' => 'Healthy Recipes',
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
			'button_url' => $this->button_url,
			'current_skin' => $wgUser->mOptions["skin"],
			'logInClass' => $this->logInClass
		));

		$wgOut->addHTML($template->render('main'));
		wfProfileOut(__METHOD__);
	}
}
