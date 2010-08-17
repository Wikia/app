<?php
/**
 * @author Sean Colombo
 *
 * This skin is meant to be a minimal article view of LyricWiki to make it easier
 * for mobile devices to see the lyrics content.
 *
 * It works well when used in conjunction with
 * the API since the API can do a better job of matching what a user is looking for (based on
 * title and artist) than the site's default search.  After using the API to find a match, mobile
 * apps can then send the user to the webpage, using this mobile-friendly skin.
 *
 * TODO: Add custom CSS
 * TODO: Take off unneeded pieces
 *			- Hmmm.... (a bunch more, need to figure them out)
 * TODO: Remove unneeded CSS
 * TODO: Remove unneeded JS
 * TODO: Verify that Google Analytics tracking (for licensing) is still working.
 * TODO: Add LyricWiki logo
 * TODO: Add top banner
 * TODO: Verify that Google Analytics tracking (for licensing) is still working - again.
 * TODO: Make sure GN pages still show the GN logo and link to EULA on the bottom.
 * TODO: Add custom styling for currenT test.
 *			- Color changes
 *			- Remove edit button
 * TODO: Should this just _EXTEND_ Monaco?  It would be fairly straightforward... anything that's left in this file after the deletions should still be in here.  This would have
 *			the benefits of picking up any improvements to Monaco, but it would also pick up new page-elements, etc.  Monaco is probably fairly "done" with though, so this is probably a moot point.
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

class SkinLyricsMinimal extends SkinTemplate {
	/**
	 * Overwrite few SkinTemplate methods which we don't need in lyricsminimal
	 */
	function buildSidebar() {}
	function getCopyrightIcon() {}
	function getPoweredBy() {}
	function disclaimerLink() {}
	function privacyLink() {}
	function aboutLink() {}
	function getHostedBy() {}
	function diggsLink() {}
	function deliciousLink() {}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	public function initPage(&$out) {

		wfDebugLog('lyricsminimal', '##### SkinLyricsMinimal initPage #####');

		wfProfileIn(__METHOD__);
		global $wgHooks, $wgCityId, $wgCat;

		SkinTemplate::initPage($out);

		$this->skinname  = 'lyricsminimal';
		$this->stylename = 'lyricsminimal';
		$this->template  = 'LyricsMinimalTemplate';

		// Get category information (id, name, url)
		$cats = wfGetBreadCrumb();
		$idx = count($cats)-2;
		if(isset($cats[$idx])) {
			$wgCat = $cats[$idx];
			wfDebugLog('lyricsminimal', 'There is category info');
		} else {
			$wgCat = array('id' => -1);
			wfDebugLog('lyricsminimal', 'No category info');
		}

		// Function addVariables will be called to populate all needed data to render skin
		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = array(&$this, 'addVariables');

		wfProfileOut(__METHOD__);
	}

	/**
	 * Add specific styles for this user.
	 * Don't add common/shared.css as it's kept in allinone.css
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ){

		// TODO: SWC: This might be a good place to load app-specific CSS in cases that we have that.

	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	public function addVariables(&$obj, &$tpl) {
		wfProfileIn(__METHOD__);
		global $wgDBname, $wgLang, $wgContLang, $wgMemc, $wgUser, $wgRequest, $wgTitle, $parserMemc;

		// We want to cache populated data only if user language is same with wiki language
		$cache = $wgLang->getCode() == $wgContLang->getCode();

		wfDebugLog('lyricsminimal', sprintf('Cache: %s, wgLang: %s, wgContLang %s', (int) $cache, $wgLang->getCode(), $wgContLang->getCode()));

		if($cache) {
// TODO: SWC: What is this data-old thing?  Is it just normal memcaching?
			$key = wfMemcKey('LyricsMinimalDataOld');
			$data_array = $parserMemc->get($key);
		}

		if(empty($data_array)) {
			wfDebugLog('lyricsminimal', 'There is no cached $data_array, let\'s populate');
			wfProfileIn(__METHOD__ . ' - DATA ARRAY');
			//$data_array['footerlinks'] = $this->getFooterLinks(); // NOTE: Removed for LyricsMinimal
			//$data_array['wikiafooterlinks'] = $this->getWikiaFooterLinks(); // NOTE: Removed for LyricsMinimal
			$data_array['categorylist'] = DataProvider::getCategoryList();
			$data_array['toolboxlinks'] = $this->getToolboxLinks();
			//$data_array['sidebarmenu'] = $this->getSidebarLinks(); d// this was already removed in Monaco (prior to LyricsMinimal)
			$data_array['relatedcommunities'] = $this->getRelatedCommunitiesLinks();
			//$data_array['magicfooterlinks'] = $this->getMagicFooterLinks(); // NOTE: Removed for LyricsMinimal
			wfProfileOut(__METHOD__ . ' - DATA ARRAY');
			if($cache) {
				$parserMemc->set($key, $data_array, 4 * 60 * 60 /* 4 hours */);
			}
		}

		if($wgUser->isLoggedIn()) {
			if(empty($wgUser->mMonacoData) || ($wgTitle->getNamespace() == NS_USER && $wgRequest->getText('action') == 'delete')) {

				wfDebugLog('lyricsminimal', 'mMonacoData for user is empty');

				$wgUser->mMonacoData = array();

				wfProfileIn(__METHOD__ . ' - DATA ARRAY');

				$text = $this->getTransformedArticle('User:'.$wgUser->getName().'/Monaco-toolbox', true);
				if(empty($text)) {
					$wgUser->mMonacoData['toolboxlinks'] = false;
				} else {
					$wgUser->mMonacoData['toolboxlinks'] = $this->parseToolboxLinks($text);
				}
				wfProfileOut(__METHOD__ . ' - DATA ARRAY');

				$wgUser->saveToCache();
			}

			if($wgUser->mMonacoData['toolboxlinks'] !== false && is_array($wgUser->mMonacoData['toolboxlinks'])) {
				wfDebugLog('lyricsminimal', 'There is user data for toolboxlinks');
				$data_array['toolboxlinks'] = $wgUser->mMonacoData['toolboxlinks'];
			}
		}

		# Used for page load time tracking
		$tpl->data['headlinks'] .= <<<EOS
		<script type="text/javascript">/*<![CDATA[*/
		var wgNow = new Date();
		/*]]>*/</script>
