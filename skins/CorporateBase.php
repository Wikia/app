<?php
/**
 * See docs/skin.txt
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * @todo document
 * @ingroup Skins
 */
class SkinCorporateBase extends SkinTemplate {
	
	function initPage( OutputPage $out ) {
		global $wgHooks;
		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = array(&$this, 'prepareData');
		parent::initPage( $out );
	}
	
	function outputPage( OutputPage $out ) {
		global $wgTitle, $wgUser, $wgContLang;
		global $wgScript, $wgContLanguageCode;
		global $wgJsMimeType, $wgOutputEncoding, $wgRequest;
		global $wgUseTrackbacks, $wgUseSiteJs;

		$oldid = $wgRequest->getVal( 'oldid' );
		$diff = $wgRequest->getVal( 'diff' );
		$action = $wgRequest->getVal( 'action', 'view' );
		
		$this->initPage( $out );

		$this->setMembers();
		$tpl = $this->setupTemplate( $this->template, 'skins' );

		#if ( $wgUseDatabaseMessages ) { // uncomment this to fall back to GetText
		$tpl->setTranslator(new MediaWiki_I18N());
		#}
		wfProfileOut( __METHOD__."-init" );

		wfProfileIn( __METHOD__."-stuff" );
		$this->thispage = $this->mTitle->getPrefixedDbKey();
		$this->thisurl = $this->mTitle->getPrefixedURL();
		$query = $wgRequest->getValues();
		unset( $query['title'] );
		unset( $query['returnto'] );
		unset( $query['returntoquery'] );
		
		$this->thisquery = wfUrlencode( wfArrayToCGI( $query ) );
		$this->loggedin = $wgUser->isLoggedIn();
		$this->username = $wgUser->getName();
		$this->iscontent = ($this->mTitle->getNamespace() != NS_SPECIAL );
		$this->iseditable = ($this->iscontent and !($action == 'edit' or $action == 'submit'));
		
		/* Wikia change begin - @author: Marooned */
		/* Pass parameters to skin, see: Login friction project */
		$tpl->set( 'thisurl', $this->thisurl );
		$tpl->set( 'thisquery', $this->thisquery );

		if ( $wgUser->isLoggedIn() || $this->showIPinHeader() ) {
			$this->userpageUrlDetails = self::makeUrlDetails( $this->userpage );
		} else {
			# This won't be used in the standard skins, but we define it to preserve the interface
			# To save time, we check for existence
			$this->userpageUrlDetails = self::makeKnownUrlDetails( $this->userpage );
		}
		
		$this->userjs = $this->userjsprev = false;
		$this->setupUserCss( $out );
		$this->setupUserJs( $out->isUserJsAllowed() );
		$this->titletxt = $this->mTitle->getPrefixedText();
		wfProfileOut( __METHOD__."-stuff" );

		wfProfileIn( __METHOD__."-stuff2" );
		$tpl->set( 'title', $out->getPageTitle() );  
		wfProfileIn( "parsePageTitle" );
		$tpl->set( 'pagetitle', $out->getHTMLTitle() );

		# quick hack for rt#15730; if you ever feel temptation to add 'elseif' ***CREATE A PROPER HOOK***
		if (NS_CATEGORY == $this->mTitle->getNamespace()) $tpl->set( 'pagetitle', preg_replace("/^{$this->mTitle->getNsText()}:/", '', $out->getHTMLTitle()));

		wfProfileOut( "parsePageTitle" );
		$tpl->set( 'displaytitle', $out->mPageLinkTitle );
		$tpl->set( 'pageclass', $this->getPageClasses( $this->mTitle ) );
		
		$tpl->set( 'skinnameclass', ( "skin-" . Sanitizer::escapeClass( $this->getSkinName ( ) ) ) );
	
		if ($wgUseTrackbacks && $out->isArticleRelated()) {  
			$tpl->set( 'trackbackhtml', $wgTitle->trackbackRDF() );
		} else {
			$tpl->set( 'trackbackhtml', null );
		} 
		
		$tpl->setRef( 'jsmimetype', $wgJsMimeType );  
		$tpl->setRef( 'charset', $wgOutputEncoding );  
		$tpl->set( 'headlinks', $out->getHeadLinks() );  
		$tpl->set( 'headscripts', $out->getScript() ); 
		$tpl->set( 'csslinks', $out->buildCssLinks() );  
		$tpl->setRef( 'wgScript', $wgScript );
		$tpl->setRef( 'skinname', $this->skinname ); 
		$tpl->setRef( 'loggedin', $this->loggedin );
		
		$tpl->set('notspecialpage', $this->mTitle->getNamespace() != NS_SPECIAL);

		$tpl->setRef( "lang", $wgContLanguageCode ); 
		$tpl->set( 'dir', $wgContLang->isRTL() ? "rtl" : "ltr" );
		$tpl->set( 'username', $wgUser->isAnon() ? NULL : $this->username ); 
		$tpl->set( 'pagecss', $this->setupPageCss() );  
		$tpl->setRef( 'usercss', $this->usercss);  
		$tpl->setRef( 'userjs', $this->userjs); 
		$tpl->setRef( 'userjsprev', $this->userjsprev); 
		if( $wgUseSiteJs ) {  
			$jsCache = $this->loggedin ? '&smaxage=0' : '';
			$skinName = ($this->getSkinName() == 'awesome') ? 'monaco' : $this->getSkinName(); // macbre: temp fix
			$tpl->set( 'jsvarurl',
				self::makeUrl('-',
					"action=raw$jsCache&gen=js&useskin=" .
						urlencode( $skinName ) ) );
		} else {
			$tpl->set('jsvarurl', false);
		}
		
		$printfooter = "<div class=\"printfooter\">\n" . $this->printSource() . "</div>\n";
		$out->mBodytext .= $printfooter . $this->generateDebugHTML();
		$tpl->setRef( 'bodytext', $out->mBodytext );
		
		$newtalks = $wgUser->getNewMessageLinks();
		
		wfProfileIn( __METHOD__."-stuff3" );
		$tpl->setRef( 'skin', $this );
			
		$tpl->set('personal_urls', $this->buildPersonalUrls()); 
		$content_actions = $this->buildContentActionUrls();
		$tpl->setRef('content_actions', $content_actions);

		// XXX: attach this from javascript, same with section editing
		if($this->iseditable &&	$wgUser->getOption("editondblclick"))
		{
			$encEditUrl = Xml::escapeJsString( $this->mTitle->getLocalUrl( $this->editUrlOptions() ) );
			$tpl->set('body_ondblclick', 'document.location = "' . $encEditUrl . '";');
		} else {
			$tpl->set('body_ondblclick', false);
		}

		$tpl->set( 'body_onload', false );
			
		$tpl->set( 'reporttime', wfReportTime() );
		
		// original version by hansm
		if( !wfRunHooks( 'SkinTemplateOutputPageBeforeExec', array( &$this, &$tpl ) ) ) {
			wfDebug( __METHOD__ . ": Hook SkinTemplateOutputPageBeforeExec broke outputPage execution!\n" );
		}

		// allow extensions adding stuff after the page content.
		// See Skin::afterContentHook() for further documentation.
		$tpl->set ('dataAfterContent', $this->afterContentHook());
		// execute template
		wfProfileIn( __METHOD__."-execute" );
		$res = $tpl->execute();
		wfProfileOut( __METHOD__."-execute" );
		// result may be an error
		$this->printOrError( $res );
		wfProfileOut( __METHOD__ );
	}
	
