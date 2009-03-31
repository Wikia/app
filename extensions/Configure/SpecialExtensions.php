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
	 * Get an array of files to include at each request
	 * @return array
	 */
	protected function getRequiredFiles() {
 		global $wgRequest, $wgConfigureOnlyUseVarForExt;
 		if ( $wgConfigureOnlyUseVarForExt )
 			return array();
		$arr = array();
		foreach ( $this->mConfSettings->getAllExtensionsObjects() as $ext ) {
			if( !$ext->isInstalled() ) continue; // must exist
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
		$ret = '';
		$globalDone = false;
		foreach ( $this->mConfSettings->getAllExtensionsObjects() as $ext ) {
			if( !$ext->isInstalled() ) continue; // must exist
			$settings = $ext->getSettings();
			foreach ( $settings as $setting => $type ) {
				if ( !isset( $this->conf[$setting] ) && file_exists( $ext->getFile() ) ) {
					//echo "$setting<br/>\n";
					if ( !$globalDone ) {
						extract( $GLOBALS, EXTR_REFS );
						global $wgHooks;

						$oldHooks = $wgHooks;
						$globalDone = true;
					}
					require_once( $ext->getFile() );
					if ( isset( $$setting ) )
						$this->conf[$setting] = $$setting;
				}
			}
			$ext->setPageObj( $this );
			$ret .= $ext->getHtml();
		}
		if ( $globalDone )
			$GLOBALS['wgHooks'] = $oldHooks;
		return $ret;
	}
}