EOS;

		foreach($data_array['toolboxlinks'] as $key => $val) {
			if(isset($val['org']) && $val['org'] == 'whatlinkshere') {
				if(isset($tpl->data['nav_urls']['whatlinkshere'])) {
					$data_array['toolboxlinks'][$key]['href'] = $tpl->data['nav_urls']['whatlinkshere']['href'];
				} else {
					unset($data_array['toolboxlinks'][$key]);
				}
			}
			if(isset($val['org']) && $val['org'] == 'permalink') {
				if(isset($tpl->data['nav_urls']['permalink'])) {
					$data_array['toolboxlinks'][$key]['href'] = $tpl->data['nav_urls']['permalink']['href'];
				} else {
					unset($data_array['toolboxlinks'][$key]);
				}
			}
		}

		// This is for WidgetRelatedCommunities
		$this->relatedcommunities = $data_array['relatedcommunities'];
		unset($data_array['relatedcommunities']);

		$tpl->set('data', $data_array);

		// This is for WidgetLanguages
		$this->language_urls = $tpl->data['language_urls'];

		// JS and CSS references
		$tpl->set('references', $this->getReferencesLinks($tpl));

		// Article content links (View, Edit, Delete, Move, etc.)
		$tpl->set('articlelinks', $this->getArticleLinks($tpl));

		// User actions links
		$tpl->set('userlinks', $this->getUserLinks($tpl));

		// marged JS files
		// get the right package from StaticChute
		$StaticChute = new StaticChute('js');
		$StaticChute->useLocalChuteUrl();

		if ($wgUser->isLoggedIn()) {
			$package = 'monaco_loggedin_js';
		}
		else {
			// list of namespaces and actions on which we should load package with YUI
			$ns = array(NS_SPECIAL);
			$actions = array('edit', 'preview', 'submit');

			// add blog namespaces
			global $wgEnableBlogArticles;
			if (!empty($wgEnableBlogArticles)) {
				$ns = array_merge($ns, array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK, NS_BLOG_LISTING, NS_BLOG_LISTING_TALK));
			}

			if ( in_array($wgTitle->getNamespace(), $ns) || in_array($wgRequest->getVal('action', 'view'), $actions) ) {
				// edit mode & special/blog pages (package with YUI)
				$package = 'monaco_anon_everything_else_js';
			}
			else {
				// view mode (package without YUI)
				$package = 'monaco_anon_article_js';
			}
		}

		// load WikiaScriptLoader
		// macbre: this is minified version of /skins/monaco/js/WikiaScriptLoader.js using Google Closure
		global $wgStylePath, $wgStyleVersion;
		$tpl->set('WikiaScriptLoader', "\t\t" . '<script type="text/javascript">/*<![CDATA[*/var WikiaScriptLoader=function(){var b=navigator.userAgent.toLowerCase();this.useDOMInjection=b.indexOf("opera")!=-1||b.indexOf("firefox")!=-1;this.isIE=b.indexOf("opera")==-1&&b.indexOf("msie")!=-1;this.headNode=document.getElementsByTagName("HEAD")[0]}; WikiaScriptLoader.prototype={loadScript:function(b,c){this.useDOMInjection?this.loadScriptDOMInjection(b,c):this.loadScriptDocumentWrite(b,c)},loadScriptDOMInjection:function(b,c){var a=document.createElement("script");a.type="text/javascript";a.src=b;var d=function(){a.onloadDone=true;typeof c=="function"&&c()};a.onloadDone=false;a.onload=d;a.onreadystatechange=function(){a.readyState=="loaded"&&!a.onloadDone&&d()};this.headNode.appendChild(a)},loadScriptDocumentWrite:function(b,c){document.write(\'<script src="\'+ b+\'" type="text/javascript"><\/script>\');b=function(){typeof c=="function"&&c()};typeof c=="function"&&this.addHandler(window,"load",b)},loadScriptAjax:function(b,c){var a=this,d=this.getXHRObject();d.onreadystatechange=function(){if(d.readyState==4){var e=d.responseText;if(a.isIE)eval(e);else{var f=document.createElement("script");f.type="text/javascript";f.text=e;a.headNode.appendChild(f)}typeof c=="function"&&c()}};d.open("GET",b,true);d.send("")},loadCSS:function(b,c){var a=document.createElement("link"); a.rel="stylesheet";a.type="text/css";a.media=c||"";a.href=b;this.headNode.appendChild(a)},addHandler:function(b,c,a){if(window.addEventListener)window.addEventListener(c,a,false);else window.attachEvent&&window.attachEvent("on"+c,a)},getXHRObject:function(){var b=false;try{b=new XMLHttpRequest}catch(c){for(var a=["Msxml2.XMLHTTP.6.0","Msxml2.XMLHTTP.3.0","Msxml2.XMLHTTP","Microsoft.XMLHTTP"],d=a.length,e=0;e<d;e++){try{b=new ActiveXObject(a[e])}catch(f){continue}break}}return b}};window.wsl=new WikiaScriptLoader;/*]]>*/</script>');


		// use WikiaScriptLoader to load StaticChute in parallel with other scripts added by wgOut->addScript
		global $wgAllInOne;
		wfProfileIn(__METHOD__ . '::JSloader');

		$allinone = $wgRequest->getBool('allinone', $wgAllInOne);

		$jsReferences = array();

		if($allinone && $package == 'monaco_anon_article_js') {
			global $parserMemc, $wgStyleVersion, $wgEnableViewYUI;
			$cb = $parserMemc->get(wfMemcKey('wgMWrevId'));

			$addParam = "";
			if (!empty($wgEnableViewYUI)) {
				$addParam = "&yui=1";
			}

			global $wgDevelEnvironment;
			if(empty($wgDevelEnvironment)){
				$prefix = "__wikia_combined/";
			} else {
				global $wgWikiaCombinedPrefix;
				$prefix = $wgWikiaCombinedPrefix;
			}
			$jsReferences[] = "/{$prefix}cb={$cb}{$wgStyleVersion}&type=CoreJS";
		} else {
			$jsHtml = $StaticChute->getChuteHtmlForPackage($package);

			if ($package == "monaco_anon_article_js") {
				$jsHtml .= $StaticChute->getChuteHtmlForPackage("yui");
			}

			// get URL of StaticChute package (or a list of separated files) and use WSL to load it
			preg_match_all("/src=\"([^\"]+)/", $jsHtml, $matches, PREG_SET_ORDER);

			foreach($matches as $script) {
				$jsReferences[] = str_replace('&amp;', '&', $script[1]);
			}
		}


		// scripts from getReferencesLinks() method
		foreach($tpl->data['references']['js'] as $script) {
			if (!empty($script['url'])) {
				$url = $script['url'];
				if($allinone && $package == 'monaco_anon_article_js' && strpos($url, 'title=-') > 0) {
					continue;
				}
				$jsReferences[] = $url;
			}
		}

		// scripts from $wgOut->mScripts
		// <script type="text/javascript" src="URL"></script>
		// load them using WSL and remove from $wgOut->mScripts
		//
		// macbre: Perform only for Monaco skin! New Answers skin does not use WikiaScriptLoader
		if ((get_class($this) == 'SkinMonaco') || (get_class($this) == 'SkinAnswers')
			|| (get_class($this) == 'SkinLyricsMinimal')) {
			global $wgJsMimeType;

			$headScripts = $tpl->data['headscripts'];
			preg_match_all("#<script type=\"{$wgJsMimeType}\" src=\"([^\"]+)\"></script>#", $headScripts, $matches, PREG_SET_ORDER);
			foreach($matches as $script) {
				$jsReferences[] = str_replace('&amp;', '&', $script[1]);
				$headScripts = str_replace($script[0], '', $headScripts);
			}
			$tpl->data['headscripts'] = $headScripts;

			// generate code to load JS files
			$jsReferences = Wikia::json_encode($jsReferences);
			$jsLoader = <<<EOF

		<script type="text/javascript">/*<![CDATA[*/
			(function(){
				var jsReferences = $jsReferences;
				var len = jsReferences.length;
				for(var i=0; i<len; i++)
					wsl.loadScript(jsReferences[i]);
			})();
		/*]]>*/</script>
EOF;

			$tpl->set('JSloader', $jsLoader);
		}

		wfProfileOut(__METHOD__ . '::JSloader');

		// macbre: move media="print" CSS to bottom (RT #25638)
		global $wgOut;

		wfProfileIn(__METHOD__ . '::printCSS');

		$tmpOut = new OutputPage();
		$printStyles = array();

		// let's filter media="print" CSS out
		$tmpOut->styles = $wgOut->styles;

		foreach($tmpOut->styles as $style => $options) {
			if (isset($options['media']) && $options['media'] == 'print') {
				unset($tmpOut->styles[$style]);
				$printStyles[$style] = $options;
			}
		}

		// re-render CSS to be included in head
		$tpl->set('csslinks-urls', $tmpOut->styles);
		$tpl->set('csslinks', $tmpOut->buildCssLinks());

		// render CSS to be included at the bottom
		$tmpOut->styles = $printStyles;
		$tpl->set('csslinksbottom-urls', $printStyles);
		$tpl->set('csslinksbottom', $tmpOut->buildCssLinks());

		wfProfileOut(__METHOD__ . '::printCSS');

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function parseToolboxLinks($lines) {
		$nodes = array();
		if(is_array($lines)) {
			foreach($lines as $line) {
				$trimmed = trim($line, ' *');
				if (strlen($trimmed) == 0) { # ignore empty lines
					continue;
				}
				$item = parseItem($trimmed);

				$tracker = $item['org'];
				$tracker = preg_replace('/-url$/', '', $tracker);
				if (empty($tracker)) $tracker = $item['href'];
				$tracker = preg_replace('/[^a-z0-9.]/i', '_', $tracker);
				$item['tracker'] = $tracker;

				$nodes[] = $item;
			}
		}
		return $nodes;
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getLines($message_key) {
		global $wgCat;

		$revision = Revision::newFromTitle(Title::newFromText($message_key, NS_MEDIAWIKI));
		if(is_object($revision)) {
			if(trim($revision->getText()) != '') {
				$temp = getMessageAsArray($message_key);
				if(count($temp) > 0) {
					wfDebugLog('lyricsminimal', sprintf('Get LOCAL %s, which contains %s lines', $message_key, count($temp)));
					$lines = $temp;
				}
			}
		}

		if(empty($lines)) {
			if(isset($wgCat['id'])) {
				$temp = getMessageAsArray('shared-' . $message_key . '-' . $wgCat['id']);
				if(count($temp) > 0) {
					wfDebugLog('lyricsminimal', sprintf('Get %s, which contains %s lines', 'shared-' . $message_key . '-' . $wgCat['id'], count($temp)));
					$lines = $temp;
				}
			}
		}

		if(empty($lines)) {
			$lines = getMessageAsArray($message_key);
			wfDebugLog('lyricsminimal', sprintf('Get %s, which contains %s lines', $message_key, count($lines)));
		}

		return $lines;
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getToolboxLinks() {
		return $this->parseToolboxLinks($this->getLines('Monaco-toolbox'));
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getRelatedCommunitiesLinks() {
		$lines = $this->getLines('Monaco-related-communities');
		$nodes = array();
		if(is_array($lines) && count($lines) > 0) {
			foreach($lines as $line) {
				$depth = strrpos($line, '*');
				if($depth === 0) {
					$nodes[] = parseItem($line);
				}
			}
		}
		return $nodes;
	}

	private function getSidebarLinks() {
		return "";
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getTransformedArticle($name, $asArray = false) {
		wfProfileIn(__METHOD__);
		global $wgParser, $wgMessageCache;
		$revision = Revision::newFromTitle(Title::newFromText($name));
		if(is_object($revision)) {
			$text = $revision->getText();
			if(!empty($text)) {
				$ret = $wgParser->transformMsg($text, $wgMessageCache->getParserOptions());
				if($asArray) {
					$ret = explode("\n", $ret);
				}
				wfProfileOut(__METHOD__);
				return $ret;
			}
		}
		wfProfileOut(__METHOD__);
		return null;
	}

	/**
	 * Create arrays containing refereces to JS and CSS files used in skin
	 *
	 * @return array
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getReferencesLinks(&$tpl) {
		wfProfileIn( __METHOD__ );
		global $wgStylePath, $wgStyleVersion, $wgExtensionsPath, $wgContLang;
		$js = $css = $cssstyle = array();

		// CSS - begin

		// merged CSS - use StaticChute
		$StaticChute = new StaticChute('css');
		$StaticChute->useLocalChuteUrl();

		// RT #18765
		if(isset($this->themename)) {
			if($this->themename == 'custom') {
				// ...do nothing - CSS will be added by MW core
			} else if($this->themename == 'sapphire') {
				 // ...do nothing
			} else if($this->themename != '') {
				$StaticChute->setTheme($this->themename);
			}
		}
		else {
			// macbre: kill notice in calls to WikiaAssets
			$this->themename = 'sapphire';
		}

		$tpl->set('mergedCSS', "\n\t\t" . $StaticChute->getChuteHtmlForPackage('monaco_css') . "\n" );
		$tpl->set('mergedCSSprint', "\n\t\t" . $StaticChute->getChuteHtmlForPackage('monaco_css_print') );

		// RTL support
		if ($wgContLang->isRTL()) {
			$css[] = array('url' => $wgStylePath.'/monaco/rtl.css?'.$wgStyleVersion);
		}
		
		// NOTE: Added custom LyricsMinimal CSS to override existing stuff in Monaco.
		$css[] = array('url' => $wgStylePath.'/lyricsminimal/article.css?'.$wgStyleVersion);

		// CSS - end

		// CSS style - begin
		if($tpl->data['pagecss']) {
			$cssstyle[] = array('content' => $tpl->data['pagecss']);
		}
		if($tpl->data['usercss']) {
			$cssstyle[] = array('content' => $tpl->data['usercss']);
		}
		// CSS style - end

		// JS - begin
		if($tpl->data['jsvarurl']) {
			wfProfileIn(__METHOD__ . '::siteJS');

			// macbre: check for empty merged JS file - don't use hardcoded skin name (RT #48040)
			$skinName = ucfirst($this->skinname);

			$s = '';
			$s .= !isMsgEmpty('Common.js') ? wfMsgForContent('Common.js') : '';
			$s .= !isMsgEmpty("{$skinName}.js") ? wfMsgForContent("{$skinName}.js") : '';

			// eliminate multi-line comments in '/* ... */' form, at start of string
			// taken from includes/api/ApiFormatJson_json.php
			$s = trim(preg_replace('#^\s*/\*(.+)\*/#Us', '', $s));

			if ($s != '') {
				$js[] = array('url' => $tpl->data['jsvarurl'], 'mime' => 'text/javascript');
			}

			wfProfileOut(__METHOD__ . '::siteJS');
		}
		if($tpl->data['userjs']) {
			wfProfileIn(__METHOD__ . '::userJS');

			// macbre: check for empty User:foo/skin.js - don't use hardcoded skin name (RT #48040)
			$userJStitle = Title::newFromText("{$this->userpage}/{$this->skinname}.js");

			if ($userJStitle->exists()) {
				$rev = Revision::newFromTitle($userJStitle, $userJStitle->getLatestRevID());
				if (!empty($rev) && $rev->getText() != '') {
					$js[] = array('url' => $tpl->data['userjs'], 'mime' => 'text/javascript');
				}
			}

			wfProfileOut(__METHOD__ . '::userJS');
		}
		if($tpl->data['userjsprev']) {
			$js[] = array('content' => $tpl->data['userjsprev'], 'mime' => 'text/javascript');
		}
		// JS - end

		wfProfileOut( __METHOD__ );
		return array('js' => $js, 'css' => $css, 'cssstyle' => $cssstyle);
	}

	/**
	 * Create arrays containing articles links (separated arrays for left and right part)
	 * Based on data['content_actions']
	 *
	 * @return array
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getArticleLinks($tpl) {
		wfProfileIn( __METHOD__ );
		$links = array();

		// rarely ever happens, but it does
		if ( empty( $tpl->data['content_actions'] ) ) {
			return $links;
		}

		# @todo: might actually be useful to move this to a global var and handle this in extension files --TOR
		$force_right = array( 'userprofile', 'talk', 'TheoryTab' );
		foreach($tpl->data['content_actions'] as $key => $val) {
			/* Fix icons */
			if($key == 'unprotect') {
				//unprotect uses the same icon as protect
				$val['icon'] = 'protect';
			} else if ($key == 'undelete') {
				//undelete uses the same icon as delelte
				$val['icon'] = 'delete';
			} else if ($key == 'purge') {
				$val['icon'] = 'refresh';
			} else if ($key == 'addsection') {
				$val['icon'] = 'talk';
			}

			if($key == 'report-problem') {
				// Do nothing
			} else if( strpos($key, 'nstab-') === 0 || in_array($key, $force_right) ) {
				$links['right'][$key] = $val;
			} else {
				$links['left'][$key] = $val;
			}
		}
		wfProfileOut( __METHOD__ );
		return $links;
	}

	/**
	 * This is helper function for  and it's responsible for support special tags like #TOPVOTED
	 *
	 * @return array
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function addExtraItemsToNavigationMenu(&$node, &$nodes) {
		wfProfileIn( __METHOD__ );

		// Don't actually use this in this skin.  TODO: Can we remove this?

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Generate links for user menu - depends on if user is logged in or not
	 *
	 * @return array
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getUserLinks($tpl) {
		wfProfileIn( __METHOD__ );
		global $wgUser, $wgTitle;

		$data = array();

		if(!$wgUser->isLoggedIn()) {
			$returnto = "returnto={$this->thisurl}";
			if( $this->thisquery != '' )
				$returnto .= "&returntoquery={$this->thisquery}";

			$signUpHref = Skin::makeSpecialUrl( 'Signup', $returnto );
			$data['login'] = array(
				'text' => wfMsg('login'),
				'href' => $signUpHref . "&type=login"
				);

			$data['register'] = array(
				'text' => wfMsg('nologinlink'),
				'href' => $signUpHref . "&type=signup"
				);

		} else {

			$data['userpage'] = array(
				'text' => $wgUser->getName(),
				'href' => $tpl->data['personal_urls']['userpage']['href']
				);

			$data['mytalk'] = array(
				'text' => $tpl->data['personal_urls']['mytalk']['text'],
				'href' => $tpl->data['personal_urls']['mytalk']['href']
				);

			$data['watchlist'] = array(
				/*'text' => $tpl->data['personal_urls']['watchlist']['text'],*/
				'text' => wfMsg('prefs-watchlist'),
				'href' => $tpl->data['personal_urls']['watchlist']['href']
				);

			// In some cases, logout will be removed explicitly (such as when it is replaced by fblogout).
			if(isset($tpl->data['personal_urls']['logout'])){
				$data['logout'] = array(
					'text' => $tpl->data['personal_urls']['logout']['text'],
					'href' => $tpl->data['personal_urls']['logout']['href']
				);
			}


			$data['more']['userpage'] = array(
				'text' => wfMsg('mypage'),
				'href' => $tpl->data['personal_urls']['userpage']['href']
				);

			if(isset($tpl->data['personal_urls']['userprofile'])) {
				$data['more']['userprofile'] = array(
					'text' => $tpl->data['personal_urls']['userprofile']['text'],
					'href' => $tpl->data['personal_urls']['userprofile']['href']
					);
			}

			$data['more']['mycontris'] = array(
				'text' => wfMsg('mycontris'),
				'href' => $tpl->data['personal_urls']['mycontris']['href']
				);

			$data['more']['widgets'] = array(
				'text' => wfMsg('manage_widgets'),
				'href' => '#'
				);

			$data['more']['preferences'] = array(
				'text' => $tpl->data['personal_urls']['preferences']['text'],
				'href' => $tpl->data['personal_urls']['preferences']['href']
				);
		}

		// This function ignores anything from PersonalUrls hook which it doesn't expect.  This
		// loops lets it expect anything starting with "fb*" (because we need that for facebook connect).
		// Perhaps we should have some system to let PersonalUrls hook work again on its own?
		// - Sean Colombo
		
		foreach($tpl->data['personal_urls'] as $urlName => $urlData){
			if(strpos($urlName, "fb") === 0){
				$data[$urlName] = $urlData;
			}
		}

		wfProfileOut( __METHOD__ );
		return $data;
	}
} // end SkinLyricsMinimal