	public function buildPersonalUrls() {
		global $wgUser, $wgTitle;

		$data = array();
		
		if(!$wgUser->isLoggedIn()) {
			$returnto = "returnto={$this->thisurl}";
			if( $this->thisquery != '' )
				$returnto .= "&returntoquery={$this->thisquery}";

			$signUpHref = Skin::makeSpecialUrl( 'Signup', $returnto );
			$data['login'] = array(
				'text' => wfMsg('login'),
				'href' => $signUpHref
				);

			$data['register'] = array(
				'text' => wfMsg('nologinlink'),
				'href' => $signUpHref
				);
		}
		$data['search'] = array(
			'href' => Skin::makeSpecialUrl('Search')
		);

		$data['createwiki'] = array(
			'href' => Skin::makeSpecialUrl('CreateWiki'),
			'text' => wfMsg('corporatepage-create-button')
		);
						
		return array_merge(parent::buildPersonalUrls(),$data);
	}
	
	public function prepareData($self,$tpl){
		global $wgUser, $wgRequest, $wgTitle;
		$tpl->set('footer_middlecolumn', CorporatePageHelper::parseMsgImg('corporatepage-footer-middlecolumn'));
		$tpl->set('footer_bottom', CorporatePageHelper::parseMsg('corporatepage-footer-bottom'));
		$tpl->set('footer_rightcolumn', CorporatePageHelper::parseMsg('corporatepage-footer-rightcolumn'));
		$tpl->set('footer_bottom', CorporatePageHelper::parseMsg('corporatepage-footer-bottom'));
		$tpl->set('footer-leftcolumn', CorporatePageHelper::parseMsg('corporatepage-footer-leftcolumn'));
		$tpl->set('sidebar', CorporatePageHelper::parseMsg('corporatepage-sidebar',true));
		/**
	 	* Generic <body> element class attribute values for all pages.
	 	*/
		$tpl->set('body_class_attribute', 'mediawiki '. $tpl->textret('dir').' '. $tpl->textret('pageclass').' '. $tpl->textret('skinnameclass').(( $wgUser->isLoggedIn() ) ? ' loggedin' : ' loggedout'));
		
		$StaticChute = new StaticChute('js');
		$StaticChute->useLocalChuteUrl();		
		if( NS_SPECIAL == $wgTitle->getNamespace() ) {
			$tpl->set('static_chute_js',$StaticChute->getChuteHtmlForPackage('corporate_specialpage_js'));
		} else {
			$tpl->set('static_chute_js',$StaticChute->getChuteHtmlForPackage('corporate_page_js'));
		}

		$StaticChute = new StaticChute('css');
		$StaticChute->useLocalChuteUrl();
		$tpl->set('static_chute_css',$StaticChute->getChuteHtmlForPackage('corporate_page_css'));
		
		$tpl->set('is_anon', $wgUser->isAnon());
		$tpl->set('is_manager', $wgUser->isAllowed( 'corporatepagemanager' ));
		
		$searchValue = $wgRequest->getVal( 'search', '' );
		$tpl->set('search_value', ( !empty( $searchValue ) ) ? $searchValue : wfMsg('corporatepage-find-a-wiki'));
		return true;
	}
	
