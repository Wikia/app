<?php
class SpecialLandingPageSmurfs extends UnlistedSpecialPage {

	private $app;

	function __construct() {
		parent::__construct('LandingPageSmurfs');
		$this->app = F::app();
	}

	function execute($par ) {
		$this->setHeaders();

		// load CSS
		$this->app->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/LandingPageSmurfs/css/LandingPageSmurfs.scss'));

		// hide wiki and page header
		$this->app->wg->SuppressWikiHeader = true;
		$this->app->wg->SuppressPageHeader = true;

		// only shown "My Tools" on floating toolbar
		$this->app->wg->ShowMyToolsOnly = true;

		// detect language
		$langCode = $this->app->wg->Lang->getCode();

		switch($langCode) {
			case 'en':
			case 'nl':
			case 'fr':
				// don't change the language
				break;

			default:
				// fallback to English
				$langCode = 'en';
		}

		// render HTML
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'langCode' => $langCode,
		));

		$this->app->wg->Out->addHTML($template->render('main'));
	}
}
