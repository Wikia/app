<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Class that represent an extension
 *
 * @ingroup Extensions
 */
class WebExtension {
	protected $mSettings;
	protected $mName;
	protected $mDbChange;
	protected $mInputCallback = null;
	protected $mDir;
	protected $mFile;
	protected $mDoc;

	/**
	 * Construct a new object.
	 *
	 * @param array $conf
	 */
	public function __construct( $conf ){
		$this->mName = $conf['name'];
		$this->mSettings = isset( $conf['settings'] ) ? $conf['settings'] : array();
		$this->mDbChange = isset( $conf['schema'] ) && $conf['schema'];
		$this->mDir = isset( $conf['dir'] ) ? $conf['dir'] : $conf['name'];
		$this->mFile = isset( $conf['file'] ) ? $conf['file'] : $conf['name'] . '.php' ;
		$this->mArrays = isset( $conf['array'] ) ? $conf['array'] : array();
		$this->mDoc = isset( $conf['url'] ) ? $conf['url'] : null;
	}

	/**
	 * Get the name of the extension
	 *
	 * @return string
	 */
	public function getName(){
		return $this->mName;	
	}

	/**
	 * Get the settings name used by this extension
	 *
	 * @return array
	 */
	public function getSettings(){
		return $this->mSettings;
	}

	/**
	 * Get the array definitions of this extension
	 *
	 * @return array
	 */
	public function getArrayDefs(){
		return $this->mArrays;
	}

	/**
	 * Set a special page object used to generate an input
	 *
	 * @param $callback callback
	 */
	public function setPageObj( ConfigurationPage $obj ){
		$this->mObj = $obj;
	}

	/**
	 * Get the main file (the one that should be included in LocalSettings.php)
	 *
	 * @return string
	 */
	public function getFile(){
		global $IP;
		return $IP . '/extensions/' . $this->mDir . '/' . $this->mFile;
	}

	/**
	 * Generate html to configure this extension
	 *
	 * @return XHTML
	 */
	public function getHtml(){
		if( !$this->isInstalled() )
			return '';
		$ret = '<fieldset><legend>' . htmlspecialchars( $this->mName ) . '</legend>';
		if( $this->mDbChange ){
			$warn = wfMsgExt( 'configure-ext-schemachange', array( 'parseinline' ) );
			$ret .= "<span class=\"errorbox\">{$warn}</span><br clear=\"left\" />\n";
		}
		$use = wfMsgExt( 'configure-ext-use', array( 'parseinline' ) );
		$ret .= "<h2>{$use}</h2>\n";
		$ret .= "<table><tr><td>\n";
		$checkName = $this->getCheckName();
		$ret .= Xml::checkLabel( wfMsg( 'configure-ext-use-extension' ), $checkName, $checkName, $this->isActivated() );
		$ret .= "</td></tr>\n";
		if( !empty( $this->mDoc ) ){
			$ret .= "<tr><td>\n";
			$ret .= '<p>'.Xml::element( 'a', array( 'href' => $this->mDoc ), wfMsg( 'configure-ext-doc' ) ) . "</p>\n";
			$ret .= "</td></tr>";
		}
		$ret .= "</table>\n";
		if( count( $this->mSettings ) ){
			$settings = wfMsgExt( 'configure-ext-settings', array( 'parseinline' ) );
			$ret .= "<h2>{$settings}</h2>\n";
			$ret .= "<table>\n";
			foreach( $this->mSettings as $name => $type ){
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
	public function getCheckName(){
		return 'wpUse'.$this->mName;
	}
	
	/**
	 * Is this extension activated?
	 *
	 * @return bool
	 */
	public function isActivated(){
		global $wgConf;
		return in_array( $this->getFile(), $wgConf->getIncludedFiles() );	
	}
	
	/**
	 * Is this extension installed so that it can be used?
	 *
	 * @return bool
	 */
	public function isInstalled(){
		return file_exists( $this->getFile() );
	}
}