	public function setupSkinUserCss() {
		
	}
}

require_once dirname(__FILE__) . "/../extensions/wikia/AnalyticsEngine/AnalyticsEngine.php";

class CorporateBaseTemplate extends QuickTemplate {
	/**
	 * Prints the HTML for the <head></head> (inclusive) section.
	 */
	protected function htmlHead(){
?>
	<head>
		<meta charset="<?php $this->text('charset') ?>">
		<!--headlinks-->
		<?php $this->html('headlinks') ?>
		<!--title-->
		<title><?php $this->text('pagetitle') ?></title>
		<!--csslinks-->
		<?php $this->html('static_chute_css') ?>
		<?php $this->html('csslinks') ?>
		<!--[if lt IE 8]>
		<link rel="stylesheet" href="/skins/corporate/css/ie.css" type="text/css" media="screen">
		<![endif]-->

		<!--global variables script-->
		<?php print Skin::makeGlobalVariablesScript( $this->data ); ?>

		<!-- headscripts -->
		<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
		<![endif]-->
		<?php $this->html('wikia_headscripts'); ?>
		<?php $this->html('static_chute_js') ?>
		<?php $this->html('headscripts') ?>

		<?php	if($this->data['jsvarurl']) { ?>
		<!-- MediaWiki site js -->
		<script src="<?php $this->text('jsvarurl') ?>"></script>
<?php	} ?>
<?php	if($this->data['pagecss']) { ?>
		<!-- page css -->
		<style><?php $this->html('pagecss') ?></style>
<?php	}
		if($this->data['usercss']) { ?>
		<!-- user css -->
		<style><?php $this->html('usercss') ?></style>
<?php	}
		if($this->data['userjs']) { ?>
		<!-- user js -->
		<script src="<?php $this->text('userjs' ) ?>"></script>
<?php	}
		if($this->data['userjsprev']) { ?>
		<!-- user js prev -->
		<script><?php $this->html('userjsprev') ?></script>
<?php	}
		if($this->data['trackbackhtml']) print $this->data['trackbackhtml']; ?>
	</head>
<?php
	} // END: function htmlHead()
	/**
	 * The HTML for the Wikia Global header.
	 */
	protected function htmlGlobalHeader(){
		global $wgStylePath, $wgLangToCentralMap, $wgContLang;
		$central_url = !empty($wgLangToCentralMap[$wgContLang->getCode()]) ? $wgLangToCentralMap[$wgContLang->getCode()] : 'http://www.wikia.com/';
?>
		<?php echo $this->data['reporttime']; ?> 
		
		<header id="GlobalHeader">
			<!-- DEV NOTE: This is the white gradient strip at the top. -->
			<div class="shrinkwrap">
				<h1>
					<a href="<?php print $central_url?>" title=""><img id="wikia-logo" src="<?php echo $wgStylePath; ?>/corporate/images/logo.blue.wikia.140x35.png" alt="Wikia&reg;" width="140" height="35"></a>
				</h1>

				<div id="wikia-tools">
					<p id="wikia-account-tools">
						<?php if($this->data['is_anon']): ?>
							<a id="wikia-login-link" href="<?php echo $this->data['personal_urls']['login']['href']; ?>"><?php print wfMsg('login'); ?></a>/
							<a id="wikia-create-account-link" href="<?php echo $this->data['personal_urls']['register']['href']; ?>"><?php print wfMsg('nologinlink'); ?></a>
						<?php else: ?>
							<strong><?php echo $this->data['username']; ?></strong>
							<a href="<?php echo $this->data['personal_urls']['watchlist']['href']; ?>"><?php echo wfMsg('corporatepage-watchlist'); ?></a>
							<a id="wikia-login-link" href="<?php echo $this->data['personal_urls']['logout']['href']; ?>"><?php print wfMsg('logout'); ?></a>
						<?php endif;?>
					</p>
					<form id="wikia-search-form" name="wikia_search_form" action="<?php echo $this->data['personal_urls']['search']['href']; ?>" method="get">
						<fieldset>
							<legend><?php print wfMsg('corporatepage-find-a-wiki') ?></legend>
							<input type="text" class="SearchField<?php print (wfMsg('corporatepage-find-a-wiki') === $this->data['search_value']) ? ' placeholder' : '' ;?>" id="wikia-search" name="search" title="<?php print wfMsg("corporatepage-search-title"); ?>" value="<?php print $this->data['search_value']; ?>">
							<input type="submit" id="wikia-search-submit" name="wikia_search_submit" value="Search">
						</fieldset>
					</form>
				</div><!-- END #wikia-tools -->
			</div><!-- END .shrinkwrap -->
		</header>
		
<?php
	}

