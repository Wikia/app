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
			case 'no':
				// don't change the language
				break;

			default:
				// fallback to English
				$langCode = 'en';
		}

		// email link
		$emailAddress = 'alessandra@wikia-inc.com';
		$emailTitle = $this->app->wf->msg('landingpagesmurfs-enternow-email-title');
		$emailLink = 'mailto:' . rawurlencode($emailAddress) . '?subject=' . rawurlencode($emailTitle);

		// render wiki link
		$wikiLink = $this->app->wf->msgExt('landingpagesmurfs-wikia-site-link', array('parseinline'));
		$wikiLink = str_replace('<a ', '<a class="smurfs-link-wiki" ', $wikiLink);

		// render HTML
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'emailLink' => $emailLink,
			'langCode' => $langCode,
			'wikiLink' => $wikiLink,
		));

		$this->app->wg->Out->addHTML($template->render('main'));
	}
}
