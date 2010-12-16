<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Special page that allows authorised users to configure extensions
 *
 * @ingroup Extensions
 */
class SpecialExtensions extends ConfigurationPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Extensions', 'extensions' );
	}

	protected function getSettingMask() {
		return CONF_SETTINGS_EXT;
	}

	/**
	 * Submit a posted form
	 */
	public function doSubmit() {
		global $wgConf, $wgOut, $wgRequest;
		$reason = $wgRequest->getText( 'wpReason' );
		$current = $wgConf->getCurrent( $this->mWiki );
		$settings = $this->importFromRequest();
		$new = $settings + $current;
		if ( !$this->checkExtensionsDependencies() ) {
			$this->conf = $new;
			$this->mIsPreview = true;
			$this->showForm();
			return;
		}
		$new = $this->removeDefaults( $new );
		$new['__includes'] = $this->getRequiredFiles();
		$ok = $wgConf->saveNewSettings( $new, $this->mWiki, $reason );

		$result = $ok ? 'success' : 'failure';

		$url = $this->getTitle()->getLocalURL( "result=$result" );
		$wgOut->redirect( $url );
	}

	/**
	 * Show the diff between the current version and the posted version
	 */
	protected function showDiff() {
		global $wgConf, $wgOut;
		$wiki = $this->mWiki;
		$old = array( $wiki => $wgConf->getCurrent( $wiki ) );
		$new = array( $wiki => $this->conf );
		$diff = new ExtPreviewConfigurationDiff( $old, $new, array( $wiki ) );
		$diff->setViewCallback( array( $this, 'userCanRead' ) );
		$wgOut->addHTML( $diff->getHtml() );
	}

	/**
	 * Check dependencies against other extensions, and print errors if any
	 *
	 * @return Boolean: success
	 */
	protected function checkExtensionsDependencies() {
		global $wgRequest, $wgOut;

		foreach ( $this->mConfSettings->getAllExtensionsObjects() as $ext ) {
			if ( !count( $ext->getExtensionsDependencies() ) || !$wgRequest->getCheck( $ext->getCheckName() ) )
				continue;

			foreach ( $ext->getExtensionsDependencies() as $depName ) {
				$dep = $this->mConfSettings->getExtension( $depName );
				if ( !is_object( $dep ) )
					throw new MWException( "Unable to find \"{$depName}\" dependency for \"{$ext->getName()}\" extension" );
				if ( !$wgRequest->getCheck( $dep->getCheckName() ) ) {
					$wgOut->wrapWikiMsg( '<span class="errorbox">$1</span>', array( 'configure-ext-ext-dependency-err', $ext->getName(), $depName ) );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Get an array of files to include at each request
	 * @return array
	 */
	protected function getRequiredFiles() {
 		global $wgRequest, $wgConfigureOnlyUseVarForExt;
 		if ( $wgConfigureOnlyUseVarForExt )
 			return array();
		$arr = array();
		foreach ( $this->mConfSettings->getAllExtensionsObjects() as $ext ) {
			if( !$ext->isUsable() )
				continue; // must exist
			if ( $ext->useVariable() )
 				continue;
			if ( $wgRequest->getCheck( $ext->getCheckName() ) )
				$arr[] = $ext->getFile();
		}
		return $arr;
	}

	/**
	 * Simple wrapper to make it public
	 */
	public function buildInput( $conf, $param = array() ) {
		return parent::buildInput( $conf, $param );
	}

	/**
	 * Same as before
	 */
	public function getSettingValue( $setting ) {
		return parent::getSettingValue( $setting );
	}

	/**
	 * Build the content of the form
	 *
	 * @return xhtml
	 */
	protected function buildAllSettings() {
		global $wgRequest;

		$ret = '';
		$globalDone = false;
		foreach ( $this->mConfSettings->getAllExtensionsObjects() as $wikiExt ) {
			if( !$wikiExt->isUsable() )
				continue; // must exist and be enabled

			$wikiExt->setPageObj( $this );

			if ( $this->mIsPreview )
				$wikiExt->setTempActivated( $wgRequest->getCheck( $ext->getCheckName() ) );

			$settings = $wikiExt->getSettings();
			foreach ( $settings as $setting => $type ) {
				if ( !isset( $this->conf[$setting] ) && $wikiExt->canIncludeFile() ) {
					if ( !$globalDone ) {
						extract( $GLOBALS, EXTR_REFS );
						global $wgHooks;
						$oldHooks = $wgHooks;
						$globalDone = true;
					}
					require_once( $wikiExt->getFile() );
					if ( isset( $$setting ) )
						$this->conf[$setting] = $$setting;
				}
			}
			if ( $globalDone )
				$GLOBALS['wgHooks'] = $oldHooks;

			$ret .= $wikiExt->getHtml();
		}

		return $ret;
	}
}