$wgAdCalled = array();

require_once dirname(__FILE__) . "/../extensions/wikia/AnalyticsEngine/AnalyticsEngine.php";
require_once dirname(__FILE__) . "/../extensions/wikia/AdsenseForSearch/AdsenseForSearch.php";


class LyricsMinimalTemplate extends QuickTemplate {

	private function printMenu($id, $last_count='', $level=0) {
		global $wgUploadPath, $wgArticlePath, $wgCityId;
		$menu_output = "";
		$script_output = "";
		$count = 1;

		$fixed_art_path = str_replace ('$1', "", $wgArticlePath);

		$output = '';
		if(isset($this->navmenu[$id]['children'])) {
			$script_output .= '<script type="text/javascript">/*<![CDATA[*/';
			if ($level) {
				$menu_output .= '<div class="sub-menu widget" id="sub-menu' . $last_count . '" style="display:none" >';
				$script_output .= 'submenu_array["sub-menu' . $last_count . '"] = "' . $last_count . '";';
				$script_output .= '$("navigation_widget").onmouseout = clearMenu;';
				$script_output .= '$("sub-menu' . $last_count . '").onmouseout = clearMenu;if($("sub-menu' . $last_count . '").captureEvents) $("sub-menu' . $last_count .'").captureEvents(Event.MOUSEOUT);';
			}
			$extraAttributes = ' rel="nofollow"';
			foreach($this->navmenu[$id]['children'] as $child) {
				//$mouseover = ' onmouseover="' . ($level ? 'sub_' : '') . 'menuItemAction(\'' .
				($level ? $last_count . '_' : '_') .$count . '\');"';
				//$mouseout = ' onmouseout="clearBackground(\'_' . $count . '\')"';
				$menu_output .='<div class="menu-item" id="' . ($level ? 'sub-' : '') . 'menu-item' . ($level ? $last_count . '_' :'_') .$count . '">';
				$menu_output .= '<a id="' . ($level ? 'a-sub-' : 'a-') . 'menu-item' . ($level ? $last_count . '_' : '_') .$count . '" href="'.(!empty($this->navmenu[$child]['href']) ? htmlspecialchars($this->navmenu[$child]['href']) : '#').'" class="'.(!empty($this->navmenu[$child]['class']) ? htmlspecialchars($this->navmenu[$child]['class']) : '').'"' . $extraAttributes . '>';

				if (($fixed_art_path) == $this->navmenu[$child]['href']) {
					$prevent_blank = '.onclick = YAHOO.util.Event.preventDefault ; ' ;
				} else {
					$prevent_blank = '' ;
				}

				if(!$level) {
					$script_output .= 'menuitem_array["menu-item' . $last_count . '_' .$count .'"]= "' . $last_count . '_' .$count . '";';
/*
					$script_output .= '$("menu-item' . $last_count . '_' .$count .'").onmouseover = menuItemAction;if ($("menu-item' . $last_count . '_' .$count.'").captureEvents) $("menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOVER);';
					$script_output .= '$("menu-item' . $last_count . '_' .$count .'").onmouseout = clearBackground;if ($("menu-item' . $last_count . '_' .$count.'").captureEvents) $("menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOUT);';
*/
					$script_output .= '$("a-menu-item' . $last_count . '_' .$count .'").onmouseover = menuItemAction;if ($("a-menu-item' . $last_count . '_' .$count.'").captureEvents) $("a-menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOVER);';

					$script_output .= '$("a-menu-item' . $last_count . '_' .$count .'").onmouseout = clearBackground;if ($("a-menu-item' . $last_count . '_' .$count.'").captureEvents) $("a-menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOUT);';

				}
				else {
					$script_output .= 'submenuitem_array["sub-menu-item' . $last_count . '_'.$count .'"] = "' . $last_count . '_' .$count . '";';
/*
					$script_output .= '$("sub-menu-item' . $last_count . '_' .$count.'").onmouseover = sub_menuItemAction;if ($("sub-menu-item' . $last_count . '_'.$count .'").captureEvents) $("sub-menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOVER);';
*/
					$script_output .= '$("a-sub-menu-item' . $last_count . '_' .$count.'").onmouseover = sub_menuItemAction;if ($("a-sub-menu-item' . $last_count . '_'.$count .'").captureEvents) $("a-sub-menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOVER);';
					if ('' != $prevent_blank) {
						$script_output .= '$("a-sub-menu-item' . $last_count . '_' .$count.'")' . $prevent_blank ;
					}
				}
				$menu_output .= htmlspecialchars($this->navmenu[$child]['text']);
				if ( !empty( $this->navmenu[$child]['children'] ) ) {
					//$menu_output .= '<img src="' . $wgUploadPath . '/common/new/right_arrow.gif?1"
					$menu_output .= '<em>&rsaquo;</em>';
				}
				$menu_output .= '</a>';
				$menu_output .= $this->printMenu($child, $last_count . '_' . $count, $level+1);
				$menu_output .= '</div>';
				$count++;
			}
			if ($level) {
				$menu_output .= '</div>';
			}
			$script_output .= '/*]]>*/</script>';
		}

		if ($menu_output.$script_output!="") {
			$output .= "<div id=\"navigation{$last_count}\">";
			$output .= $menu_output . $script_output;
			$output .= "</div>";
		}
		return $output;
	}


