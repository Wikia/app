<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Class that generate differences between two versions of wiki configuration
 *
 * @ingroup Extensions
 */
abstract class ConfigurationDiff {
	protected $diff;
	protected $version;
	protected $wikis;
	protected $callback = null;

	/**
	 * Constructor
	 *
	 * @param $diff String: old version
	 * @param $version String: new versions
	 * @param $wikis Array: array of wiki names
	 */
	public function __construct( $diff, $version, $wikis ){
		$this->diff = $diff;
		$this->version = $version;
		$this->wikis = $wikis;
	}

	/**
	 * Get the old configuration
	 * @return Array
	 */
	protected abstract function getOldVersion();

	/**
	 * Get the new configuration
	 * @return Array
	 */
	protected abstract function getNewVersion();

	/**
	 * Get as 3D array of settings
	 * @return array
	 */
	protected abstract function getSettings();

	/**
	 * Get the array type of $setting
	 *
	 * @param $setting setting name
	 * @return string
	 */
	protected abstract function getArrayType( $setting );

	/**
	 * Set a callback function that return a bool wheter a setting can be viewed
	 * by the current user
	 *
	 * @param $callback callback
	 * @return old callback
	 */
	public function setViewCallback( $callback ){
		$temp = $this->callback;
		if( is_callable( $callback ) )
			$this->callback = $callback;
		return $temp;
	}

	/**
	 * Can $setting be viewed by the current user?
	 *
	 * @param $setting String: setting name
	 * @return bool
	 */
	protected function isSettingViewable( $setting ){
		if( !is_callable( $this->callback ) )
			return true;

		return (bool)call_user_func_array( $this->callback, array( $setting ) );
	}

	/**
	 * Clean up configuration by removing unwanted wikis, and wikis that aren't
	 * either in $old or $new
	 *
	 * @param $old Array
	 * @param $new Array
	 * @return array of wikis names
	 */
	function cleanWikis( &$old, &$new ){
		$wikis = array();
		if( $this->wikis === true )
			$this->wikis = array_unique( array_merge( array_keys( $old ), array_keys( $new ) ) );
		foreach( $this->wikis as $wiki ){
			if( isset( $old[$wiki] ) && isset( $new[$wiki] ) )
				$wikis[] = $wiki;
		}

		if( !count( $wikis ) )
			return false;

		$old_ = array();
		$new_ = array();
		foreach( $wikis as $wiki ){
			$old_[$wiki] = $old[$wiki];
			$new_[$wiki] = $new[$wiki];
		}
		$old = $old_;
		$new = $new_;
		return $wikis;
	}

	/**
	 * Get the HTML of the diff
	 */
	function getHTML(){
		global $wgOut;
		if( is_callable( array( $wgOut, 'addStyle' ) ) ) # 1.11 +
			$wgOut->addStyle( 'common/diff.css' );
		$old = $this->getOldVersion();
		$new = $this->getNewVersion();
		if( !( $wikis = $this->cleanWikis( $old, $new ) ) ){
			return wfMsgExt( 'configure-no-diff', array( 'parse' ) );
		}
		$text = '';
		foreach( $wikis as $wiki ){
			$text .= '<h2>' . htmlspecialchars( $wiki ) . "</h2>\n";
			$text .= $this->processDiff( $old[$wiki], $new[$wiki] );
		}
		return $text;
	}

	/**
	 * Process a diff between to configuration
	 *
	 * @param $old Array
	 * @param $new Array
	 * @return String: XHTML
	 */
	function processDiff( $old, $new ){
		$text = '';
		$settings = $this->getSettings();
		foreach( $settings as $sectionName => $sectionGroups ){
			$sectionDiff = '';
			foreach( $sectionGroups as $groupName => $groupSettings ){
				$groupDiff = '';
				foreach( $groupSettings as $setting => $type ){
					$oldSetting = isset( $old[$setting] ) ? $old[$setting] : null;
					$newSetting = isset( $new[$setting] ) ? $new[$setting] : null;
					if( $oldSetting === $newSetting || !$this->isSettingViewable( $setting ) )
						continue;
					else
						$groupDiff .= $this->processDiffSetting( $setting, $oldSetting, $newSetting, $type ) . "\n";
				}
				if( $groupDiff != '' ){
					$name = wfMsgExt( 'configure-section-' . $groupName, array( 'parseinline' ) );
					if( wfEmptyMsg( 'configure-section-' . $groupName, $name ) )
						$name = $groupName;
					$sectionDiff .= "<tr><td colspan=\"4\"><h4 class=\"config-diff-group\">{$name}</h4></td></tr>\n";
					$sectionDiff .= $groupDiff;
				}
			}
			if( $sectionDiff != '' ){
				$name = wfMsgExt( 'configure-section-' . $sectionName, array( 'parseinline' ) );
				$text .= "<tr><td colspan=\"4\"><h3 class=\"config-diff-section\">{$name}</h3></td></tr>\n";
				$text .= $sectionDiff;
			}
		}

		if( empty( $text ) )
			return wfMsgExt( 'configure-no-diff', array( 'parse' ) );

		$ret = "<table class='diff'>\n";
		$ret .= "<col class='diff-marker' />";
		$ret .= "<col class='diff-content' />";
		$ret .= "<col class='diff-marker' />";
		$ret .= "<col class='diff-content' />";
		$ret .= $text;
		$ret .= "</table>";
		return $ret;
	}

