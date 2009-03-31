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
	protected $mInputCallback = null;
	protected $mDir;
	protected $mFile;
	protected $mDoc;
	protected $mExtVar = null;

	/**
	 * Construct a new object.
	 *
	 * @param array $conf
	 */
	public function __construct( /*array*/ $conf ) {
		global $wgConfigureExtensionsVar;

		$this->mName = $conf['name'];
		$this->mSettings = isset( $conf['settings'] ) ? $conf['settings'] : array();
		$this->mDbChange = isset( $conf['schema'] ) && $conf['schema'];
		$this->mDir = isset( $conf['dir'] ) ? $conf['dir'] : $conf['name'];
		$this->mFile = isset( $conf['file'] ) ? $conf['file'] : $conf['name'] . '.php' ;
		$this->mArrays = isset( $conf['array'] ) ? $conf['array'] : array();
		$this->mEmptyValues = isset( $conf['empty'] ) ? $conf['empty'] : array();
		$this->mViewRestricted = isset( $conf['view-restricted'] ) ? $conf['view-restricted'] : array();
		$this->mEditRestricted = isset( $conf['edit-restricted'] ) ? $conf['edit-restricted'] : array();
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
	 * Generate html to configure this extension
	 *
	 * @return XHTML
	 */
	public function getHtml() {
		if ( !$this->isInstalled() )
			return '';
		$ret = '<fieldset><legend>' . htmlspecialchars( $this->mName ) . '</legend>';
		if ( $this->mDbChange ) {
			$warn = wfMsgExt( 'configure-ext-schemachange', array( 'parseinline' ) );
			$ret .= "<span class=\"errorbox\">{$warn}</span><br clear=\"left\" />\n";
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
	 * Return the name of the check that's used to select whether the extension
	 * should be activated
	 */
	public function getCheckName() {
 		if( $this->useVariable() )
 			return 'wp'.$this->mExtVar;
 		else
 			return 'wpUse'.$this->mName;
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

	/**
	 * Is this extension activated?
	 *
	 * @return bool
	 */
	public function isActivated() {
		if( $this->useVariable() ) {
 			return isset( $GLOBALS[$this->getVariable()] ) && $GLOBALS[$this->getVariable()];
 		} else {
 			global $wgConf;
 			return in_array( $this->getFile(), $wgConf->getIncludedFiles() );
 		}
	}

	/**
	 * Is this extension installed so that it can be used?
	 *
	 * @return bool
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