	function execute() {
		wfProfileIn( __METHOD__ );
		global $wgContLang, $wgAllInOne, $wgArticle, $wgUser, $wgLogo, $wgStylePath, $wgStyleVersion, $wgRequest, $wgTitle, $wgSitename, $wgEnableFAST_HOME2, $wgExtensionsPath, $wgAllInOne, $wgContentNamespaces, $wgEnableRecipesTweaksExt, $wgBlankImgUrl;

		$skin = $wgUser->getSkin();
		$namespace = $wgTitle->getNamespace();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="<?php $this->text('xhtmldefaultnamespace') ?>" <?php
	foreach($this->data['xhtmlnamespaces'] as $tag => $ns) {
		?>xmlns:<?php echo "{$tag}=\"{$ns}\" ";
	} ?>xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
<?php		wfProfileIn( __METHOD__ . '-head'); ?>
	<head>
		<meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
                <!-- Skin = <?php echo basename(__FILE__) ?> -->
		<?php $this->html('headlinks') ?>

		<title><?php $this->text('pagetitle') ?></title>
		<?php print Skin::makeGlobalVariablesScript( $this->data ); ?>
<?php
$allinone = $wgRequest->getBool('allinone', $wgAllInOne);
echo WikiaAssets::GetCoreCSS($skin->themename, $wgContLang->isRTL(), $allinone); // StaticChute + browser specific
echo WikiaAssets::GetExtensionsCSS($this->data['csslinks-urls']);
echo WikiaAssets::GetThemeCSS($skin->themename, $skin->skinname); 
echo WikiaAssets::GetSiteCSS($skin->themename, $wgContLang->isRTL(), $allinone); // Common.css, Monaco.css, -
echo WikiaAssets::GetUserCSS($this->data['csslinks-urls']);
?>
<?php
	foreach($this->data['references']['cssstyle'] as $cssstyle) {
?>
		<style type="text/css"><?= $cssstyle['content'] ?></style>
<?php
	}

	foreach($this->data['references']['css'] as $css) {
?>
		<?= isset($css['cond']) ? '<!--['.$css['cond'].']>' : '' ?><link rel="stylesheet" type="text/css" <?= isset($css['param']) ? $css['param'] : '' ?>href="<?= htmlspecialchars($css['url']) ?>" /><?= isset($css['cond']) ? '<![endif]-->' : '' ?>

<?php
	}

	if($wgRequest->getVal('action') != '' || $namespace == NS_SPECIAL) {
		$this->html('WikiaScriptLoader');
		$this->html('JSloader');
		foreach($this->data['references']['js'] as $script) {
			if (!empty($script['content'])) {
?>
		<script type="<?= $script['mime'] ?>"><?= $script['content'] ?></script>
<?php
			}
		}
		$this->html('headscripts');
	}

	$this->printAdditionalHead();
?>
	</head>
<?php		wfProfileOut( __METHOD__ . '-head');  ?>

<?php
wfProfileIn( __METHOD__ . '-body'); ?>
<?php
	if (ArticleAdLogic::isMainPage()){
		$isMainpage = ' mainpage';
	} else {
		$isMainpage = null;
	}

	$action = $wgRequest->getVal('action');
	if (in_array($action, array('edit', 'history', 'diff', 'delete', 'protect', 'unprotect', 'submit'))) {
		$body_css_action = 'action_' . $action;
	} else if (empty($action) || in_array($action, array('view', 'purge'))) {
		$body_css_action = 'action_view';
	} else {
		$body_css_action = '';
	}

	
	if(!isset($this->extraBodyClasses)){
		// For extra classes to put on the body tag.  This allows overriding sub-skins to create selectors specific to their sub-skin (such as custom answers).
		$this->extraBodyClasses = array();
	}
?>
	<body<?php if($this->data['body_onload'    ]) { ?> onload="<?php     $this->text('body_onload')     ?>"<?php } ?>
 class="mediawiki <?php $this->text('dir') ?> <?php $this->text('pageclass') ?><?php if(!empty($this->data['printable']) ) { ?> printable<?php } ?><?php if (!$wgUser->isLoggedIn()) { ?> loggedout<?php } ?> color2 wikiaSkinMonaco wikiaSkinLyricsMinimal<?=$isMainpage?> <?= $body_css_action ?><?php print " ".implode($this->extraBodyClasses, " "); ?>" id="body">
	<?php
	// Hardcoded Google Analytics tag... commented out because it isn't working yet.
	// Allow URL override.
	//global $wgNoExternals, $wgRequest;
	//$noExt = $wgRequest->getVal('noexternals');
	//if(!empty($noExt)){
	//	$wgNoExternals = true;
	//}
	//if(empty($wgNoExternals)){
		// <img src="http://www.google-analytics.com/__utm.gif?utmwv=1.3&amp;utmdt=test.wikia.com&amp;utmp=/tewst&amp;utmac=UA-288915-14" alt="" style="display: none" />
	//}

	// Sometimes we need an ad delivered at the very top of the page (like for a skin)
	// This sucks to have a blocking call at the top of the page, but they promised
	// to only do it if they needed. Only use DART or Google (fast Ad Providers with good infrastructure)
	global $wgEnableAdInvisibleTop, $wgEnableAdInvisibleHomeTop, $wgOut;
	if (!empty($wgEnableAdInvisibleHomeTop) && ArticleAdLogic::isMainPage()){
		echo '<script type="text/javascript" src="/extensions/wikia/AdEngine/AdEngine.js"></script>' . "\n";
		echo AdEngine::getInstance()->getAd('HOME_INVISIBLE_TOP');
	} else if (!empty($wgEnableAdInvisibleTop) && $wgOut->isArticle() && ArticleAdLogic::isContentPage()){
		echo '<script type="text/javascript" src="/extensions/wikia/AdEngine/AdEngine.js"></script>' . "\n";
		echo AdEngine::getInstance()->getAd('INVISIBLE_TOP');
	}
?>
<?php
	// this hook allows adding extra HTML just after <body> opening tag
	// append your content to $html variable instead of echoing
	$html = '';
	wfRunHooks('GetHTMLAfterBody', array ($this, &$html));
	echo $html;

	// NOTE: Removed wikia_header and user links.
?>
		<!-- PAGE -->
<?php		wfProfileIn( __METHOD__ . '-page'); ?>

	<div class="monaco_shrinkwrap" id="monaco_shrinkwrap_main">
<?php
wfRunHooks('MonacoBeforeWikiaPage', array($this));
?>
		<div id="wikia_page">
<?php
wfRunHooks('MonacoBeforePageBar', array($this));
if(empty($wgEnableRecipesTweaksExt) || !RecipesTweaks::isHeaderStripeShown()) {
?>
			<?php
				// NOTE: Removed page-bar page_bar here.

				echo AdEngine::getInstance()->getSetupHtml(); ?>
					<!-- ARTICLE -->

<?php }		wfProfileIn( __METHOD__ . '-article'); ?>
			<div id="article" <?php if($this->data['body_ondblclick']) { ?>ondblclick="<?php $this->text('body_ondblclick') ?>"<?php } ?>>
				<a name="top" id="top"></a>
				<?php
				wfRunHooks('MonacoAfterArticle', array($this)); // recipes: not needed?
				global $wgSupressSiteNotice, $wgEnableCommunityMessagesExt;
				if ( empty( $wgEnableCommunityMessagesExt ) && empty( $wgSupressSiteNotice ) && $this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
				<?php
				global $wgSupressPageTitle;
				if( empty( $wgSupressPageTitle ) ){
					$this->printFirstHeading();
				}

				if ($wgRequest->getVal('action') == 'edit') {
					//echo '<br /><a href="#" id="editTipsLink" onclick="editTips(); return false;">Show Editing Tips</a>';
				}
				?>
				<div id="bodyContent">
					<h3 id="siteSub"><?php $this->msg('tagline') ?></h3>
					<div id="contentSub"><?php $this->html('subtitle') ?></div>
					<?php if($this->data['undelete']) { ?><div id="contentSub2"><?php     $this->html('undelete') ?></div><?php } ?>
					<?php if($this->data['newtalk'] ) { ?><div class="usermessage noprint"><?php $this->html('newtalk')  ?></div><?php } ?>
					<?php if(!empty($skin->newuemsg)) { echo $skin->newuemsg; } ?>
					<?php echo $this->getTopAdCode(); ?>
					<?
					// Adsense for search
					global $wgAFSEnabled;
					if ($wgAFSEnabled && $wgTitle->getLocalURL() == $this->data['searchaction'] && !$wgUser->isLoggedIn() ) {
						renderAdsenseForSearch('w2n8', '2226605464');
					}
					?>

					<!-- start content -->
					<?php
					// Display content
					$this->printContent();

					// Display additional ads before categories and footer on long pages
					global $wgEnableAdsPrefooter, $wgDBname;
					if ( !empty( $wgEnableAdsPrefooter ) &&
					$wgOut->isArticle() &&
					ArticleAdLogic::isContentPage() &&
					ArticleAdLogic::isLongArticle($this->data['bodytext'])) {


						global $wgEnableAdsFooter600x250;

						if (!empty($wgEnableAdsFooter600x250)){
							echo AdEngine::getInstance()->getPlaceHolderIframe("PREFOOTER_BIG", true);
						} else {
							echo  '<table style="margin-top: 1em; width: 100%; clear: both"><tr>' .
							'<td style="text-align: center">' .
							AdEngine::getInstance()->getPlaceHolderIframe("PREFOOTER_LEFT_BOXAD", true) .
							'</td><td style="text-align: center">' .
							AdEngine::getInstance()->getPlaceHolderIframe("PREFOOTER_RIGHT_BOXAD", true) .
							"</td></tr>\n</table>";
						}
					}

					$this->printCategories();
					?>
					<!-- end content -->
					<?php if($this->data['dataAfterContent']) { $this->html ('dataAfterContent'); } ?>
					<div class="visualClear"></div>
				</div>

				<!--google_ad_section_end-->
				<!--contextual_targeting_end-->

			</div>
			<!-- /ARTICLE -->
			<?php

			// NOTE: Removed article footer.

			wfProfileOut( __METHOD__ . '-article');
		?>
		</div>
		<!-- /PAGE -->
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

<?php		wfProfileOut( __METHOD__ . '-page'); ?>

		<noscript><link rel="stylesheet" type="text/css" href="<?= $wgStylePath ?>/monaco/css/noscript.css?<?= $wgStyleVersion ?>" /></noscript>
<?php
	if(!($wgRequest->getVal('action') != '' || $namespace == NS_SPECIAL)) {
		$this->html('WikiaScriptLoader');
		$this->html('JSloader');
		$this->html('headscripts');
	}
	echo '<script type="text/javascript">/*<![CDATA[*/for(var i=0;i<wgAfterContentAndJS.length;i++){wgAfterContentAndJS[i]();}/*]]>*/</script>' . "\n";

if (array_key_exists("TOP_RIGHT_BOXAD", AdEngine::getInstance()->getPlaceholders())){
	// Reset elements with a "clear:none" to "clear:right" when the box ad is displayed
        // Fixes pages like this: http://en.dcdatabaseproject.com/Fang_Zhifu_(New_Earth)
	echo '<script type="text/javascript">AdEngine.resetCssClear("right");</script>' . "\n";
}

	// NOTE: Removed wikia_footer.

	// NOTE: Removed WIDGETS (sidebar stuff) here.

// curse like cobranding
$this->printCustomFooter();
?>

<?php
/* Put two "invisible" ad slots here. These are for loading ads that just load javascript,
but it isn't positioned at any particular part of a page, such as a slider or a interstitial */
if ($wgOut->isArticle() && ArticleAdLogic::isContentPage()){
	echo AdEngine::getInstance()->getAd('INVISIBLE_1');
}

echo AdEngine::getInstance()->getDelayedIframeLoadingCode();

if ($wgOut->isArticle() && ArticleAdLogic::isContentPage()){
	echo AdEngine::getInstance()->getAd('INVISIBLE_2');
}


echo '</div>';

// Quant serve moved *after* the ads because it depends on Athena/Provider values.
// macbre: RT #25697 - hide Quantcast Tags on edit pages
if ( in_array($wgRequest->getVal('action'), array('edit', 'submit')) ) {
	echo '<!-- QuantServe and comscore hidden on edit page -->';
}
else {
	echo AnalyticsEngine::track('Comscore', AnalyticsEngine::EVENT_PAGEVIEW);
	echo AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);
	echo AnalyticsEngine::track('Exelate', AnalyticsEngine::EVENT_PAGEVIEW);
}

$this->html('bottomscripts'); /* JS call to runBodyOnloadHook */
wfRunHooks('SpecialFooter');
?>
		<div id="positioned_elements" class="reset"></div>
<?php
$this->delayedPrintCSSdownload();
$this->html('reporttime');
wfProfileOut( __METHOD__ . '-body');
?>

	</body>
</html>
<?php
		wfProfileOut( __METHOD__ );
	} // end execute()