	/**
	 * Process a diff for one setting
	 *
	 * @param $name String: setting name
	 * @patam $old Mixed: old value
	 * @param $new Mixed: new value
	 * @param $type String: setting type
	 * @return String: XHTML
	 */
	function processDiffSetting( $name, $old, $new, $type ){
		$oldSet = $this->getSettingAsArray( $old, $name, $type );
		$newSet = $this->getSettingAsArray( $new, $name, $type );
		$diffs = new Diff( $oldSet, $newSet );
		$formatter = new TableDiffFormatter();
		return "<tr><td class=\"diff-lineno configure-setting\" colspan=\"4\">\${$name}</td></tr>\n" .
			$formatter->format( $diffs );
	}

	/**
	 * Get an array representing the setting
	 *
	 * @param $setting Mixed: setting value
	 * @param $name String: setting name
	 * @param $type String: setting type
	 * @return Array
	 */
	function getSettingAsArray( $setting, $name, $type ){
		if( $setting === null ){
			$val = array();
		} else if( $type == 'array' ){
			$arrType = $this->getArrayType( $name );
			if( $arrType == 'simple' || $arrType == 'ns-simple' ){
				$val = array_values( $setting );
			} else if( $arrType == 'assoc' ){
				$arrVal = array();
				foreach( $setting as $key => $value ){
					$arrVal[] = "$key: $value";
				}
				$val = $arrVal;
			} else if( $arrType == 'simple-dual' ){
				$arrVal = array();
				foreach( $setting as $key => $value ){
					$arrVal[] = implode( ',', $value );
				}
				$val = $arrVal;
			} else if( $arrType == 'ns-bool' || $arrType == 'ns-text' || $arrType == 'ns-array' ){
				$arrVal = array();
				foreach( $setting as $key => $value ){
					if( $arrType == 'ns-bool' )
						$value = $value ? 'true' : 'false';
					if( $arrType == 'ns-array' )
						$value = is_array( $value ) ? implode( ',', $value ) : '';
					$arrVal[] = "$key: $value";
				}
				$val = $arrVal;
			} else if( $arrType == 'group-array' ){
				$arrVal = array();
				foreach( $setting as $key => $value ){
					$arrVal[] = "$key: " . implode( ',', $value );
				}
				$val = $arrVal;
			} else if( $arrType == 'group-bool' ){
				$arrVal = array();
				foreach( $setting as $key1 => $value1 ){
					foreach( $value1 as $key2 => $value2 ){
						$arrVal[] = "$key1, $key2: " . ( $value2 ? 'true' : 'false' );
					}
				}
				$val = $arrVal;
			} else {
				$val = explode( "\n", var_export( $setting, 1 ) );
			}
		} else if( $type == 'bool' ){
			$val = array( $setting ? 'true' : 'false' );
		} else {
			$val = explode( "\n", (string)$setting );
		}
		return $val;
	}
}

/**
 * Generate diff for preview in Special:Configure
 *
 * @ingroup Extensions
 */
class CorePreviewConfigurationDiff extends ConfigurationDiff {

	protected function getOldVersion(){
		return $this->diff;
	}

	protected function getNewVersion(){
		return $this->version;
	}

	protected function getSettings(){
		return ConfigurationSettings::singleton( CONF_SETTINGS_CORE )->getSettings();
	}

	protected function getArrayType( $setting ){
		return ConfigurationSettings::singleton( CONF_SETTINGS_CORE )->getArrayType( $setting );
	}
}

/**
 * Generate diff for preview in Special:Extensions
 *
 * @ingroup Extensions
 */
class ExtPreviewConfigurationDiff extends ConfigurationDiff {

	protected function getOldVersion(){
		return $this->diff;
	}

	protected function getNewVersion(){
		return $this->version;
	}

	protected function getSettings(){
		return ConfigurationSettings::singleton( CONF_SETTINGS_EXT )->getSettings();
	}

	protected function getArrayType( $setting ){
		return ConfigurationSettings::singleton( CONF_SETTINGS_EXT )->getArrayType( $setting );
	}
}

/**
 * Generate diff for history in Special:ViewConfig
 *
 * @ingroup Extensions
 */
class HistoryConfigurationDiff extends ConfigurationDiff {

	protected function getOldVersion(){
		global $wgConf;
		return $wgConf->getOldSettings( $this->diff );
	}

	protected function getNewVersion(){
		global $wgConf;
		return $wgConf->getOldSettings( $this->version );
	}

	protected function getSettings(){
		return ConfigurationSettings::singleton( CONF_SETTINGS_BOTH )->getSettings();
	}

	protected function getArrayType( $setting ){
		return ConfigurationSettings::singleton( CONF_SETTINGS_BOTH )->getArrayType( $setting );
	}
}