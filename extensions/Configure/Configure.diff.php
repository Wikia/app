<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Class that generate differences between two versions of wiki configuration
 *
 * @ingroup Extensions
 */
abstract class ConfigurationDiff extends ContextSource {
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
	public function __construct( $context, $diff, $version, $wikis ) {
		$this->setContext( $context );
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
	public function setViewCallback( $callback ) {
		$temp = $this->callback;
		if ( is_callable( $callback ) )
			$this->callback = $callback;
		return $temp;
	}

	/**
	 * Can $setting be viewed by the current user?
	 *
	 * @param $setting String: setting name
	 * @return bool
	 */
	protected function isSettingViewable( $setting ) {
		if ( !is_callable( $this->callback ) )
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
	function cleanWikis( &$old, &$new ) {
		$wikis = array();
		if ( $this->wikis === true )
			$this->wikis = array_unique( array_merge( array_keys( $old ), array_keys( $new ) ) );
		foreach ( $this->wikis as $wiki ) {
			if ( isset( $old[$wiki] ) && isset( $new[$wiki] ) )
				$wikis[] = $wiki;
		}

		if ( !count( $wikis ) )
			return false;

		$old_ = array();
		$new_ = array();
		foreach ( $wikis as $wiki ) {
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
	function getHTML() {
		$this->getOutput()->addStyle( 'common/diff.css' );
		$old = $this->getOldVersion();
		$new = $this->getNewVersion();
		if ( !( $wikis = $this->cleanWikis( $old, $new ) ) ) {
			return $this->msg( 'configure-no-diff' )->parseAsBlock();
		}
		$text = '';
		foreach ( $wikis as $wiki ) {
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
	function processDiff( $old, $new ) {
		$text = '';
		$settings = $this->getSettings();
		foreach ( $settings as $sectionName => $sectionGroups ) {
			$sectionDiff = '';
			foreach ( $sectionGroups as $groupName => $groupSettings ) {
				$groupDiff = '';
				foreach ( $groupSettings as $setting => $type ) {
					$oldSetting = isset( $old[$setting] ) ? $old[$setting] : null;
					$newSetting = isset( $new[$setting] ) ? $new[$setting] : null;
					if ( $oldSetting === $newSetting || !$this->isSettingViewable( $setting ) ) {
						continue;
					}
					else
						$groupDiff .= $this->processDiffSetting( $setting, $oldSetting, $newSetting, $type ) . "\n";
				}
				if ( $groupDiff != '' ) {
					$msg = $this->msg( 'configure-section-' . $groupName );
					if ( $msg->exists() ) {
						$name = $msg->parse();
					} else {
						$name = $groupName;
					}
					$sectionDiff .= "<tr><td colspan=\"4\"><h4 class=\"config-diff-group\">{$name}</h4></td></tr>\n";
					$sectionDiff .= $groupDiff;
				}
			}
			if ( $sectionDiff != '' ) {
				$name = $this->msg( 'configure-section-' . $sectionName )->parse();
				$text .= "<tr><td colspan=\"4\"><h3 class=\"config-diff-section\">{$name}</h3></td></tr>\n";
				$text .= $sectionDiff;
			}
		}

		if ( empty( $text ) )
			return $this->msg( 'configure-no-diff' )->parseAsBlock();

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
	function processDiffSetting( $name, $old, $new, $type ) {
		$msg = $this->msg( 'configure-setting-' . $name );
		$rawVal = Xml::element( 'tt', null, "\$$name" );
		if ( $msg->exists() ) {
			$msgVal = $msg->parse() . " ($rawVal)";
		} else {
			$msgVal = $rawVal;
		}

		$oldSet = $this->getSettingAsArray( WebConfiguration::filterVar( $old ), $name, $type );
		$newSet = $this->getSettingAsArray( WebConfiguration::filterVar( $new ), $name, $type );
		$diffs = new Diff( $oldSet, $newSet );
		$formatter = new TableDiffFormatter();

		return "<tr><td class=\"diff-lineno configure-setting\" colspan=\"4\">{$msgVal}</td></tr>\n" .
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
	function getSettingAsArray( $setting, $name, $type ) {
		if ( $setting === null ) {
			$val = array();
		} elseif ( $type == 'array' ) {
			if( !is_array( $setting ) )
				return array();
			$arrType = $this->getArrayType( $name );
			if ( $arrType == 'simple' || $arrType == 'ns-simple' ) {
				$val = array_values( $setting );
			} elseif ( $arrType == 'assoc' ) {
				$arrVal = array();
				foreach ( $setting as $key => $value ) {
					$arrVal[] = "$key: $value";
				}
				$val = $arrVal;
			} elseif ( $arrType == 'simple-dual' ) {
				$arrVal = array();
				foreach ( $setting as $key => $value ) {
					$arrVal[] = implode( ',', $value );
				}
				$val = $arrVal;
			} elseif ( $arrType == 'ns-bool' || $arrType == 'ns-text' || $arrType == 'ns-array' ) {
				$arrVal = array();
				foreach ( $setting as $key => $value ) {
					if ( $arrType == 'ns-bool' )
						$value = $value ? 'true' : 'false';
					if ( $arrType == 'ns-array' )
						$value = is_array( $value ) ? implode( ',', $value ) : '';
					$arrVal[] = "$key: $value";
				}
				$val = $arrVal;
			} elseif ( $arrType == 'group-array' ) {
				$arrVal = array();
				foreach ( $setting as $key => $value ) {
					$arrVal[] = "$key: " . implode( ',', $value );
				}
				$val = $arrVal;
			} elseif ( $arrType == 'group-bool' ) {
				$arrVal = array();
				ksort($setting);
				foreach ( $setting as $key1 => $value1 ) {
					ksort($value1);
					foreach ( $value1 as $key2 => $value2 ) {
						if ($value2) // Only show 'true's
							$arrVal[] = "$key1, $key2: " . 'true';
					}
				}
				$val = $arrVal;
			} elseif ( $arrType == 'rate-limits' ) {
				$val = array();
				## Just walk the tree and print out the data.
				foreach( $setting as $action => $limits ) {
					foreach( $limits as $group => $limit ) {
						if (is_array($limit) && count($limit) == 2) { // Only show set limits
							list( $count, $period ) = $limit;
							if ($count == 0 || $period == 0)
								continue;

							$val[] = "$action, $group: " . $this->msg( 'configure-throttle-summary', $count, $period )->text();
						}
					}
				}
			} elseif ( $arrType == 'promotion-conds' ) {
				## For each group, print out the full conditions.
				$val = array();

				$opToName = array_flip( array( 'or' => '|', 'and' => '&', 'xor' => '^', 'not' => '!' ) );
				$validOps = array_keys( $opToName );

				foreach( $setting as $group => $conds ) {
					if ( !is_array( $conds ) ) {
						$val[] = "$group: ".$this->msg( "configure-condition-description-$conds" )->text();
						continue;
					}
					if ( count( $conds ) == 0 ) {
						$val[] = "$group: ".$this->msg( 'configure-autopromote-noconds' )->text();
						continue;
					}

					if ( count( $conds ) > 1 && in_array( $conds[0], $validOps ) ) {
						$boolop = array_shift( $conds );
						$boolop = $opToName[$boolop];

						$val[] = "$group: " . $this->msg( "configure-boolop-description-$boolop" )->text();
					} else {
						$conds = array( $conds );
					}

					// Analyse each individual one...
					foreach( $conds as $cond ) {
						if ($cond == array( APCOND_AGE, -1 ) ) {
							$val[] = "$group: " . $this->msg( 'configure-autopromote-noconds' )->text();
							continue;
						}

						if( !is_array( $cond ) ) {
							$cond = array( $cond );
						}
						$name = array_shift( $cond );


						$argSummary = implode( ', ', $cond );
						$count = count( $cond );

						$val[] = "$group: ".$this->msg( "configure-condition-description-$name", $argSummary, $count )->text();
					}
				}
			} else {
				$val = explode( "\n", var_export( $setting, 1 ) );
			}
		} elseif ( $type == 'bool' ) {
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

	protected function getOldVersion() {
		return $this->diff;
	}

	protected function getNewVersion() {
		return $this->version;
	}

	protected function getSettings() {
		return ConfigurationSettings::singleton( CONF_SETTINGS_CORE )->getSettings();
	}

	protected function getArrayType( $setting ) {
		return ConfigurationSettings::singleton( CONF_SETTINGS_CORE )->getArrayType( $setting );
	}
}

/**
 * Generate diff for preview in Special:Extensions
 *
 * @ingroup Extensions
 */
class ExtPreviewConfigurationDiff extends ConfigurationDiff {

	protected function getOldVersion() {
		return $this->diff;
	}

	protected function getNewVersion() {
		return $this->version;
	}

	protected function getSettings() {
		return ConfigurationSettings::singleton( CONF_SETTINGS_EXT )->getSettings();
	}

	protected function getArrayType( $setting ) {
		return ConfigurationSettings::singleton( CONF_SETTINGS_EXT )->getArrayType( $setting );
	}
}

/**
 * Generate diff for history in Special:ViewConfig
 *
 * @ingroup Extensions
 */
class HistoryConfigurationDiff extends ConfigurationDiff {

	protected function getOldVersion() {
		global $wgConf;

		$settings = $wgConf->getOldSettings( $this->diff );

		if ($this->diff == 'default') { ## Special case: Replicate settings across all wikis for a fair comparison.
			$new = $this->getNewVersion();

			$defaultSettings = array();

			## This is kinda annoying. We can't copy ALL settings over, because not all settings are stored.
			foreach( $new as $wiki => $newSettings ) {
				if ($wiki == '__metadata') ## Ignore metadata.
					continue;

				$defaultSettings[$wiki] = array();

				foreach( $newSettings as $key => $value ) {
					if (isset($settings['default'][$key]))
						$defaultSettings[$wiki][$key] = $settings['default'][$key];
				}
			}

			$settings = $defaultSettings;
		}

		return $settings;
	}

	protected function getNewVersion() {
		global $wgConf;
		$settings = $wgConf->getOldSettings( $this->version );
		return $settings;
	}

	protected function getSettings() {
		return ConfigurationSettings::singleton( CONF_SETTINGS_BOTH )->getSettings();
	}

	protected function getArrayType( $setting ) {
		return ConfigurationSettings::singleton( CONF_SETTINGS_BOTH )->getArrayType( $setting );
	}
}