	//@author Marooned
	function delayedPrintCSSdownload() {
		global $wgRequest;

		//regular download
		if ($wgRequest->getVal('printable')) {
			// RT #18411
			$this->html('mergedCSSprint');
			// RT #25638
			echo "\n\t\t";
			$this->html('csslinksbottom');
		} else {
			$cssMediaWiki = $this->data['csslinksbottom-urls'];
			$cssStaticChute = $this->data['mergedCSSprint'];

			$cssReferences = array_keys($cssMediaWiki);

			// detect whether to use merged JS/CSS files
			global $wgAllInOne;
			if(empty($wgAllInOne)) {
				$wgAllInOne = false;
			}
			$allinone = $wgRequest->getBool('allinone', $wgAllInOne);

			if(!$allinone) {
				preg_match_all("/url\(([^?]+)/", $cssStaticChute, $matches);
				foreach($matches[1] as $match) {
					$cssReferences[] = $match;
				}
			} else {
				preg_match("/href=\"([^\"]+)/", $cssStaticChute, $matches);
				$cssReferences[] = str_replace('&amp;', '&', $matches[1]);
			}
			$cssReferences = Wikia::json_encode($cssReferences);

			echo <<<EOF
		<script type="text/javascript">/*<![CDATA[*/
			(function(){
				var cssReferences = $cssReferences;
				var len = cssReferences.length;
				for(var i=0; i<len; i++)
					setTimeout("wsl.loadCSS.call(wsl, '" + cssReferences[i] + "', 'print')", 100);
			})();
		/*]]>*/</script>
EOF;
		}
	}