	protected function htmlGlobalNav(){
?>
		<nav id="GlobalNav">
			<div class="shrinkwrap">
				<h1 id="globalnav-headline"><?php print wfMsg('corporatepage-global-nav-headline'); ?></h1>
				<ul class="nav-top-level">
					<?php foreach ($this->data['sidebar'] as $key => $value): ?>
						<li<?php print $value['islast'] ? ' class="last"':'';?> <?php print $value['isfirst'] ? ' class="first"':'';?>>
							<a class="nav-link" href="<?php print $value['href'] ?>"><?php print $value['title'] ?></a>
							<ul class="nav-sub-level">
								<?php foreach ($value['sub'] as $key2 => $value2): ?>
									<li<?php print ($key2 == 0) ? ' class="first"':'';?> <?php print ($key2 == (count($value['sub'])-1)) ? ' class="last"':'';?> >
										<a id="nav_sub_link_<?php print $key + 1 ?>_<?php print $key2 + 1 ?>" class="nav-sub-link" href="<?php print $value2['href'] ?>">
											<?php print $value2['title'] ?>
										</a> 
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endforeach; ?>
				</ul><!-- END #GlobalNav -->
			</div>
		</nav>
<?php
	} // END: function htmlGlobalNav

	protected function htmlMainArticleContents(){
?>
			<h1 class="firstHeading"><?php print $this->data['title']?></h1>
			<?php $this->html('bodytext'); ?>
<?php
	} // END: function htmlMainArticleContents

