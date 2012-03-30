<?php
/**
 * Base class for skin implementations
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

abstract class WikiaSkin extends SkinTemplate {
	protected $app = null;
	protected $wg = null;
	protected $wf = null;

	//strict mode for checking if an asset's URL is registered for the current skin
	//@see AssetsManager::checkAssetUrlForSkin
	protected $strictAssetUrlCheck = true;

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

		parent::__construct();
	}

	/**
	 * Wether the skin performs strict checks on queued scripts/styles
	 * 
	 * @return bool
	 */
	public function isStrict(){
		return $this->strictAssetUrlCheck;
	}

	/**
	 * Rerturns the scripts to be output for this template as an array
	 * 
	 * @return array an array with the following format:
	 * array( 'url' => 'asset URL, null if inlined code', 'tag' => 'the original tag found in the HTML output' );
	 */
	public function getScripts(){
		$this->wf->profileIn( __METHOD__ );

		$skinName = $this->getSkinName();
		$scriptTags = $this->wg->out->getScriptsOnly();
		$am = F::build( 'AssetsManager', array(), 'getInstance' );
		$matches = array();
		$res = array();

		//find all the script tags, including inlined and conditionals
		preg_match_all( '/(<!--\[\s*if[^>]+>.*<!\[\s*endif[^>]+-->|<script[^>]*>.*<\/script>)/imsU', $scriptTags, $matches );

		if ( !empty( $matches[0] ) ) {
			foreach ( $matches[0] as $m ) {
				$srcMatch = array();

				//find the src if set
				preg_match( '/<script[^>]+src=["\'\s]?([^"\'>\s]+)["\'\s]?[^>]*>/im', $m, $srcMatch );

				if ( !empty( $srcMatch[1] ) && $am->checkAssetUrlForSkin( $srcMatch[1], $skinName, $this->strictAssetUrlCheck ) ) {
					//fix HTML::inlineScript's expansion of ampersands in the src attribute
					$res[] = array( 'url' => str_replace( '&amp;', '&', $srcMatch[1] ), 'tag' => str_replace( '&amp;', '&', $m ) );
				} elseif ( empty( $srcMatch[1] ) && !$this->strictAssetUrlCheck ) {
					//only non-strict skins accept inline elements
					$res[] = array( 'url' => null, 'tag' => $m );
				}
			}
		}

		$this->wf->profileOut( __METHOD__ );
		return $res;
	}

	/**
	 * Rerturns the link tags for stylesheets to be output for this template as an array
	 * 
	 * @return array an array with the following format:
	 * array( 'url' => 'asset, null if inlined code', 'tag' => 'the original tag found in the HTML output' );
	 */
	public function getStyles(){
		$this->wf->profileIn( __METHOD__ );

		$skinName = $this->getSkinName();
		//there are a number of extension that use addScript to append link tags for stylesheets, need to include those too
		$stylesTags = $this->wg->out->buildCssLinks() . $this->wg->out->getScriptsOnly();
		$am = F::build( 'AssetsManager', array(), 'getInstance' );
		$matches = array();
		$res = array();

		//find all the link tags, including conditionals
		preg_match_all( '/(<!--\[\s*if[^>]+>\s*<link[^>]*>\s*<!\[\s*endif[^>]+-->|<link[^>]*>)/imsU', $stylesTags, $matches );

		if ( !empty( $matches[0] ) ) {
			foreach ( $matches[0] as $m ) {
				$hrefMatch = array();
	
				//find the src if set
				preg_match( '/<link[^>]+href=["\'\s]?([^"\'>\s]+)["\'\s]?[^>]*>/im', $m, $hrefMatch );

				if ( !empty( $hrefMatch[1] ) && $am->checkAssetUrlForSkin( $hrefMatch[1], $skinName, $this->strictAssetUrlCheck ) ) {
					//fix HTML::element's expansion of ampersands in the src attribute
					$res[] = array( 'url' => str_replace( '&amp;', '&', $hrefMatch[1] ), 'tag' => str_replace( '&amp;', '&', $m ) );
				} elseif ( empty( $hrefMatch[1] ) && !$this->strictAssetUrlCheck ) {
					$res[] = array( 'url' => null, 'tag' => $m );
				}
			}
		}

		//find all the inline style tags, including conditionals
		preg_match_all( '/(<!--\[\s*if[^>]+>\s*<style[^>]*>.*<\/style>\s*<!\[\s*endif[^>]+-->|<style[^>]*>.*<\/style>)/imsU', $stylesTags, $matches );

		if ( !empty( $matches[0] ) ) {
			foreach ( $matches[0] as $m ) {
				if ( !$this->strictAssetUrlCheck ) {
					//only non-strict skins accept inline elements
					$res[] = array( 'url' => null, 'tag' => $m );
				}
			}
		}

		$this->wf->profileOut( __METHOD__ );
		return $res;
	}
}