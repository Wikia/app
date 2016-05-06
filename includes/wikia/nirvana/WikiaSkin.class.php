<?php
/**
 * Base class for skin implementations
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

abstract class WikiaSkin extends SkinTemplate {
	const SCRIPT_REGEX = '/(<!--\[\s*if[^>]+>.*<!\[\s*endif[^>]+-->|<script[^>]*>.*<\/script>)/imsU';
	const LINK_REGEX = '/(<!--\[\s*if[^>]+>\s*<link[^>]*rel=["\']?stylesheet["\']?[^>]*>\s*<!\[\s*endif[^>]+-->|<link[^>]*rel=["\']?stylesheet["\']?[^>]*>)/imsU';
	const STYLE_REGEX = '/(<!--\[\s*if[^>]+>\s*<style[^>]*>.*<\/style>\s*<!\[\s*endif[^>]+-->|<style[^>]*>.*<\/style>)/imsU';

	const USER_LOGIN_STATUS_CLASS_LOGGED = ' user-logged';
	const USER_LOGIN_STATUS_CLASS_ANON = ' user-anon';

	protected $app = null;
	protected $wg = null;
	protected $wf = null;

	//strict mode for checking if an asset's URL is registered for the current skin
	//@see AssetsManager::checkAssetUrlForSkin
	protected $strictAssetUrlCheck = true;

	private $assetsManager;

	/**
	 * WikiaSkin constructor
	 *
	 * @param String $templateClassName Mame of the QuickTemplate subclass to associate to this skin
	 * @param String $skinName Name of the skin (lowercase)
	 * @param String $styleName The style name, will use $skinName if not specified
	 * @param null $themeName The theme name, will use $skinName if not specified
	 */
	function __construct( $templateClassName = null, $skinName = null, $themeName = null, $styleName = null ) {
		$this->app = F::app();
		$this->wg = $this->app->wg;
		$this->wf = $this->app->wf;

		$this->assetsManager = AssetsManager::getInstance();

		/**
		 * old skins initialize template, skinname, stylename and themename statically in the class declaration,
		 * we need to support them too so, that's what the following checks are meant for
		 */
		if ( $templateClassName !== null ) {
			$this->template  = $templateClassName;
		}

		if ( $skinName !== null ) {
			$this->skinname = $skinName;
		}

		if ( $styleName !== null ) {
			$this->stylename = $styleName;
		} elseif ( !isset( $this->stylename ) ) {
			$this->stylename = $this->skinname;
		}

		if ( $themeName !== null ) {
			$this->themename = $themeName;
		} elseif ( !isset( $this->themename ) ) {
				$this->themename = $this->skinname;
		}
	}

	/**
	 * Whether the skin performs strict checks on queued scripts/styles
	 *
	 * @return bool
	 */
	public function isStrict(){
		return $this->strictAssetUrlCheck;
	}

	/**
	 * Returns misc items to be added to the head element
	 *
	 * @return string an html fragment containing the elements
	 */
	public function getHeadItems() {
		wfProfileIn( __METHOD__ );

		//filter out elements that will be processed by getScripts or getStyles
		$res = preg_replace( array( self::SCRIPT_REGEX, self::LINK_REGEX, self::STYLE_REGEX ), '', $this->wg->out->getHeadItems() );

		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * Returns the scripts to be output for this template as an array
	 *
	 * @return array an array with the following format:
	 * array( 'url' => 'asset URL, null if inlined code', 'tag' => 'the original tag found in the HTML output' );
	 */
	public function getScripts(){
		wfProfileIn( __METHOD__ );

		$scriptTags = $this->wg->out->getScriptsOnly() . $this->wg->out->getHeadItems();
		$matches = array();
		$res = array();

		//find all the script tags, including inlined and conditionals
		preg_match_all( self::SCRIPT_REGEX, $scriptTags, $matches );

		if ( !empty( $matches[0] ) ) {
			foreach ( $matches[0] as $m ) {
				$srcMatch = array();

				//find the src if set
				preg_match( '/<script[^>]+src=["\'\s]?([^"\'>\s]+)["\'\s]?[^>]*>/im', $m, $srcMatch );

				if ( !empty( $srcMatch[1] ) && $this->assetsManager->checkAssetUrlForSkin( $srcMatch[1], $this ) ) {
					//fix HTML::inlineScript's expansion of ampersands in the src attribute
					$url = str_replace( '&amp;', '&', $srcMatch[1] );
					// apply domain sharding
					$url = wfReplaceAssetServer($url);
					$res[] = array( 'url' => $url, 'tag' => str_replace( '&amp;', '&', $m ) );
				} elseif ( empty( $srcMatch[1] ) && !$this->strictAssetUrlCheck ) {
					//only non-strict skins accept inline elements
					$res[] = array( 'url' => null, 'tag' => $m );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * This method extracts script tags from $this->getScripts() method
	 * and generates a single <script> tag to load all required AssetsManager
	 * groups in a single HTTP request.
	 *
	 * Bottom scripts are added to the end of the output.
	 *
	 * Additionaly, all groups from $groups array will be loaded as well.
	 *
	 * Once this function ends its run $groups will be updated (via a reference)
	 * with all AM groups extracted from getScripts().
	 *
	 * @param array $groups additional list of AM groups to load
	 * @return string <script> tags with extracted JS files and the rest
	 */
	public function getScriptsWithCombinedGroups(Array &$groups) {
		wfProfileIn(__METHOD__);
		$scripts = $this->getScripts();
		$bottomScripts = $this->bottomScripts();

		// extract all <script> tags that load a single AssetsManager group
		if ( is_array( $scripts ) ) {
			foreach ( $scripts as $idx => $script ) {
				if ( isset( $script['url'] ) ) {
					if ( $this->assetsManager->isGroupURL( $script['url'] ) ) {
						$groups[] = $this->assetsManager->getGroupNameFromUrl( $script['url'] );
						unset( $scripts[$idx] );
					}

					// remove this entry from bottom scripts as it was extracted
					// from there by $this->getScripts() call above
					$bottomScripts = str_replace(Html::linkedScript($script['url']) . "\n" , '', $bottomScripts);
				}
			}
		}

		// render script tags
		$scriptTags = '';

		// load these groups with a skin check
		foreach ( $this->assetsManager->getURL( $groups ) as $src ) {
			if ( $this->assetsManager->checkAssetUrlForSkin( $src, $this ) ) {
				$scriptTags .= "<script src='{$src}'></script>\n";
			}
		}

		// load all remaining scripts
		foreach ( $scripts as $script ) {
			if (isset($script['url'])) {
				$scriptTags .= "<script src='{$script['url']}'></script>\n";
			}
		}

		wfDebug( sprintf( "%s: combined %d JS groups\n", __METHOD__, count($groups) ) );

		// append bottom scripts to the output
		$scriptTags .= $bottomScripts;

		wfProfileOut(__METHOD__);
		return $scriptTags;
	}

	/**
	 * Returns the link tags for stylesheets to be output for this template as an array
	 *
	 * @return array an array with the following format:
	 * array( 'url' => 'asset, null if inlined code', 'tag' => 'the original tag found in the HTML output' );
	 */
	public function getStyles(){
		wfProfileIn( __METHOD__ );

		//there are a number of extension that use addScript to append link tags for stylesheets, need to include those too
		$stylesTags = $this->wg->out->buildCssLinks(). $this->wg->out->getHeadItems() . $this->wg->out->getScriptsOnly();
		$matches = array();
		$res = array();

		//find all the link tags, including conditionals
		preg_match_all( self::LINK_REGEX, $stylesTags, $matches );

		if ( !empty( $matches[0] ) ) {
			foreach ( $matches[0] as $m ) {
				$hrefMatch = array();

				//find the src if set
				preg_match( '/<link[^>]+href=["\'\s]?([^"\'>\s]+)["\'\s]?[^>]*>/im', $m, $hrefMatch );

				if ( !empty( $hrefMatch[1] ) && $this->assetsManager->checkAssetUrlForSkin( $hrefMatch[1], $this ) ) {
					//fix HTML::element's expansion of ampersands in the src attribute
					// todo: do we really need this trick? I notice URLs that are not properly encoded in the head element
					$url = str_replace( '&amp;', '&', $hrefMatch[1] );
					// apply domain sharding
					$url = wfReplaceAssetServer($url);
					$res[] = array( 'url' => $url, 'tag' => str_replace( '&amp;', '&', $m ) );
				} elseif ( empty( $hrefMatch[1] ) && !$this->strictAssetUrlCheck ) {
					$res[] = array( 'url' => null, 'tag' => $m );
				}
			}
		}

		//find all the inline style tags, including conditionals
		preg_match_all( self::STYLE_REGEX, $stylesTags, $matches );

		if ( !empty( $matches[0] ) ) {
			foreach ( $matches[0] as $m ) {
				if ( !$this->strictAssetUrlCheck ) {
					//only non-strict skins accept inline elements
					$res[] = array( 'url' => null, 'tag' => $m );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * This method extracts links to SASS files from $this->getStyles() method
	 * and generates a single <link> tag to load all of them via a single HTTP request.
	 *
	 * Additionaly, all SASS files from $sassFiles array will be loaded as well.
	 *
	 * Once this function ends its run $sassFiles will be updated (via a reference)
	 * with all SASS files extracted from getStyles().
	 *
	 * @param array $sassFiles additional list of SASS files to load
	 * @return string CSS links with extracted SASS files and the rest
	 */
	public function getStylesWithCombinedSASS(Array &$sassFiles) {
		wfProfileIn(__METHOD__);

		global $wgAllInOne;
		$cssLinks = [];

		foreach ( $this->getStyles() as $s ) {
			if ( !empty($s['url']) ) {
				if ($wgAllInOne && $this->assetsManager->isSassUrl($s['url'])) {
					$sassFiles[] = $s['url'];
				} else {
					$cssLinks[] = $s['tag'];
				}
			} else {
				$cssLinks[] = $s['tag'];
			}
		}

		// turn an url (http://something.wikia.com/__am/sass/options/path/to/file.scss) to a local filepath
		$sassFiles = $this->assetsManager->getSassFilePath($sassFiles);

		// get a single URL to fetch all the required SASS files
		$sassFilesUrl = $this->assetsManager->getSassesUrl($sassFiles);

		// recovery unlock css
		$unlockUrl = ARecoveryUnlockCSS::getUnlockCSSUrl();

		wfDebug( sprintf( "%s: combined %d SASS files\n", __METHOD__, count($sassFiles) ) );

		wfProfileOut(__METHOD__);
		return Html::linkedStyle($sassFilesUrl) . Html::linkedStyle($unlockUrl) . implode('', $cssLinks);
	}

	/*
	 * WikiaMobile skin has its own getTopScripts
	 * MobileWikiaSkin::getTopScripts
	 *
	 */
	public function getTopScripts() {
		$scripts = '';
		$vars = [
			'Wikia' => new stdClass(),
		];

		wfRunHooks( 'WikiaSkinTopScripts', array( &$vars, &$scripts, $this ) );

		$scripts .= $this->renderTopShortTTLModules();

		$scriptModules = array( 'amd', 'wikia.tracker.stub' );
		wfRunHooks( 'WikiaSkinTopModules', array( &$scriptModules, $this ) );
		if ( !empty($scriptModules) ) {
			// Mocking mw.loader.state so the script can be loaded up high
			// Whatever is passed to mw.loader.state is saved to window.preMwLdrSt
			// Once the real mw.loader.state is available this variable will be passed to it
			$scripts = Html::inlineScript('window.mw||(mw={fk:1,loader:{state:function(s){preMwLdrStA=window.preMwLdrStA||[];preMwLdrStA.push(s)}}});') . "\n"
				. $scripts;
			$scripts .= ResourceLoader::makeCustomLink($this->wg->out, $scriptModules, 'scripts') . "\n";
			// Replacing mw with the original function
			$scripts .= Html::inlineScript('window.mw.fk&&delete mw;') . "\n";
		}

		return self::makeInlineVariablesScript($vars) . $scripts;
	}

	/**
	 * Load ResourceLoader modules that have a short caching time
	 *
	 * Used by AbTesting and InstantGlobals
	 *
	 * @return string
	 * @author macbre
	 */
	protected function renderTopShortTTLModules() {
		$shortTtlScriptModules = [];

		wfRunHooks( 'WikiaSkinTopShortTTLModules', [ &$shortTtlScriptModules, $this ] );

		if ( !empty($shortTtlScriptModules) ) {
			$scripts = ResourceLoader::makeCustomLink( $this->wg->out, $shortTtlScriptModules, 'scripts' ) . "\n";
		}
		else {
			$scripts = '';
		}

		return $scripts;

	}

	// expose protected methods from Skin object
	// we don't need buildSidebar()

	public function buildPersonalUrls() {
		return parent::buildPersonalUrls();
	}

	public function buildContentNavigationUrls() {
		return parent::buildContentNavigationUrls();
	}

	public function buildContentActionUrls( $content_navigation ) {
		return parent::buildContentActionUrls( $content_navigation );
	}

	public function buildNavUrls() {
		return parent::buildNavUrls();
	}

	public function subPageSubtitle() {
		// bugid: 51048 -- don't show subpage link for blog content
		if ( $this->wg->Title->getNamespace() > 599 || $this->wg->Title->getNamespace() < 500 ) {
			return parent::subPageSubtitle();
		}
		return '';
	}

	static function makeInlineVariablesScript( $data ) {
		$wf = F::app()->wf;
		wfProfileIn( __METHOD__ );

		if( $data ) {
			$r = array();
			foreach ( $data as $name => $value ) {
				$encValue = Xml::encodeJsVar( $value );
				$r[] = "$name=$encValue";
			}

			$js = Html::inlineScript( "\nvar " . implode( ",\n", $r ) . ";\n");
			wfProfileOut( __METHOD__ );
			return $js;
		} else {
			wfProfileOut(__METHOD__ );
			return '';
		}
	}

	/**
	 * Returns a name of a class that is associated with a login status of the current user.
	 * @return string
	 */
	public function getUserLoginStatusClass() {
		if ( F::app()->wg->User->isLoggedIn() ) {
			return self::USER_LOGIN_STATUS_CLASS_LOGGED;
		}

		return self::USER_LOGIN_STATUS_CLASS_ANON;
	}

	public function initPage( OutputPage $out ) {
		$out->topScripts = $this->getTopScripts();
		parent::initPage($out);
	}
}
