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
		global $wgConf;
		$reason = $this->getRequest()->getText( 'wpReason' );
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
		$ok = $wgConf->saveNewSettings( $new, $this->getUser(), $this->mWiki, $reason );

		$result = $ok ? 'success' : 'failure';

		$this->getOutput()->redirect( $this->getTitle()->getFullURL( "result=$result" ) );
	}

	/**
	 * Show the diff between the current version and the posted version
	 */
	protected function showDiff() {
		global $wgConf;
		$wiki = $this->mWiki;
		$old = array( $wiki => $wgConf->getCurrent( $wiki ) );
		$new = array( $wiki => $this->conf );
		$diff = new ExtPreviewConfigurationDiff( $this->getContext(), $old, $new, array( $wiki ) );
		$diff->setViewCallback( array( $this, 'userCanRead' ) );
		$this->getOut()->addHTML( $diff->getHtml() );
	}

	/**
	 * Check dependencies against other extensions, and print errors if any
	 *
	 * @return Boolean: success
	 */
	protected function checkExtensionsDependencies() {
		$request = $this->getRequest();
		foreach ( $this->mConfSettings->getAllExtensionsObjects() as $ext ) {
			if ( !count( $ext->getExtensionsDependencies() ) || !$request->getCheck( $ext->getCheckName() ) )
				continue;

			foreach ( $ext->getExtensionsDependencies() as $depName ) {
				$dep = $this->mConfSettings->getExtension( $depName );
				if ( !is_object( $dep ) )
					throw new MWException( "Unable to find \"{$depName}\" dependency for \"{$ext->getName()}\" extension" );
				if ( !$request->getCheck( $dep->getCheckName() ) ) {
					$this->getOutput()->wrapWikiMsg( '<span class="errorbox">$1</span>',
						array( 'configure-ext-ext-dependency-err', $ext->getName(), $depName ) );
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
 		global $wgConfigureOnlyUseVarForExt;
 		if ( $wgConfigureOnlyUseVarForExt )
 			return array();
		$arr = array();
		foreach ( $this->mConfSettings->getAllExtensionsObjects() as $ext ) {
			if( !$ext->isUsable() )
				continue; // must exist
			if ( $ext->useVariable() )
 				continue;
			if ( $this->getRequest()->getCheck( $ext->getCheckName() ) )
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
		$ret = '';
		$globalDone = false;
		foreach ( $this->mConfSettings->getAllExtensionsObjects() as $wikiExt ) {
			if( !$wikiExt->isUsable() )
				continue; // must exist and be enabled

			$wikiExt->setPageObj( $this );

			if ( $this->mIsPreview )
				$wikiExt->setTempActivated( $this->getRequest()->getCheck( $ext->getCheckName() ) );

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

			$ret .= $wikiExt->getHtml( $this->getContext() );
		}

		return $ret;
	}
}
