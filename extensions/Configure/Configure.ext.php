<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Class that represent an extension
 *
 * @ingroup Extensions
 */
class WebExtension {
	protected $mSettings;
	protected $mArrays;
	protected $mEmptyValues;
	protected $mViewRestricted;
	protected $mEditRestricted;
	protected $mName;
	protected $mDbChange;
	protected $mExtensionsDependencies;
	protected $mSettingsDependencies;
	protected $mInputCallback = null;
	protected $mDir;
	protected $mFile;
	protected $mDoc;
	protected $mExtVar = null;
	protected $mObj = null;
	protected $mTempActivated = null;

	/**
	 * Construct a new object.
	 *
	 * @param $conf Array
	 */
	public function __construct( /*array*/ $conf ) {
		global $wgConfigureExtensionsVar;

		$this->mName = $conf['name'];
		$this->mSettings = isset( $conf['settings'] ) ? $conf['settings'] : array();
		$this->mDbChange = isset( $conf['schema'] ) && $conf['schema'];
		$this->mDir = isset( $conf['dir'] ) ? $conf['dir'] : $conf['name'];
		$this->mFile = isset( $conf['file'] ) ? $conf['file'] : $conf['name'] . '.php';
		$this->mArrays = isset( $conf['array'] ) ? $conf['array'] : array();
		$this->mEmptyValues = isset( $conf['empty'] ) ? $conf['empty'] : array();
		$this->mViewRestricted = isset( $conf['view-restricted'] ) ? $conf['view-restricted'] : array();
		$this->mEditRestricted = isset( $conf['edit-restricted'] ) ? $conf['edit-restricted'] : array();
		$this->mExtensionsDependencies = isset( $conf['extensions-dependencies'] ) ? $conf['extensions-dependencies'] : array();
		$this->mSettingsDependencies = isset( $conf['settings-dependencies'] ) ? $conf['settings-dependencies'] : array();
		$this->mDoc = isset( $conf['url'] ) ? $conf['url'] : null;
 		if ( isset( $wgConfigureExtensionsVar[$this->mName] ) ) {
 			$this->mExtVar = $wgConfigureExtensionsVar[$this->mName];
 		}
	}

	/**
	 * Get the name of the extension
	 *
	 * @return string
	 */
	public function getName() {
		return $this->mName;
	}

	/**
	 * Get the settings name used by this extension
	 *
	 * @return array
	 */
	public function getSettings() {
		return $this->mSettings;
	}

	/**
	 * Get the array definitions of this extension
	 *
	 * @return array
	 */
	public function getArrayDefs() {
		return $this->mArrays;
	}

	/**
	 * Get the values to be used when the setting is empty
	 *
	 * @return array
	 */
	public function getEmptyValues() {
		return $this->mEmptyValues;
	}

	/**
	 * Get settings that can only be viewed by users with *-all right
	 *
	 * @return array
	 */
	public function getViewRestricted() {
		return $this->mViewRestricted;
	}

	/**
	 * Get settings that can only be modified by users with *-all right
	 *
	 * @return array
	 */
	public function getEditRestricted() {
		return $this->mEditRestricted;
	}

	/**
	 * Set a special page object used to generate an input
	 *
	 * @param $obj ConfigurationPage object
	 */
	public function setPageObj( ConfigurationPage $obj ) {
		$this->mObj = $obj;
	}

	/**
	 * Get a bool wheter this extension requires a schema change
	 *
	 * @return bool
	 */
	public function hasSchemaChange() {
		return $this->mDbChange;
	}

	/**
	 * Get the list of extensions that needs to be activated so that this
	 * extension can work
	 *
	 * @return array
	 */
	public function getExtensionsDependencies() {
		return $this->mExtensionsDependencies;
	}

	/**
	 * Get the associative array mapping settings to their values needed by this
	 * extension
	 *
	 * @return array
	 */
	public function getSettingsDependencies() {
		return $this->mSettingsDependencies;
	}

	/**
	 * Get a url for the description of this extension (or null)
	 *
	 * @return string or null
	 */
	public function getUrl() {
		return $this->mDoc;
	}

	/**
	 * Get the main file (the one that should be included in LocalSettings.php)
	 *
	 * @return string
	 */
	public function getFile() {
		global $wgConfigureExtDir;
		return $wgConfigureExtDir . $this->mDir . '/' . $this->mFile;
	}

	/**
	 * Prettify boolean settings to be correctly displayed
	 *
	 * @return String 
	 */
	public static function prettifyForDisplay( $val ) {
		if ( is_bool( $val ) )
			return wfBoolToStr( $val );
		return $val;
	}