	// curse like cobranding
	function printCustomHeader() {}
	function printCustomFooter() {}

	// Made a separate method so recipes, answers, etc can override. This is for any additional CSS, Javacript, etc HTML
	// that appears within the HEAD tag
	function printAdditionalHead(){}

	// Made a separate method so recipes, answers, etc can override. Notably, answers turns it off.
	function printPageBar(){}

	// Made a separate method so recipes, answers, etc can override. Notably, answers turns it off.
	function printFirstHeading(){
		?><h1 class="firstHeading"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title');
		wfRunHooks( 'MonacoPrintFirstHeading' );
		?></h1><?php
	}

	function getTopAdCode(){
	        echo AdEngine::getInstance()->getSetupHtml();

		global $wgOut, $wgAdsForceLeaderboards, $wgEnableIframeAds, $wgEnableTandemAds, $wgEnableFAST_HOME2;
		$topAdCode = '';
		if ($wgOut->isArticle()){
			if (ArticleAdLogic::isMainPage()){
				$topAdCode .= AdEngine::getInstance()->getPlaceHolderIframe('HOME_TOP_LEADERBOARD');
				if ($wgEnableFAST_HOME2) {
					$topAdCode .= AdEngine::getInstance()->getPlaceHolderIframe('HOME_TOP_RIGHT_BOXAD');
				}
			} else if ( ArticleAdLogic::isContentPage()){

				if (!empty($wgAdsForceLeaderboards)){
					$topAdCode = AdEngine::getInstance()->getPlaceHolderIframe('TOP_LEADERBOARD');
					if (!empty($wgEnableTandemAds) && ArticleAdLogic::isBoxAdArticle($this->data['bodytext'])) {
						$topAdCode .= AdEngine::getInstance()->getPlaceHolderIframe('TOP_RIGHT_BOXAD');
					}
				} else {
					// Let the collision detection decide
					if ( ArticleAdLogic::isStubArticle($this->data['bodytext'])){
						$topAdCode = AdEngine::getInstance()->getPlaceHolderIframe('TOP_LEADERBOARD');
					} else if (ArticleAdLogic::isBoxAdArticle($this->data['bodytext'])) {
						$topAdCode = AdEngine::getInstance()->getPlaceHolderIframe('TOP_RIGHT_BOXAD');
					} else {
						// Long article, but a collision
						$topAdCode = AdEngine::getInstance()->getPlaceHolderIframe('TOP_LEADERBOARD');
					}
				}
			}
		} elseif (ArticleAdLogic::isSearch()) {
			$topAdCode .= AdEngine::getInstance()->getPlaceHolderIframe('TOP_LEADERBOARD');
			$topAdCode .= AdEngine::getInstance()->getPlaceHolderIframe('TOP_RIGHT_BOXAD');
		}
		return $topAdCode;
	}

	// Made a separate method so recipes, answers, etc can override.
	function printContent(){
		$this->html('bodytext');
	}

	// Made a separate method so recipes, answers, etc can override.
	function printCategories(){
		// Display categories
		if($this->data['catlinks']) {
			$this->html('catlinks');
		}
	}

	/* Allow logo to be different */
	function printWikiaLogo() {
		global $wgLangToCentralMap, $wgContLang;
		$central_url = Wikia::langToSomethingMap($wgLangToCentralMap, $wgContLang->getCode(), "http://www.wikia.com/Wikia");
		echo '<div id="wikia_logo"><a rel="nofollow" href="' . $central_url . '">Wikia</a></div>';
	}

}