	protected function htmlCompanyInfo(){
?>
		<section id="CompanyInfo" class="clearfix">
			<div class="shrinkwrap">
			<h1 id="company-info-headline"><?php print wfMsg('corporatepage-company-info-headline') ;?> </h1>
				<section id="wikia-international">
					<h1><?php print wfMsg('corporatepage-wikia-international') ?></h1>
					<ul>
					<?php foreach ($this->data['footer-leftcolumn'] as $key => $value): ?>
						<li id="wikia-international-<?php print $key;?>"<?php print $value['islast'] ? ' class="last"':'';?> <?php print $value['isfirst'] ? ' class="first"':'';?>>
							<a href="<?php print $value['href'] ?>"><?php print $value['title'] ?></a>
						</li>
					<?php endforeach; ?>
					</ul>
				</section>

				<section id="wikia-in-the-know">
					<h1><?php print wfMsg('corporatepage-in-the-know') ?></h1>
					<ul>
					<?php foreach($this->data['footer_middlecolumn'] as $key => $value): ?> 
						<li id="wikia-in-the-know-<?php print $key;?>">
							<a <?php echo $value['param'] == "new-window" ? " target='_blank' ":"" ?> href="<?php echo $value['href']; ?>" style="background-image:url(<?php print $value['imagename'] ?>);"><?php echo $value['title']; ?></a>
						</li>
					<?php endforeach; ?>
					</ul>
				</section>

				<section id="wikia-more-links">
					<h1><?php print wfMsg('corporatepage-more-link') ?></h1>
					<ul>
					<?php foreach ($this->data['footer_rightcolumn'] as $key => $value): ?>
						<li id="wikia-more-links-<?php print $key;?>"><a href="<?php print $value['href'] ?>"><?php print $value['title'] ?></a></li>
					<?php endforeach; ?>
					</ul>
				</section>
			</div><!-- END .shrinkwrap -->
		</section><!-- END #CompanyInfo -->
<?php
	} // END: function htmlCompanyInfo

	protected function htmlGlobalFooter(){
?>
		<!-- Begin Analytics -->
		<?php
		// Note, these were placed above the Ad calls intentionally because ad code screws with analytics
		echo AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
		echo AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine::getCachedCategory());
		global $wgCityId;
		echo AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId));
		echo AnalyticsEngine::track('GA_Urchin', 'pagetime', array('lean_monaco'));
		if (43339 == $wgCityId) echo AnalyticsEngine::track("GA_Urchin", "lyrics");
		?>
		<!-- End Analytics -->
		<footer>
			<div class="shrinkwrap">
				<p id="wikia-create-wiki">
					<?php print wfMsg('corporatepage-create-your-own-wiki') ?>
					<a href="<?php echo $this->data['personal_urls']['createwiki']['href']; ?>" class="wikia-button secondary">
						<?php echo $this->data['personal_urls']['createwiki']['text']; ?>
					</a>
				</p>

				<p id="copyright"><?php print wfMsg('corporatepage-rights',date('Y')) ?> </p>

				<ul id="SupplementalNav">
					<?php foreach ($this->data['footer_bottom'] as $key => $value): ?>
						<li <?php print $value['islast'] ? 'class="first"':'';?> <?php print $value['isfirst'] ? 'class="first"':'';?>>
							<?php if((count($this->data['footer_bottom']) - $key) <= 4 ): ?>
								<a class="last4" id="footer_bottom_<?php echo (  $key - (count($this->data['footer_bottom']) - 5)); ?>" href="<?php print $value['href'] ?>"><?php print $value['title'] ?></a>
							<?php else: ?>
								<a href="<?php print $value['href'] ?>"><?php print $value['title'] ?></a>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>

			</div><!-- END .shrinkwrap -->

		</footer>
		<div id="positioned_elements" class="reset"></div>
<?php
	} // END: function GlobalFooter
} // end of class