	/**
	 * Generate html to configure this extension
	 *
	 * @return String: XHTML
	 */
	public function getHtml() {
		if ( !$this->isInstalled() )
			return '';
		$ret = '<fieldset><legend>' . htmlspecialchars( $this->mName ) . '</legend>';
		if ( count( $errors = $this->checkSettingsDependencies() ) ) {
			$ret .= "<span class=\"errorbox\">";
			$ret .= wfMsgExt( 'configure-ext-settings-dep-errors', array( 'parseinline' ), count( $errors ) );
			$ret .= "<ul>\n";
			foreach ( $errors as $err ) {
				list( $setting, $req, $cur ) = $err;
				$setting = '$'.$setting;
				$req = self::prettifyForDisplay( $req );
				$cur = self::prettifyForDisplay( $cur );
				$ret .= '<li>' . wfMsgExt( 'configure-ext-settings-dep-error', array( 'parseinline' ), $setting, $req, $cur ) . "</li>\n";
			}
			return $ret . "</ul>\n</span>\n</fieldset>";
		}

		$warnings = array();

		if ( $this->mDbChange ) {
			$warnings[] = wfMsgExt( 'configure-ext-schemachange', array( 'parseinline' ) );
		}
		if ( count( $this->mExtensionsDependencies ) ) {
			global $wgLang;
			$warnings[] = wfMsgExt( 'configure-ext-ext-dependencies', array( 'parseinline' ), $wgLang->listToText( $this->mExtensionsDependencies ), count( $this->mExtensionsDependencies ) );
		}

		if ( count( $warnings ) ) {
			$ret .= "<span class=\"errorbox\">\n";
			if ( count( $warnings ) > 1 ) {
				$ret .= "<ul>\n<li>";
				$ret .= implode( "</li>\n<li>", $warnings );
				$ret .= "</li>\n</ul>";
			} else {
				$ret .= $warnings[0];
			}
			$ret .= "</span><br clear=\"left\" />\n";
		}

		$use = wfMsgExt( 'configure-ext-use', array( 'parseinline' ) );
		$ret .= "<h2>{$use}</h2>\n";
		$ret .= "<table class=\"configure-table configure-table-ext\"><tr><td>\n";
		$checkName = $this->getCheckName();
		$ret .= Xml::checkLabel( wfMsg( 'configure-ext-use-extension' ), $checkName, $checkName, $this->isActivated() );
		$ret .= "</td></tr>\n";
		if ( !empty( $this->mDoc ) ) {
			$ret .= "<tr><td>\n";
			$ret .= '<p>' . Xml::element( 'a', array( 'href' => $this->mDoc ), wfMsg( 'configure-ext-doc' ) ) . "</p>\n";
			$ret .= "</td></tr>";
		}
		$ret .= "</table>\n";
		if ( count( $this->mSettings ) ) {
			$settings = wfMsgExt( 'configure-ext-settings', array( 'parseinline' ) );
			$ret .= "<h2>{$settings}</h2>\n";
			$ret .= "<table class=\"configure-table\">\n";
			foreach ( $this->mSettings as $name => $type ) {
				$val = $this->mObj->getSettingValue( $name );
				$ret .= '<tr><td>$' . $name . '</td><td>' .
					call_user_func_array( array( $this->mObj, 'buildInput' ), array( $name, array( 'value' => $val, 'type' => $type ) ) ) .
					"</td></tr>\n";
			}
			$ret .= "</table>\n";
		}
		$ret .= "</fieldset>\n";
		return $ret;
	}

	/**
	 * Check for settings dependencies
	 *
	 * @return Boolean: Success
	 */
	public function checkSettingsDependencies() {
		if ( !$this->mObj instanceof ConfigurationPage )
			throw new MWException( 'WebExtension::checkSettingsDependencies() called without prior call to WebExtension::setPageObj()' );

		if ( !count( $this->mSettingsDependencies ) )
			return array();

		$ret = array();
		$conf = $this->mObj->getConf();
		foreach ( $this->mSettingsDependencies as $setting => $value ) {
			if ( array_key_exists( $setting, $conf ) )
				$actual = $conf[$setting];
			else
				$actual = $GLOBALS[$setting];
			 
			if ( $actual !== $value ) {
				$ret[] = array( $setting, $value, $actual );
			}
		}
		return $ret;
	}

	/**
	 * Whether the definition file can be included to get default values
	 *
	 * @return Boolean
	 */
	public function canIncludeFile() {
		if( !file_exists( $this->getFile() ) )
			return false;
		return !count( $this->checkSettingsDependencies() );
	}

	/**
	 * Return the name of the check that's used to select whether the extension
	 * should be activated
	 */
	public function getCheckName() {
 		if( $this->useVariable() )
 			return 'wp'.$this->mExtVar;
 		else
 			return 'wpUse'.str_replace( ' ', '_', $this->mName );
	}

  	/**
 	 * Whether this extension
 	 */
 	public function useVariable(){
 		return !is_null( $this->mExtVar );
 	}

 	/**
 	 * Get the variable for this extension
 	 */
 	public function getVariable(){
 		return $this->mExtVar;
 	}

	public function setTempActivated( $val = null ) {
		return wfSetVar( $this->mTempActivated, $val );
	}

	/**
	 * Is this extension activated?
	 *
	 * @return Boolean
	 */
	public function isActivated() {
		if( $this->mTempActivated !== null ) {
			return $this->mTempActivated;
		} else if( $this->useVariable() ) {
 			return isset( $GLOBALS[$this->getVariable()] ) && $GLOBALS[$this->getVariable()];
 		} else {
 			global $wgConf;
 			return in_array( $this->getFile(), $wgConf->getIncludedFiles() );
 		}
	}

	/**
	 * Is this extension installed so that it can be used?
	 *
	 * @return Boolean
	 */
	public function isInstalled() {
 		if( $this->useVariable() ) {
 			return true;
		}
 		global $wgConfigureOnlyUseVarForExt;
 		if( $wgConfigureOnlyUseVarForExt ) {
 			return false;
		}
		return file_exists( $this->getFile() );
	}
}
