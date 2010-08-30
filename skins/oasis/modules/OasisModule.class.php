<?php

class OasisModule extends Module {

	// skin vars
	var $body;
	var $body_ondblclick;
	var $displaytitle;
	var $globalVariablesScript;
	var $pagetitle;
	var $reporttime;

	var $csslinks;
	var $headlinks;
	var $headscripts;
	var $printableCss;

	var $mimetype;
	var $charset;

	var $analytics;
	var $bodyClasses;
	var $dir;
	var $pageclass;
	var $skinnameclass;

	static $moduleClasses;

	/**
	 * Add extra CSS classes to <body> tag
	 */
	public static function addBodyClass($class) {
		self::$moduleClasses .= " $class";
	}

	public function executeIndex() {
		global $wgOut, $wgUser;

		$this->body = wfRenderModule('Body');

		// generate list of CSS classes for <body> tag
		$this->bodyClasses = "mediawiki {$this->dir} {$this->pageclass}" . self::$moduleClasses . " {$this->skinnameclass}";
		if (Wikia::isMainPage()) {
			$this->bodyClasses .= ' mainpage';
		}

		// add skin theme name
		$skin = $wgUser->getSkin();
		if ($skin->themename != '') {
			$this->bodyClasses .= " oasis-{$skin->themename}";
		}

		// add site JS
		// copied from Skin::getHeadScripts
		global $wgUseSiteJs, $wgJsMimeType;
		if (!empty($wgUseSiteJs)) {
			$jsCache = $wgUser->isLoggedIn() ? '&smaxage=0' : '';
			$wgOut->addScript("<script type=\"$wgJsMimeType\" src=\"".
					htmlspecialchars(Skin::makeUrl('-',
							"action=raw$jsCache&gen=js&useskin=" .
							urlencode( $skin->getSkinName() ) ) ) .
					"\"><!-- site js --></script>");
		}

		// We re-process the wgOut scripts and links here so modules can add to the arrays inside their execute method
		$this->headscripts = $wgOut->getScript();
		$this->csslinks = $wgOut->buildCssLinks();
		$this->headlinks = $wgOut->getHeadLinks();

		$this->pagetitle = htmlspecialchars( $this->pagetitle );
		$this->displaytitle = htmlspecialchars( $this->displaytitle );
		$this->mimetype = htmlspecialchars( $this->mimetype );
		$this->charset = htmlspecialchars( $this->charset );

		$this->globalVariablesScript = Skin::makeGlobalVariablesScript(Module::getSkinTemplateObj()->data);

		// detect if we're in print preview mode (printable=true)
		$media = $wgOut->transformCssMedia('print');

		// printable CSS (to be added at the bottom of the page)
		$this->printableCss = Xml::element('link', array(
			'href' => wfGetSassUrl('skins/oasis/css/print.scss'),
			'media' => $media,
			'rel' => 'stylesheet',
			'type' => 'text/css',
		));

		// load Google Analytics code
		$this->analytics = AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);

		// track page load time
		$this->analytics .= AnalyticsEngine::track('GA_Urchin', 'pagetime', array('oasis'));
	}
}
