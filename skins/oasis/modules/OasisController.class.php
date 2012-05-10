<?php

class OasisController extends WikiaController {

	private static $extraBodyClasses = array();

	private $printStyles;

	/**
	 * Add extra CSS classes to <body> tag
	 * @author: Inez Korczyński
	 */
	public static function addBodyClass($className) {
		self::$extraBodyClasses[] = $className;
	}
	
	public function init() {
		$skinVars = $this->app->getSkinTemplateObj()->data;
		$this->pagetitle = $skinVars['pagetitle'];
		$this->displaytitle = $skinVars['displaytitle'];
		$this->mimetype = $skinVars['mimetype'];
		$this->charset = $skinVars['charset'];
		$this->dir = $skinVars['dir'];
		$this->lang = $skinVars['lang'];
		$this->pageclass = $skinVars['pageclass'];
		$this->pagecss = $skinVars['pagecss'];
		$this->skinnameclass = $skinVars['skinnameclass'];
		$this->bottomscripts = $skinVars['bottomscripts'];
		// initialize variables
		$this->comScore = null;
		$this->quantServe = null;
	}
	

	public function executeIndex($params) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgCityId, $wgEnableAdminDashboardExt, $wgEnableWikiaHubsExt;

		// TODO: move to WikiaHubs extension - this code should use a hook
		if(!empty($wgEnableWikiaHubsExt)) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaHubs/css/WikiaHubs.scss'));
			$wgOut->addScriptFile($this->wg->ExtensionsPath . '/wikia/WikiaHubs/js/WikiaHubs.js');
		}

		$this->showAllowRobotsMetaTag = !$this->wg->DevelEnvironment;

		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		// TODO: move to CreateNewWiki extension - this code should use a hook
		$wikiWelcome = $wgRequest->getVal('wiki-welcome');
		if(!empty($wikiWelcome)) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/CreateNewWiki/css/WikiWelcome.scss'));
			$wgOut->addScript('<script src="'.$this->wg->ExtensionsPath.'/wikia/CreateNewWiki/js/WikiWelcome.js"></script>');
		}

		$renderContentModuleOnly = false;
		if (!empty($this->wg->EnableRenderContentModuleOnlyExt)) {
			if(renderContentModuleOnly::isRenderContentModuleOnlyEnabled()) {
				$renderContentModuleOnly = true;
			}
		}

		if($renderContentModuleOnly) {
			$this->body = wfRenderModule('BodyContentOnly');
		} else {
			// macbre: let extensions modify content of the page (e.g. EditPageLayout)
			$this->body = !empty($params['body']) ? $params['body'] : wfRenderModule('Body');
		}

		// generate list of CSS classes for <body> tag
		$bodyClasses = array('mediawiki', $this->dir, $this->pageclass);
		$bodyClasses = array_merge($bodyClasses, self::$extraBodyClasses);
		$bodyClasses[] = $this->skinnameclass;

		if(Wikia::isMainPage()) {
			$bodyClasses[] = 'mainpage';
		}

		// add skin theme name
		$skin = $wgUser->getSkin();
		if(!empty($skin->themename)) {
			$bodyClasses[] = "oasis-{$skin->themename}";
		}

		// mark dark themes
		if (SassUtil::isThemeDark()) {
			$bodyClasses[] = 'oasis-dark-theme';
		}
		$this->bodyClasses = $bodyClasses;

    	//reset, this ensures no duplication in CSS links
		$this->printStyles = array();
		$this->csslinks = '';

		foreach ( $skin->getStyles() as $s ) {
			// Remove the non-inlined media="print" CSS from the normal array and add it to another so that it can be loaded asynchronously at the bottom of the page.
			if ( !empty( $s['url'] ) && stripos($s['tag'], 'media="print"')!== false) {
				$this->printStyles[] = $s['url'];
			} else {
				$this->csslinks .= $s['tag'];
			}
		}

		$this->headlinks = $wgOut->getHeadLinks();
		$this->headitems = $skin->getHeadItems();

		$this->pagetitle = htmlspecialchars( $this->pagetitle );
		$this->displaytitle = htmlspecialchars( $this->displaytitle );
		$this->mimetype = htmlspecialchars( $this->mimetype );
		$this->charset = htmlspecialchars( $this->charset );

		/* allow extensions to inject JS just after global JS variables - copied here from OutputPage.php */
		$globalVariablesScript = Skin::makeGlobalVariablesScript($this->app->getSkinTemplateObj()->data);
		wfRunHooks('SkinGetHeadScripts', array(&$globalVariablesScript));
		$this->globalVariablesScript = $globalVariablesScript;
		
		// printable CSS (to be added at the bottom of the page)
		// FIXME: move to renderPrintCSS() method
		$this->printableCss = $this->renderPrintCSS(); // The HTML for the CSS links (whether async or not).

		// setup loading of JS/CSS using WSL (WikiaScriptLoader)
		$this->loadJs();

		// FIXME: create separate module for stats stuff?
		// load Google Analytics code
		$this->googleAnalytics = AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);

		// onewiki GA
		$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId));

		// track page load time
		$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'pagetime', array('oasis'));

		// track browser height TODO NEF no browser height tracking code anymore, remove
		//$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'browser-height');

		// record which varnish this page was served by
		$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'varnish-stat');

		// TODO NEF not used, remove
		//$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'noads');

		// TODO NEF we dont do AB this way anymore, remove
		//$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'abtest');

		// Add important Gracenote analytics for reporting needed for licensing on LyricWiki.
		if (43339 == $wgCityId){
			$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'lyrics');
		}

		// macbre: RT #25697 - hide Comscore & QuantServe tags on edit pages

		if(!in_array($wgRequest->getVal('action'), array('edit', 'submit'))) {
			$this->comScore = AnalyticsEngine::track('Comscore', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->quantServe = AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);
		}

		$this->mainsassfile = 'skins/oasis/css/oasis.scss';

		if (!empty($wgEnableAdminDashboardExt) && AdminDashboardLogic::displayAdminDashboard($this->app, $wgTitle)) {
			$this->displayAdminDashboard = true;
		} else {
			$this->displayAdminDashboard = false;
		}
	} // end executeIndex()

	/**
	 * @author Sean Colombo. Macbre
	 */
	private function renderPrintCSS() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		// add SASS for printable version of Oasis
		$this->printStyles[] = AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/print.scss');

		// render the output
		$ret = '';

		if ($wgRequest->getVal('printable')) {
			// render <link> tags for print preview
			foreach ( $this->printStyles as $url ) {
				$ret .= "<link rel=\"stylesheet\" href=\"{$url}\" />\n";
			}
		} else {
			// async download
			$cssReferences = Wikia::json_encode( $this->printStyles );
			$ret = Html::inlineScript("setTimeout(function(){wsl.loadCSS({$cssReferences}, 'print')}, 100)");
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

    private function rewriteJSlinks( $link ) {
		global $IP;
		wfProfileIn( __METHOD__ );

		$parts = explode( "?cb=", $link ); // look for http://*/filename.js?cb=XXX

		if ( count( $parts ) == 2 ) {
			//$hash = md5(file_get_contents($IP . '/' . $parts[0]));
			$hash = filemtime( $IP . '/' . $parts[0]);
			$link = $parts[0].'?cb='.$hash;
		} else {
			$ret = preg_replace_callback(
				'#(/__cb)([0-9]+)/([^ ]*)#', // look for http://*/__cbXXXXX/* type of URLs
				function ( $matches ) {
					global $IP, $wgStyleVersion;
					$filename = explode('?',$matches[3]); // some filenames may additionaly end with ?$wgStyleVersion
					//$hash = hexdec(substr(md5(file_get_contents( $IP . '/' . $filename[0])),0,6));
					$hash = filemtime( $IP . '/' . $filename[0] );
					return str_replace( $wgStyleVersion, $hash, $matches[0]);
				},
				$link
			);

			if ( $ret ) {
				$link = $ret;
			}
		}
		//error_log( $link );

		wfProfileOut( __METHOD__ );
		return $link;
	}

	// TODO: implement as a separate module?
	private function loadJs() {
		global $wgTitle, $wgOut, $wgJsMimeType, $wgUser, $wgSpeedBox, $wgDevelEnvironment;
		wfProfileIn(__METHOD__);

		// decide where JS should be placed (only add JS at the top for special and edit pages)
		if (ArticleAdLogic::isSearch()) {
			$this->jsAtBottom = true;	// Liftium.js (part of AssetsManager) 
							// must be loaded after LiftiumOptions
							// variable is set in page source			
		}
		elseif ($wgTitle->getNamespace() == NS_SPECIAL || BodyController::isEditPage()) {
			$this->jsAtBottom = false;
		}
		else {
			$this->jsAtBottom = true;
		}

		// load WikiaScriptLoader
		$this->wikiaScriptLoader = '';
		$wslFiles = AssetsManager::getInstance()->getGroupCommonURL( 'wsl' );

		foreach($wslFiles as $wslFile) {
			if( $wgSpeedBox && $wgDevelEnvironment ) {
				$wslFile = $this->rewriteJSlinks( $wslFile );
			}

			$this->wikiaScriptLoader .= "<script type=\"$wgJsMimeType\" src=\"$wslFile\"></script>";
		}

		// BugId:20929 - tell (or trick) varnish to store the latest revisions of Wikia.js and Common.js.
		$oTitleWikiaJs	= Title::newFromText( 'Wikia.js',  NS_MEDIAWIKI );
		$oTitleCommonJs	= Title::newFromText( 'Common.js', NS_MEDIAWIKI );
		$iMaxRev = max( (int) $oTitleWikiaJs->getLatestRevID(), (int) $oTitleCommonJs->getLatestRevID() );
		unset( $oTitleWikiaJs, $oTitleCommonJs );

		// Load SiteJS / common.js separately, after all other js files (moved here from oasis_shared_js)
		$siteJS = Title::newFromText('-')->getFullURL('action=raw&smaxage=86400&maxrev=' . $iMaxRev . '&gen=js&useskin=oasis');
		$jsReferences[] = ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) ? $this->rewriteJSlinks( $siteJS ) : $siteJS;

		// move JS files added to OutputPage to list of files to be loaded using WSL
		$scripts = $wgUser->getSkin()->getScripts();

		foreach ( $scripts as $s ) {
			//add inline scripts to jsFiles and move non-inline to WSL queue
			if ( !empty( $s['url'] ) ) {
				$jsReferences[] = ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) ? $this->rewriteJSlinks( $s['url'] ) : $s['url'];
			} else {
				$this->jsFiles .= $s['tag'];
			}
		}

		// add user JS (if User:XXX/wikia.js page exists)
		// copied from Skin::getHeadScripts
		if($wgUser->isLoggedIn()){
			wfProfileIn(__METHOD__ . '::checkForEmptyUserJS');

			$userJS = $wgUser->getUserPage()->getPrefixedText() . '/wikia.js';
			$userJStitle = Title::newFromText( $userJS );

			if ( $userJStitle->exists() ) {
				global $wgSquidMaxage;

				$siteargs = array(
					'action' => 'raw',
					'maxage' => $wgSquidMaxage,
				);

				$userJS = Skin::makeUrl( $userJS, wfArrayToCGI( $siteargs ) );
				$jsReferences[] = ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) ? $this->rewriteJSlinks( $userJS ) : $userJS;
			}

			wfProfileOut(__METHOD__ . '::checkForEmptyUserJS');
		}

        $assets = array();
        $assets['oasis_shared_js'] = AssetsManager::getInstance()->getGroupCommonURL('oasis_shared_js');
        $assets['oasis_nojquery_shared_js'] = AssetsManager::getInstance()->getGroupCommonURL('oasis_nojquery_shared_js');
        $assets['oasis_noads_extensions_js'] = AssetsManager::getInstance()->getGroupCommonURL('oasis_noads_extensions_js');
        $assets['oasis_extensions_js']= AssetsManager::getInstance()->getGroupCommonURL('oasis_extensions_js');
        $assets['oasis_user_anon'] = AssetsManager::getInstance()->getGroupLocalURL($wgUser->isLoggedIn() ? 'oasis_user_js' : 'oasis_anon_js');
        $assets['references'] = $jsReferences;

        if ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) {
            for($j = 0; $j < count($assets['oasis_shared_js']); $j++) {
                $assets['oasis_shared_js'][$j]= $this->rewriteJSlinks( $assets['oasis_shared_js'][$j] );
            }
            for($j = 0; $j < count($assets['oasis_nojquery_shared_js']); $j++) {
                $assets['oasis_nojquery_shared_js'][$j]= $this->rewriteJSlinks( $assets['oasis_nojquery_shared_js'][$j] );
            }
            for($j = 0; $j < count($assets['oasis_noads_extensions_js']); $j++) {
                $assets['oasis_noads_extensions_js'][$j]= $this->rewriteJSlinks( $assets['oasis_noads_extensions_js'][$j] );
            }
            for($j = 0; $j < count($assets['oasis_extensions_js']); $j++) {
                $assets['oasis_extensions_js'][$j]= $this->rewriteJSlinks( $assets['oasis_extensions_js'][$j] );
            }
            for($j = 0; $j < count($assets['oasis_user_anon']); $j++) {
                $assets['oasis_user_anon'][$j]= $this->rewriteJSlinks( $assets['oasis_user_anon'][$j] );
            }
        }

		// generate code to load JS files
		$assets = Wikia::json_encode($assets);
		$jsLoader = "<script type=\"text/javascript\">/*<![CDATA[*/
		var wsl_assets = {$assets};
		/* A+B */ var toload = wsl_assets.oasis_shared_js.concat(wsl_assets.oasis_extensions_js, wsl_assets.oasis_user_anon, wsl_assets.references);
		/* C */ // var toload = wsl_assets.oasis_nojquery_shared_js.concat(wsl_assets.oasis_noads_extensions_js, wsl_assets.oasis_user_anon, wsl_assets.references);
		(function(){ wsl.loadScript(toload); })();
		/*]]>*/</script>";

		// use loader script instead of separate JS files
		$this->jsFiles = $jsLoader . $this->jsFiles;

        //$jquery_ads = AssetsManager::getInstance()->getGroupCommonURL('oasis_jquery_ads_js');
        $jquery_ads = array();
        if ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) {
            for($j = 0; $j < count($jquery_ads); $j++) {
                $jquery_ads[$j]= $this->rewriteJSlinks( $jquery_ads[$j] );
            }
        }
        $jquery_ads = Wikia::json_encode($jquery_ads);
        $this->adsABtesting = "<script type=\"text/javascript\">/*<![CDATA[*/ (function(){ /* C */ wsl.loadScript({$jquery_ads}); })(); /*]]>*/</script>";

		wfProfileOut(__METHOD__);
	}

}
