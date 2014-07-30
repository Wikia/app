<?php
/**
 */
class VenusService extends WikiaService {

	/**
	 * @var $skin WikiaSkin
	 */
	private $skin;

	/**
	 * @var $templateObject SkinTemplate
	 */
	private $templateObject;

	private $jsBodyPackages = [];
	private $jsExtensionPackages = [];
	private $scssPackages = [];

	private $globalVariables = [];

	/**
	 * @var $assetsManager AssetsManager
	 */
	private $assetsManager;

	function __construct($skinTemplateObj) {
		$this->skin = RequestContext::getMain()->getSkin();
		$this->templateObject = $skinTemplateObj;
		$this->assetsManager = AssetsManager::getInstance();
	}


	public function getAssets(){
		wfProfileIn( __METHOD__ );

		$cssLinks = '';
		$jsBodyFiles = '';
		$jsExtensionFiles = '';
		$styles = $this->skin->getStyles();
		$scripts = $this->skin->getScripts();

		array_unshift( $this->jsBodyPackages, 'venus_body_js' );
		array_unshift( $this->scssPackages, 'venus_scss' );

		//let extensions manipulate the asset packages (e.g. ArticleComments,
		//this is done to cut down the number or requests)
		$this->app->runHook(
			'VenuseAssetsPackages',
			[
				//This should be a static package - files that need to be loaded on EVERY page
				&$this->jsBodyPackages,
				//All the rest can go here ie. assets for FilePage, special pages and so on
				&$this->jsExtensionPackages,
				&$this->scssPackages
			]
		);

		if ( is_array( $this->scssPackages ) ) {
			//force main SCSS as first to make overriding it possible
			foreach ( $this->assetsManager->getURL( $this->scssPackages ) as $s ) {
				//packages/assets are enqueued via an hook, let's make sure we should actually let them through
				if ( $this->assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
					//W3C standard says type attribute and quotes (for single non-URI values) not needed, let's save on output size
					$cssLinks .= "<link rel=stylesheet href='{$s}'/>";
				}
			}
		}

		if ( is_array( $styles ) ) {
			foreach ( $styles as $s ) {
				//safe URL's as getStyles performs all the required checks
				$cssLinks .= "<link rel=stylesheet href='{$s['url']}'/>";//this is a strict skin, getStyles returns only elements with a set URL
			}
		}

		if ( is_array( $this->jsExtensionPackages ) ) {
			//core JS in the head section, definitely safe
			foreach ( $this->assetsManager->getURL( $this->jsExtensionPackages ) as $src ) {
				$jsExtensionFiles .= "<script src='{$src}'></script>";
			}
		}

		if ( is_array( $this->jsBodyPackages ) ) {
			foreach ( $this->assetsManager->getURL( $this->jsBodyPackages ) as $s ) {
				//packages/assets are enqueued via an hook, let's make sure we should actually let them through
				if ( $this->assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
					$jsBodyFiles .= "<script src='{$s}'></script>";
				}
			}
		}

		if ( is_array( $scripts ) ) {
			foreach ( $scripts as $s ) {
				//safe URLs as getScripts performs all the required checks
				$jsBodyFiles .= "<script src='{$s['url']}'></script>";
			}
		}

		$this->response->setVal( 'jsExtensionPackages', $jsExtensionFiles );
		$this->response->setVal( 'cssLinks', $cssLinks );
		$this->response->setVal( 'jsBodyFiles', $jsBodyFiles );

		wfProfileOut( __METHOD__ );
	}
}
