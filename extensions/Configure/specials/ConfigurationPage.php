<?php

/**
 * Special page allows authorised users to configure the wiki
 *
 * @ingroup Extensions
 */
abstract class ConfigurationPage extends SpecialPage {
	protected $mCanEdit = true;
	protected $conf;
	protected $mConfSettings;
	protected $mIsPreview = false;

	/**
	 * Constructor
	 */
	public function __construct( $name, $right ) {
		$this->mConfSettings = ConfigurationSettings::singleton( $this->getSettingMask() );
		# Reload data WITHOUT CACHE
		global $wgConf;
		$wgConf->initialise( false /* Skip cache */ );
		parent::__construct( $name, $right );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgConf, $wgConfigureWikis;

		$this->setHeaders();

		$user = $this->getUser();
		if ( !$this->userCanExecute( $user ) ) {
			$this->displayRestrictionError();
			return;
		}

		// Since efConfigureSetup() should be explicitly called, don't go
		// further if that function wasn't called
		if ( !$wgConf instanceof WebConfiguration ) {
			$this->getOutput()->wrapWikiMsg( '<div class="errorbox"><strong>$1</strong></div>', 'configure-no-setup' );
			return;
		}

		$ret = $wgConf->doChecks();
		if ( count( $ret ) ) {
			$this->getOutput()->wrapWikiMsg( '<div class="errorbox"><strong>$1</strong></div>', $ret );
			return;
		}

		$request = $this->getRequest();
		$wikiParam = ( $this->mCanEdit && $request->wasPosted() ) ? 'wpWiki' : 'wiki';
		if ( $wiki = $request->getVal( $wikiParam, false ) ) {
			if ( $wgConf->getWiki() != $wiki ) {
				if ( !$this->isUserAllowedInterwiki() || $wgConfigureWikis === false ) {
					$this->getOutput()->wrapWikiMsg( '<div class="errorbox"><strong>$1</strong></div>', 'configure-no-transwiki' );
					return;
				}
				if ( is_array( $wgConfigureWikis ) && !in_array( $wiki, $wgConfigureWikis ) ) {
					$this->getOutput()->wrapWikiMsg( '<div class="errorbox"><strong>$1</strong></div>',
						array( 'configure-transwiki-not-in-range', $wiki, $this->getLang()->commaList( $wgConfigureWikis ), count( $wgConfigureWikis ) ) );
					return;
				}
			}
			$this->mWiki = $wiki;
		} else {
			$this->mWiki = $wgConf->getWiki();
		}

		$this->outputHeader();

		if ( !$this->getVersion() )
			return;

		if ( $this->mCanEdit && $request->wasPosted() ) {
			if ( $user->matchEditToken( $request->getVal( 'wpEditToken' ) ) ) {
				if ( $request->getCheck( 'wpSave' ) ) {
					$type = 'submit';
				} else {
					$type = 'diff';
				}
			} else {
				$this->getOutput()->addWikiMsg( 'sessionfailure' );
				$type = 'diff';
			}
		} else {
			$type = 'initial';
		}

		if ( $result = $request->getVal( 'result' ) ) {
			$this->showResult( $result );
			return;
		}

		switch( $type ) {
		case 'submit':
			if( $user->matchEditToken( $request->getVal( 'wpEditToken' ) ) )
				$this->doSubmit();
			else
				$this->showForm();
			break;
		case 'diff':
			$this->conf = $this->importFromRequest() + $this->conf;
			$this->mIsPreview = true;
			$this->showDiff();
		case 'initial':
		default:
			$this->showForm();
			break;
		}
	}

	/**
	 * Retrieve the value of $setting
	 * @param $setting String: setting name
	 * @return mixed value of $setting
	 */
	protected function getSettingValue( $setting ) {
		static $defaults;

		if ( !$defaults ) {
			global $wgConf;
			$defaults = $wgConf->getDefaultsForWiki( $this->mWiki );
		}

		if ( isset( $this->conf[$setting] ) ) {
			return $this->conf[$setting];
		} else {
			return isset( $defaults[$setting] ) ? $defaults[$setting] : null;
		}
	}

	/**
	 * Return true if the current user is allowed to configure all settings.
	 * @return bool
	 */
	protected function isUserAllowedAll() {
		static $allowed = null;
		if ( $allowed === null ) {
			$allowed = $this->getUser()->isAllowed( $this->getRestriction() . '-all' );
		}
		return $allowed;
	}

	/**
	 * Return true if the current user is allowed to configure all settings.
	 * @return bool
	 */
	protected function isUserAllowedInterwiki() {
		static $allowed = null;
		if ( $allowed === null ) {
			$allowed = $this->getUser()->isAllowed( $this->getRestriction() . '-interwiki' );
		}
		return $allowed;
	}

	/**
	 * Accessor for $this->conf
	 *
	 * @return array
	 */
	public function getConf() {
		return $this->conf;
	}

	/**
	 * Return true if the current user is allowed to configure $setting.
	 * @return bool
	 */
	public function userCanEdit( $setting ) {
		if ( !$this->mCanEdit || !$this->userCanRead( $setting ) )
			return false;
		if ( in_array( $setting, $this->mConfSettings->getEditRestricted() ) && !$this->isUserAllowedAll() )
			return false;
		global $wgConfigureEditRestrictions;
		if ( !isset( $wgConfigureEditRestrictions[$setting] ) )
			return true;
		foreach ( $wgConfigureEditRestrictions[$setting] as $right ) {
			if ( !$this->getUser()->isAllowed( $right ) )
				return false;
		}
		return true;
	}

	/**
	 * Return true if the current user is allowed to see $setting.
	 * @return bool
	 */
	public function userCanRead( $setting ) {
		if ( in_array( $setting, $this->mConfSettings->getUneditableSettings() )
			|| ( in_array( $setting, $this->mConfSettings->getViewRestricted() )
			&& !$this->isUserAllowedAll() ) )
			return false;
		global $wgConfigureViewRestrictions;
		if ( !isset( $wgConfigureViewRestrictions[$setting] ) )
			return true;
		foreach ( $wgConfigureViewRestrictions[$setting] as $right ) {
			if ( !$this->getUser()->isAllowed( $right ) )
				return false;
		}
		return true;
	}

	/**
	 * Get an 3D array of all settings
	 *
	 * @return array
	 */
	protected function getSettings() {
		return $this->mConfSettings->getSettings();
	}

	/**
	 * Get a list of editable settings
	 *
	 * @return array
	 */
	protected function getUneditableSettings() {
		return $this->mConfSettings->getUneditableSettings();
	}

	/**
	 * Get a list of editable settings
	 *
	 * @return array
	 */
	protected function getEditableSettings() {
		return $this->mConfSettings->getEditableSettings();
	}

	/**
	 * Get the type of a setting
	 *
	 * @patam $setting setting name
	 * @return string
	 */
	protected function getSettingType( $setting ) {
		return $this->mConfSettings->getSettingType( $setting );
	}

	/**
	 * Get the array type of a setting
	 *
	 * @patam $setting setting name
	 * @return string
	 */
	protected function getArrayType( $setting ) {
		return $this->mConfSettings->getArrayType( $setting );
	}

	/**
	 * Is $setting available in this MediaWiki version?
	 *
	 * @param $setting setting name
	 * @return bool
	 */
	protected function isSettingAvailable( $setting ) {
		return $this->mConfSettings->isSettingAvailable( $setting );
	}

	/**
	 * Get the mask to be passed to $this->mConfSettings->*
	 */
	protected abstract function getSettingMask();

	// Page things

	/**
	 * Submit the posted request
	 */
	protected abstract function doSubmit();

	/**
	 * Show the diff between the current version and the posted version
	 */
	protected abstract function showDiff();

	/**
	 * Show a 'success' page.
	 */
	protected function showResult( $result ) {
		$ok = $result == 'success';
		$msg = $ok ? 'configure-saved' : 'configure-error';
		$class = $ok ? 'successbox' : 'errorbox';

		$out = $this->getOutput();
		$out->wrapWikiMsg( Html::rawElement( 'div', array( 'class' => $class ), '$1' ), $msg );

		$out->addHTML( Html::rawElement( 'p', array( 'style' => 'clear:both;' ),
			Linker::link( $this->getTitle(), $this->msg( 'configure-backlink' )->parse() ) ) );
	}

	/**
	 * Build the content of the form
	 *
	 * @return xhtml
	 */
	protected abstract function buildAllSettings();

	/**
	 * Show "you are editing old version" message
	 */
	protected function showOldVersionMessage( $version ) {
		$lang = $this->getLang();
		$this->getOutput()->addWikiMsg( 'configure-edit-old',
			$lang->timeanddate( $version ),
			$lang->date( $version ),
			$lang->time( $version )
		);
	}

	/**
	 * Get the version
	 */
	protected function getVersion() {
		global $wgConf;

		$request = $this->getRequest();
		if ( $version = $request->getVal( 'version' ) ) {
			if ( $version == 'default' || $wgConf->versionExists( $version ) ) {
				if ( $version == 'default' ) { ## Hacky special case.
					$this->conf = $wgConf->getDefaultsForWiki( $this->mWiki );
				} else {
					$conf = $wgConf->getOldSettings( $version );

					if ( !isset( $conf[$this->mWiki] ) ) {
						$this->getOutput()->wrapWikiMsg( '<div class="errorbox">$1</div>',
							array( 'configure-old-not-available', $version ) );
						return false;
					}
					$this->conf = $conf[$this->mWiki];
				}

				$current = null;
				foreach ( $this->conf as $name => $value ) {
					if ( $this->canBeMerged( $name, $value ) ) {
						if ( is_null( $current ) )
							$current = $wgConf->getCurrent( $this->mWiki );
						if( isset( $current[$name] ) && is_array( $current[$name] ) )
							$this->conf[$name] += $current[$name];
					}
				}

				if ( !$this->showOldVersionMessage( $version ) )
					return false;
			} else {
				$this->getOutput()->wrapWikiMsg( '<div class="errorbox">$1</div>',
					array( 'configure-old-not-available', $version ) );
				return false;
			}
		} elseif ( $this->mCanEdit ) {
			$this->conf = $wgConf->getCurrent( $this->mWiki );
		}
		return true;
	}

	/**
	 * Build links to old version of the configuration
	 */
	protected function buildOldVersionSelect() {
		global $wgConf;

		$count = 0;
		$links = array();

		$versions = $wgConf->getArchiveVersions( array( 'wiki' => $this->mWiki, 'limit' => 11 ) );
		$title = $this->getTitle();
		$lang = $this->getLang();
		$prev = null;

		ksort( $versions ); ## Put in ascending order for now.

		foreach ( $versions as $data ) {
			$ts = $data['timestamp'];
			$count++;
			$datetime = $this->msg( 'configure-old-summary-datetime',
				$lang->timeanddate( $ts ),
				$lang->date( $ts ),
				$lang->time( $ts )
			)->escaped();
			$link = Linker::linkKnown( $title, $datetime, array(), array( 'version' => $ts ) );
			$diffLink = '';
			if ( $prev ) {
				$diffLink =  '(' . Linker::linkKnown( SpecialPage::getTitleFor( 'ViewConfig' ),
					$this->msg( 'configure-old-changes' )->escaped(), array(), array( 'version' => $ts, 'diff' => $prev ) ) . ')';
			}

			## Make user link...
			$userLink = '';
			if( !$data['userwiki'] || !$data['username'] ) {
				$userLink = '';
				$username = '';
			} elseif ( $data['userwiki'] == wfWikiId() ) {
				$userLink = Linker::link( Title::makeTitle( NS_USER, $data['username'] ), htmlspecialchars( $data['username'] ) );
				$username = $data['username'];
			} elseif ( $wiki = WikiMap::getWiki( $data['userwiki'] ) ) {
				$userLink = Linker::makeExternalLink( $wiki->getUrl( 'User:'.$data['username'] ), htmlspecialchars( $data['username'].'@'.$data['userwiki'] ) );
				$username = '';
			} else {
				## Last-ditch
				$userLink = htmlspecialchars( $data['username'].'@'.$data['userwiki'] );
				$username = '';
			}

			$comment = $data['reason'] ? Linker::commentBlock( $data['reason'] ) : '';

			$text = $this->msg( 'configure-old-summary' )->rawParams( $link, $userLink, $diffLink, $comment )->params( $username )->parse();

			$prev = $ts;

			$links[] = $text;
		}

		## Reset into descending order
		$links = array_reverse( $links );
		## Take out the first ten...
		$links = array_slice( $links, 0, 10 );

		$text = Html::element( 'legend', null, $this->msg( 'configure-old' )->text() );
		if ( !count( $links ) ) {
			$text .= $this->msg( 'configure-no-old' )->parseAsBlock();
		} else {
			$text .= $this->msg( 'configure-old-versions' )->parseAsBlock();
			$text .= "<ul>\n<li>";
			$text .= implode( "</li>\n<li>", $links );
			$text .= "</li>\n</ul>\n";
		}
		$link = SpecialPage::getTitleFor( 'ViewConfig' );
		$text .= Html::rawElement( 'p', null, Linker::linkKnown( $link, $this->msg( 'configure-view-all-versions' )->escaped() ) );
		$text .= Html::rawElement( 'p', null, Linker::linkKnown( $link, $this->msg( 'configure-view-default' )->escaped(), array(), array( 'version' => 'default' ) ) );

		return Html::rawElement( 'fieldset', null, $text );
	}

	/**
	 * Get a form to select the wiki to configure
	 */
	protected function getWikiSelectForm() {
		global $wgConfigureWikis, $wgScript;
		if ( $wgConfigureWikis === false || !$this->isUserAllowedInterwiki() )
			return '';
		$form = Html::element( 'legend', null, $this->msg( 'configure-select-wiki' )->text() );
		$form .= $this->msg( 'configure-select-wiki-desc' )->parseAsBlock();
		$form .= Html::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) );
		$form .= Html::hidden( 'title', $this->getTitle()->getPrefixedDBkey() );
		if ( is_array( $wgConfigureWikis ) ) {
			$selector = new XmlSelect( 'wiki', 'wiki', $this->mWiki );
			foreach( $wgConfigureWikis as $wiki ) {
				$selector->addOption( $wiki );
			}
			$form .= $selector->getHTML() . '&#160;';
		} else {
			$form .= Html::input( 'wiki', $this->mWiki, 'text' ) . '&#160;';
		}
		$form .= Html::input( null, $this->msg( 'configure-select-wiki-submit' )->text(), 'submit' );
		$form .= Html::closeElement( 'form' );
		return Html::rawElement( 'fieldset', null, $form );
	}

	/**
	 * Import settings from posted datas
	 *
	 * @return array
	 */
	protected function importFromRequest() {
		global $wgContLang;

		$request = $this->getRequest();
		if ( !$this->mCanEdit || !$request->wasPosted() )
			return array();

		$settings = array();
		foreach ( $this->getEditableSettings() as $name => $type ) {
			if ( !$this->mConfSettings->isSettingAvailable( $name ) )
				continue;
			if ( !$this->userCanEdit( $name ) ) {
				$settings[$name] = $this->getSettingValue( $name );
				continue;
			}
			switch( $type ) {
			case 'array':
				$arrType = $this->getArrayType( $name );
				switch( $arrType ) {
				case 'simple':
					$text = rtrim( $request->getText( 'wp' . $name ) );
					if ( $text == '' )
						$arr = array();
					else
						$arr = explode( "\n", $text );
					$settings[$name] = $arr;
					break;
				case 'assoc':
					$i = 0;
					$arr = array();
					while ( isset( $_REQUEST['wp' . $name . '-key-' . $i] ) &&
						isset( $_REQUEST['wp' . $name . '-val-' . $i] ) )
					{
						$key = $_REQUEST['wp' . $name . '-key-' . $i];
						$val = $_REQUEST['wp' . $name . '-val-' . $i];
						if ( $key !== '' || $val !== '' )
							$arr[$key] = $val;
						$i++;
					}
					$settings[$name] = $arr;
					break;
				case 'simple-dual':
					$text = $request->getText( 'wp' . $name );
					if ( $text == '' ) {
						$arr = array();
					} else {
						$arr = array();
						foreach ( explode( "\n", $text ) as $line ) {
							$items = array_map( 'intval', array_map( 'trim', explode( ',', $line ) ) );
							if ( count( $items == 2 ) )
								$arr[] = $items;
						}
					}
					$settings[$name] = $arr;
					break;
				case 'ns-bool':
					$arr = array();
					foreach ( $wgContLang->getNamespaces() as $ns => $unused ) {
						$arr[$ns] = $request->getCheck( 'wp' . $name . '-ns' . strval( $ns ) );
					}
					$settings[$name] = $arr;
					break;
				case 'ns-text':
					$arr = array();
					foreach ( $wgContLang->getNamespaces() as $ns => $unused ) {
						$arr[$ns] = $request->getVal( 'wp' . $name . '-ns' . strval( $ns ) );
					}
					$settings[$name] = $arr;
					break;
				case 'ns-simple':
					$arr = array();
					foreach ( $wgContLang->getNamespaces() as $ns => $unused ) {
						if ( $request->getCheck( 'wp' . $name . '-ns' . strval( $ns ) ) )
							$arr[] = $ns;
					}
					$settings[$name] = $arr;
					break;
				case 'ns-array':
					$arr = array();
					foreach ( $wgContLang->getNamespaces() as $ns => $unused ) {
						if ( $ns < 0 )
							continue;
						$text = rtrim( $request->getText( 'wp' . $name . '-ns' . strval( $ns ) ) );
						if ( $text == '' )
							$nsProtection = array();
						else
							$nsProtection = explode( "\n", $text );
						$arr[$ns] = $nsProtection;
					}
					$settings[$name] = $arr;
					break;
				case 'group-bool':
				case 'group-array':
					$all = array();
					if ( isset( $_REQUEST['wp' . $name . '-vals'] ) ) {
						$iter = explode( "\n", trim( $request->getText( 'wp' . $name . '-vals' ) ) );
						foreach ( $iter as &$group ) {
							// Our own Sanitizer::unescapeId() :)
							$group = urldecode( str_replace( array( '.', "\r" ), array( '%', '' ),
								substr( $group, strlen( $name ) + 3 ) ) );
						}
						unset( $group ); // Unset the reference, just in case
					} else { // No javascript ?
						$iter = array_keys( $this->getSettingValue( 'wgGroupPermissions' ) );
					}
					if ( $arrType == 'group-bool' ) {
						$all = User::getAllRights();
					} else {
						$all = array_diff( $iter, $this->getSettingValue( 'wgImplicitGroups' ) );
					}
					foreach ( $iter as $group ) {
						foreach ( $all as $right ) {
							$id = 'wp' . $name . '-' . $group . '-' . $right;
							if ( $arrType == 'group-bool' ) {
								$encId = Sanitizer::escapeId( $id );
								if ( $id != $encId ) {
									$val = $request->getCheck( str_replace( '.', '_', $encId ) ) ||
										$request->getCheck( $encId ) || $request->getCheck( $id );
								} else {
									$val = $request->getCheck( $id );
								}
								if ( $val )
									$settings[$name][$group][$right] = true;
							} elseif ( $request->getCheck( $id ) ) {
								$settings[$name][$group][] = $right;
							}
						}
					}

					break;
				case 'rate-limits':
					$all = array();
					## TODO put this stuff in a central place.
					$validActions = array( 'edit', 'move', 'mailpassword', 'emailuser', 'rollback' );
					$validGroups = array( 'anon', 'user', 'newbie', 'ip', 'subnet' );

					foreach( $validActions as $action ) {
						$all[$action] = array();
						foreach( $validGroups as $group ) {
							$count = $request->getIntOrNull( "wp$name-key-$action-$group-count" );
							$period = $request->getIntOrNull( "wp$name-key-$action-$group-period" );

							if ($count && $period) {
								$all[$action][$group] = array( $count, $period );
							} else {
								$all[$action][$group] = null;
							}
						}
					}

					$settings[$name] = $all;
					break;
				case 'promotion-conds':
					$options = array( 'or' => '|', 'and' => '&', 'xor' => '^', 'not' => '!' );
					$conds = array( APCOND_EDITCOUNT => 'int', APCOND_AGE => 'int', APCOND_EMAILCONFIRMED => 'bool',
						APCOND_INGROUPS => 'array', APCOND_ISIP => 'text', APCOND_IPINRANGE => 'text',
						APCOND_AGE_FROM_EDIT => 'int' );

					if ( isset( $_REQUEST['wp' . $name . '-vals'] ) ) {
						$groups = explode( "\n", trim( $request->getText( 'wp' . $name . '-vals' ) ) );
						foreach ( $groups as &$group ) {
							// Our own Sanitizer::unescapeId() :)
							$group = urldecode( str_replace( array( '.', "\r" ), array( '%', '' ),
								substr( $group, strlen( $name ) + 3 ) ) );
						}
						unset( $group ); // Unset the reference, just in case
					} else { // No javascript ?
						$groups = array_keys( $this->getSettingValue( $name ) );
					}

					foreach( $groups as $group ) {
						$op = $request->getText( 'wp' . $name . '-' . $group . '-opt' );
						if ( empty( $op ) ) {
							$op = 'and';
						}

						if( !isset( $options[$op] ) )
							throw new MWException( "'{$op}' for group '{$group}' is not a valid operator for 'promotion-conds' type" );
						$op = $options[$op];

						$condsVal = array( $op );
						foreach ( $conds as $condName => $condType ) {
							switch( $condType ) {
							case 'bool':
								$val = $request->getCheck( 'wp' . $name . '-' . $group . '-cond-' . $condName );
								if( $val )
									$condsVal[] = array( $condName );
								break;
							case 'int':
								$val = $request->getInt( 'wp' . $name . '-' . $group . '-cond-' . $condName );
								if( $val )
									$condsVal[] = array( $condName, $val );
								break;
							case 'text':
								$val = $request->getVal( 'wp' . $name . '-' . $group . '-cond-' . $condName );
								if( $val )
									$condsVal[] = array( $condName, $val );
								break;
							case 'array':
								$val = trim( $request->getText( 'wp' . $name . '-' . $group . '-cond-' . $condName ) );
								if( !$val )
									break;
								$val = array_map( 'trim', explode( "\n", $val ) );
								$reqGroups = array();
								foreach( $val as $reqGroup )
									if( $reqGroup )
										$reqGroups[] = $reqGroup;

								if( count( $reqGroups ) )
									$condsVal[] = array_merge( array( $condName ), $reqGroups );
							}
						}
						if ( count( $condsVal ) == 1 ) { ## Just the operator
							$condsVal = array( APCOND_AGE, -1 ); // A no-op
						}
						$settings[$name][$group] = $condsVal;
					}
					break;
				}
				break;
			case 'text':
			case 'lang':
			case 'image-url':
				$setting = $request->getVal( 'wp' . $name );

				if ( $file = wfFindFile( $setting ) ) {
					## It's actually a local file.
					$setting = $file->getUrl();
				}

				$settings[$name] = $setting;

				break;
			case 'int':
				$settings[$name] = $request->getInt( 'wp' . $name );
				break;
			case 'bool':
				$settings[$name] = $request->getCheck( 'wp' . $name );
				break;
			default:
				if ( is_array( $type ) ) {
					$val = $request->getVal( 'wp' . $name );
					if ( !array_key_exists( $val, $type ) && $val !== null ) {
						$perm = implode( ', ', $type );
						throw new MWException( "Value for \$$name setting is not in permitted (given: $val, permitted: $perm)" );
					}
					$settings[$name] = $val;
				} else {
					throw new MWException( "Unknown setting type $type (setting name: \$$name)" );
				}
			}

			if ( array_key_exists( $name, $settings ) ) {
				$settings[$name] = $this->cleanupSetting( $name, $settings[$name], $type );
				if ( $settings[$name] === null )
					unset( $settings[$name] );
			}
		}

		return $settings;
	}

	/**
	 * Cleanup some settings to respect some behaviour of the core
	 *
	 * @param $name String: setting name
	 * @param $val Mixed: setting value
	 * @return Mixed
	 */
	protected function cleanupSetting( $name, $val, $type ) {
		global $wgConf;

		if ( !empty( $val ) || $val || $type == 'bool' ) {
			return $val;
		}

		static $list = null;
		if ( $list === null )
			$list = $this->mConfSettings->getEmptyValues();

		static $defaults = null;
		if ( $defaults === null )
			$defaults = $wgConf->getDefaultsForWiki( $this->mWiki );

		if ( array_key_exists( $name, $list ) ) {
			return $list[$name];
		} elseif ( !array_key_exists( $name, $defaults ) ) {
			return null;
		} elseif ( empty( $defaults[$name] ) ) {
			return $defaults[$name];
		}
	}

	/**
	 * Removes the defaults values from settings
	 *
	 * @param $settings Array
	 * @return array
	 */
	protected function removeDefaults( $settings ) {
		global $wgConf;
		$defaultValues = $wgConf->getDefaultsForWiki( $this->mWiki );
		foreach ( $defaultValues as $name => $default ) {
			## Normalise the two, to avoid false "changes"
			if ( is_array( $default ) ) {
				$default = WebConfiguration::filterVar( $default );
			}

			if ( isset( $settings[$name] ) ) {
				$settingCompare = $settings[$name];
				if ( is_array( $settingCompare ) )
					$settingCompare = WebConfiguration::filterVar( $settingCompare );

				if ( $settingCompare == $default ) {
					unset( $settings[$name] );
				} elseif ( $this->canBeMerged( $name, $default ) ) {
					$value = $settings[$name];
					$type = $this->getArrayType( $name );
					switch( $type ) {
					case 'assoc':
					case 'ns-bool':
					case 'ns-text':
					case 'ns-array':
						foreach ( array_keys( array_intersect_key( $default, $value ) ) as $key ) {
							if ( $default[$key] === $value[$key] )
								unset( $settings[$name][$key] );
						}
						break;
					case 'group-bool':
						foreach ( array_unique( array_merge( array_keys( $default ), array_keys( $value ) ) ) as $group ) {
							$defGroup = isset( $default[$group] ) ? $default[$group] : array();
							$valGroup = isset( $value[$group] ) ? $value[$group] : array();
							foreach ( array_unique( array_merge( array_keys( $defGroup ), array_keys( $valGroup ) ) ) as $right ) {
								if ( ( isset( $defGroup[$right] ) && isset( $valGroup[$right] ) && $defGroup[$right] === $valGroup[$right] ) ||
									( isset( $valGroup[$right] ) && !isset( $defGroup[$right] ) && $valGroup[$right] === false ) ) {
									unset( $settings[$name][$group][$right] );
								}
							}
							if ( isset( $settings[$name][$group] ) && !count( $settings[$name][$group] ) )
								unset( $settings[$name][$group] );
						}
						break;
					}
				}
			}
		}
		return $settings;
	}

	/**
	 * Returns a bool wheter the setting can be merged with the default in
	 * DefaultSettings.php
	 *
	 * @param $name String: setting name
	 * @param $value Mixed: new value of the setting
	 * @return bool
	 */
	protected function canBeMerged( $name, $value ) {
		if ( !is_array( $value ) )
			return false;
		if ( $this->getSettingType( $name ) != 'array' )
			return false;
		global $wgConf;
		return ( !isset( $wgConf->settings[$name] ) && isset( $wgConf->settings["+$name"] ) );
	}

	/**
	 * Show the main form
	 */
	protected function showForm() {
		$this->getOutput()->addHTML(
			( $this->mCanEdit ?
				$this->getWikiSelectForm() .
				Html::openElement( 'form', array( 'method' => 'post',
					'action' => $this->getTitle()->getLocalURL(), 'id' => 'configure-form' ) ) . "\n" :
				Html::openElement( 'div', array( 'id' => 'configure-form' ) )
			) .
			$this->buildOldVersionSelect() . "\n" .
			$this->buildSearchForm() . "\n" .
			Html::openElement( 'div', array( 'id' => 'configure' ) ) . "\n" .
			$this->buildAllSettings() . "\n" .
			( $this->mCanEdit ?
				$this->msg( 'configure-form-reason' )->text() . ' ' . Html::input( 'wpReason',
					$this->getRequest()->getText( 'wpReason' ), 'text', array( 'size' => 45 ) ) . "\n" .
				Html::openElement( 'div', array( 'id' => 'prefsubmit' ) ) . "\n" .
				Html::openElement( 'div', array() ) . "\n" .
				Html::input( 'wpSave', $this->msg( 'configure-btn-save' )->text(), 'submit', array( 'class' => 'btnSavePrefs' ) ) . "\n" .
				Html::input( 'wpPreview', $this->msg( 'showdiff' )->text(), 'submit' ) . "\n" .
				Html::closeElement( 'div' ) . "\n" .
				Html::closeElement( 'div' ) . "\n" .
				Html::hidden( 'wpEditToken', $this->getUser()->editToken() ) . "\n" .
				( $this->mWiki ? Html::hidden( 'wpWiki', $this->mWiki ) . "\n" : '' )
			: ''
			) .
			Html::closeElement( 'div' ) . "\n" .
			Html::closeElement( $this->mCanEdit ? 'form' : 'div' )
		);
		$this->injectScriptsAndStyles();
	}

	/** Show a hidden-by-default search form */
	protected function buildSearchForm() {
		$input = $this->msg( 'configure-js-search-prompt' )->parse() . $this->msg( 'word-separator' )->escaped() .
			Html::element( 'input', array( 'id' => 'configure-search-input', 'size' => 45 ), null );
		$form = Html::element( 'legend', null, $this->msg( 'configure-js-search-legend' )->text() ) . Html::rawElement( 'p', null, $input ) . "\n" .
			Html::openElement( 'ul', array( 'id' => 'configure-search-results' ) ) . Html::closeElement( 'ul' );
		$form = Html::rawElement( 'fieldset', array( 'style' => 'display: none;', 'id' => 'configure-search-form' ), $form );
		return $form;
	}

	/**
	 * Inject JavaScripts and Stylesheets in page output
	 */
	protected function injectScriptsAndStyles() {
		$this->getOutput()->addModules( 'ext.configure' );
	}

	/**
	 * Like before but only for the header
	 *
	 * @param $msg String: name of the message to display
	 * @return String xhtml fragment
	 */
	protected function buildTableHeading( $msg ) {
		$msgObj = $this->msg( 'configure-section-' . $msg );
		if ( $msgObj->exists() ) {
			$msgVal = $msgObj->parse();
		} else {
			$msgVal = $msg;
		}
		return "\n<h2>" . $msgVal . "</h2>" . Html::openElement( 'table', array( 'class' => 'configure-table' ) ) . "\n";
	}

	/**
	 * Build an input for $conf setting with $default as default value
	 *
	 * @param $conf String: name of the setting
	 * @param $params Array
	 * @return String xhtml fragment
	 */
	protected function buildInput( $conf, $params = array() ) {
		$read = isset( $params['read'] ) ? $params['read'] : $this->userCanRead( $conf );
		if ( !$read )
			return Html::rawElement( 'span', array( 'class' => 'disabled' ), $this->msg( 'configure-view-not-allowed' )->parse() );
		$allowed = isset( $params['edit'] ) ? $params['edit'] : $this->userCanEdit( $conf );
		$type = isset( $params['type'] ) ? $params['type'] : $this->getSettingType( $conf );
		$default = isset( $params['value'] ) ? $params['value'] : $this->getSettingValue( $conf );
		if ( $type == 'text' || $type == 'int' ) {
			if ( !$allowed )
				return '<code>' . htmlspecialchars( (string)$default ) . '</code>';
			return Html::input( "wp$conf", (string)$default, 'text', array( 'size' => $type == 'text' ? 45 : 10 ) );
		}
		if ( $type == 'image-url' ) {
			if ( !$allowed )
				return '<code>' . htmlspecialchars( (string)$default ) . '</code>';
			return $this->msg( 'configure-image-url-explanation' )->parse() . '<br />' .
				Html::element( 'input', array( 'name' => "wp$conf", 'size' => 45, 'value' => (string)$default,
					'class' => 'image-selector', 'id' => 'image-url-textbox-' . $conf )
				) . '&#160;' .
				Html::element( 'img', array( 'id' => 'image-url-preview-'.$conf, 'src' => $default ) );
		}
		if ( $type == 'bool' ) {
			if ( !$allowed )
				return '<code>' . ( $default ? 'true' : 'false' ) . '</code>';
			$attribs = array( 'type' => 'checkbox', 'name' => "wp$conf", 'value' => '1' );
			if ( $default ) {
				$attribs['checked'] = 'checked';
			}
			return Html::element( 'input', $attribs );
		}
		if ( $type == 'array' ) {
			return $this->buildArrayInput( $conf, $default, $allowed );
		}
		if ( $type == 'lang' ) {
			$languages = Language::getLanguageNames( true );

			if ( $allowed ) {
				if ( !array_key_exists( $default, $languages ) ) {
					$languages[$default] = $default;
				}
				ksort( $languages );

				$options = "\n";
				foreach ( $languages as $code => $name ) {
					$attribs = array( 'value' => $code );
					if ( $code == $default )
						$attribs['selected'] = 'selected';
					$options .= Html::element( 'option', $attribs, "$code - $name" ) . "\n";
				}

				return Html::rawElement( 'select', array( 'id' => 'wp' . $conf, 'name' => 'wp' . $conf ), $options );
			} else {
				return '<code>' . ( isset( $languages[$default] ) ?
					htmlspecialchars( "$default - " . $languages[$default] ) :
					htmlspecialchars( $default ) ) . '</code>';
			}
		}
		if ( is_array( $type ) ) {
			if ( !$allowed )
				return '<code>' . htmlspecialchars( $default ) . '</code>';
			$ret = "\n";
			foreach ( $type as $val => $name ) {
				$checked = is_int( $val ) ?
					$val === (int)$default : strval($default) === strval($val);

				$opts = array( 'name' => 'wp' . $conf );
				if ( $checked ) {
					$opts['checked'] = 'checked';
				}
				$ret .= Html::input( 'wp' . $conf . $val, $val, 'radio', $opts ) .
					'&#160;' . Html::element( 'label', array( 'for' => 'wp' . $conf . $val ), $name );

			}
			return $ret;
		}
	}

	/**
	 * Build an input for an array setting
	 * TODO Consolidate some of the duplicated code here.
	 *
	 * @param $conf String: setting name
	 * @param $default Mixed: current value (but should be array :)
	 * @param $allowed Boolean
	 */
	protected function buildArrayInput( $conf, $default, $allowed ) {
		$type = $this->getArrayType( $conf );
		if ( $type === null || $type == 'array' )
			return Html::rawElement( 'span', array( 'class' => $allowed ? 'array' : 'array-disabled' ), '(array)' );
		if ( $type == 'simple' ) {
			if ( !$allowed ) {
				return "<pre>" .
					htmlspecialchars( ( is_array( $default ) ? implode( "\n", $default ) : $default ) ) .
					"\n</pre>";
			}
			$text = $this->msg( 'configure-arrayinput-oneperline' )->parse();
			$text .= Html::textarea( "wp{$conf}", is_array( $default ) ? implode( "\n", $default ) : '',
				array( 'id' => "wp{$conf}", 'rows' => 8, 'style' => 'width:95%;' ) );
			return $text;
		}
		if ( $type == 'assoc' ) {
			## See if the key/value has a special description

			$keydescmsg = $this->msg( "configure-setting-$conf-key" );
			if ( $keydescmsg->exists() ) {
				$keydesc = $keydescmsg->parse();
			} else {
				$keydesc = $this->msg( 'configure-desc-key' )->escaped();
			}

			$valdescmsg = $this->msg( "configure-setting-$conf-value" );
			if ( $valdescmsg->exists() ) {
				$valdesc = $valdescmsg->parse();
			} else {
				$valdesc = $this->msg( 'configure-desc-val' )->escaped();
			}

			$classes = array( 'configure-array-table', 'assoc' );

			if ( !$allowed )
				$classes[] = 'disabled';
			if ( count( $default ) > 5 )
				$classes[] = 'configure-biglist';

			$text = Html::openElement( 'table', array( 'class' => ( implode( ' ', $classes ) ),
				'id' => $conf ) ) . "\n";
			$text .= Html::rawElement( 'tr', array(), Html::rawElement( 'th', array(), $keydesc ) . Html::rawElement( 'th', array(), $valdesc ) );
			if ( is_array( $default ) && count( $default ) > 0 ) {
				$i = 0;
				foreach ( $default as $key => $val ) {
					$text .= Html::openElement( 'tr' ) . Html::openElement( 'td' );
					if ( $allowed )
						$text .= Html::element( 'input', array(
							'name' => 'wp' . $conf . "-key-{$i}",
							'type' => 'text', 'value' => $key, 'size' => 20
						) ) . Html::element( 'br' ) . "\n";
					else
						$text .= '<code>' . htmlspecialchars( $key ) . '</code>';
					$text .= Html::closeElement( 'td' ) . Html::openElement( 'td' );
					if ( $allowed ) {
						$text .= Html::element( 'input', array(
							'name' => 'wp' . $conf . "-val-{$i}",
							'type' => 'text', 'value' => $val, 'size' => 20
						) ) . Html::element( 'br' ) . "\n";
					} else {
						$text .= '<code>' . htmlspecialchars( $val ) . '</code>';
					}
					$text .= Html::closeElement( 'td' ) . Html::closeElement( 'tr' );
					$i++;
				}
			} else {
				if ( $allowed ) {
					$text .= Html::openElement( 'tr' ) . Html::openElement( 'td' );
					$text .= Html::element( 'input', array(
						'name' => 'wp' . $conf . "-key-0",
						'type' => 'text', 'value' => '', 'size' => 20,
					) ) . Html::element( 'br' ) . "\n";
					$text .= Html::closeElement( 'td' ) . Html::openElement( 'td' );
					$text .= Html::element( 'input', array(
						'name' => 'wp' . $conf . "-val-0",
						'type' => 'text', 'value' => '', 'size' => 20,
					) ) . Html::element( 'br' ) . "\n";
					$text .= Html::closeElement( 'td' ) . Html::closeElement( 'tr' );
				} else {
					$text .= Html::rawElement( 'tr', array(),
						Html::rawElement( 'td', array( 'style' => 'width:10em;height:1.5em;' ), Html::element( 'hr' ) ) .
						Html::rawElement( 'td', array( 'style' => 'width:10em;height:1.5em;' ), Html::element( 'hr' ) )
					) . "\n";
				}
			}
			$text .= Html::closeElement( 'table' );
			return $text;
		}
		if ( $type == 'rate-limits' ) { ## Some of this is stolen from assoc, since it's an assoc with an assoc.
			$keydescmsg = $this->msg( "configure-setting-$conf-key" );
			if ( $keydescmsg->exists() ) {
				$keydesc = $keydescmsg->parse();
			} else {
				$keydesc = $this->msg( 'configure-desc-key' )->escaped();
			}

			$valdescmsg = $this->msg( "configure-setting-$conf-value" );
			if ( $valdescmsg->exists() ) {
				$valdesc = $valdescmsg->parse();
			} else {
				$valdesc = $this->msg( 'configure-desc-val' )->escaped();
			}

			$classes = array( 'configure-array-table', 'configure-rate-limits' );

			if ( !$allowed )
				$classes[] = 'disabled';

			$rows = Html::rawElement( 'tr', array(), Html::rawElement( 'th', array(), $keydesc ) . " " . Html::rawElement( 'th', array(), $valdesc ) )."\n";

			# TODO put this stuff in one place.
			$validActions = array( 'edit', 'move', 'mailpassword', 'emailuser', 'rollback' );
			$validGroups = array( 'anon', 'user', 'newbie', 'ip', 'subnet' );

			foreach( $validActions as $action ) {
				$val = array();
				if ( isset( $default[$action] ) )
					$val = $default[$action];

				$key = Html::rawElement( 'td', array(), $this->msg( "configure-throttle-action-$action" )->parse() );

				## Build YET ANOTHER ASSOC TABLE ARGH!
				$innerRows = Html::rawElement( 'tr', array(), Html::rawElement( 'th', array(), $this->msg( 'configure-throttle-group' )->parse() ) . ' ' .
					Html::rawElement( 'th', array(), $this->msg( 'configure-throttle-limit' )->parse() ) )."\n";
				foreach( $validGroups as $type ) {
					$limits = null;
					if ( isset( $default[$action][$type] ) )
						$limits = $default[$action][$type];
					if ( is_array( $limits ) && count( $limits ) == 2 )
						list( $count, $period ) = $limits;
					else
						$count = $period = 0;

					$id = 'wp'.$conf.'-key-'.$action.'-'.$type;
					$left_col = Html::rawElement( 'td', array(), $this->msg( "configure-throttle-group-$type" )->parse() );

					if ( $allowed ) {
						$right_col = Html::element( 'label', array( 'for' => "$id-count" ), $this->msg( 'configure-throttle-count' )->text() ) .
							'&#160;' . Html::input( "$id-count", $count, 'text', array( 'name' => "$id-count", 'size' => 15 ) ) .
							Html::element( 'br' ) .
							Html::element( 'label', array( 'for' => "$id-period" ), $this->msg( 'configure-throttle-period' )->text() ) .
							'&#160;' . Html::input( "$id-period", $period, 'text', array( 'name' => "$id-period", 'size' => 15 ) );
					} else {
						$right_col = ($count && $period) ? $this->msg( 'configure-throttle-summary', $count, $period )->text() : $this->msg( 'configure-throttle-none' )->text();
						## Laziness: Make summaries work by putting the data in hidden fields, rather than a special case in JS.
						$right_col .= "\n" . Html::hidden( "$id-count", $count, array( 'id' => "$id-count" ) ) . Html::hidden( "$id-period", $period, array( 'id' => "$id-period" ) );
					}
					$right_col = Html::rawElement( 'td', array(), $right_col );

					$innerRows .= Html::rawElement( 'tr', array( 'id' => $id ), $left_col . $right_col ) . "\n";
				}

				$value = Html::rawElement( 'td', array(), Html::rawElement( 'table', array( 'class' => 'configure-biglist configure-rate-limits-action' ), Html::rawElement( 'tbody', array(), $innerRows ) ) );
				$rows .= Html::rawElement( 'tr', array(), $key.$value )."\n";
			}

			return Html::rawElement( 'table', array( 'class' => implode( ' ', $classes ) ), Html::rawElement( 'tbody', null, $rows ) );
		}
		if ( $type == 'simple-dual' ) {
			$var = array();
			if ( is_array( $default ) ) {
				foreach ( $default as $arr ) {
					$var[] = implode( ',', $arr );
				}
			}
			if ( !$allowed ) {
				return "<pre>\n" . htmlspecialchars( implode( "\n", $var ) ) . "\n</pre>";
			}
			$text = "<textarea id='wp{$conf}' name='wp{$conf}' cols='30' rows='8'>";
			if ( is_array( $var ) )
				$text .= implode( "\n", $var );
			$text .= "</textarea>\n";
			return $text;
		}
		if ( $type == 'ns-bool' || $type == 'ns-simple' ) {
			global $wgContLang;
			$text = '';
			$attr = ( !$allowed ) ? array( 'disabled' => 'disabled' ) : array();
			foreach ( $wgContLang->getNamespaces() as $ns => $name ) {
				$name = str_replace( '_', ' ', $name );
				if ( '' == $name ) {
					$name = $this->msg( 'blanknamespace' )->parse();
				}
				if ( $type == 'ns-bool' ) {
					$checked = isset( $default[$ns] ) && $default[$ns];
				} else {
					$checked = in_array( $ns, (array)$default );
				}
				$inputAttribs = array(
					'name' => "wp{$conf}-ns{$ns}",
					'id' => "wp{$conf}-ns{$ns}",
					'type' => 'checkbox',
					'value' => 1
				);
				if ( $checked ) {
					$inputAttribs['checked'] = 'checked';
				}
				$inputAttribs += $attr;
				$text .= Html::rawElement( 'span', array( 'style' => 'white-space:nowrap;' ),
					Html::element( 'input', $inputAttribs ) . '&#160;' .
					Html::element( 'label', array( 'for' => "wp{$conf}-ns{$ns}" ), $name ) ) . "\n";
			}
			$text = Html::rawElement( 'div', array( 'class' => 'configure-biglist '.$type ), $text );
			return $text;
		}
		if ( $type == 'ns-text' ) {
			global $wgContLang;
			$nsdesc = $this->msg( 'configure-desc-ns' )->escaped();
			$valdescmsg = $this->msg( "configure-setting-$conf-value" );
			if ( $valdescmsg->exists() ) {
				$valdesc = $valdescmsg->parse();
			} else {
				$valdesc = $this->msg( 'configure-desc-val' )->escaped();
			}

			$text = Html::openElement( 'table', array( 'class' => 'configure-array-table ns-text configure-biglist' ) ) . "\n" .
				Html::rawElement( 'tr', array(), Html::rawElement( 'th', array(), $nsdesc ) . Html::rawElement( 'th', array(), $valdesc ) ) . "\n";
			foreach ( $wgContLang->getNamespaces() as $ns => $name ) {
				$name = str_replace( '_', ' ', $name );
				if ( '' == $name ) {
					$name = $this->msg( 'blanknamespace' )->parse();
				}
				$text .= Html::openElement( 'tr', array() ) . Html::rawElement( 'td', array(), $name ) . Html::openElement( 'td', array() );
				if ( $allowed )
					$text .= Html::element( 'input', array(
						'size' => 20,
						'name' => "wp{$conf}-ns{$ns}",
						'type' => 'text', 'value' => isset( $default[$ns] ) ? $default[$ns] : ''
					) ) . "\n";
				else
					$text .= htmlspecialchars( isset( $default[$ns] ) ? $default[$ns] : '' );
				$text .= Html::closeElement( 'td' ) . Html::closeElement( 'tr' );
			}
			$text .= Html::closeElement( 'table' );
			return $text;
		}
		if ( $type == 'ns-array' ) {
			global $wgContLang;
			$nsdesc = $this->msg( 'configure-desc-ns' )->escaped();
			$valdescmsg = $this->msg( "configure-setting-$conf-value" );
			if ( $valdescmsg->exists() ) {
				$valdesc = $valdescmsg->parse();
			} else {
				$valdesc = $this->msg( 'configure-desc-val' )->escaped();
			}

			$text = Html::openElement( 'table', array( 'class' => 'ns-array configure-biglist configure-array-table' ) ) . "\n" .
				Html::rawElement( 'tr', array(), Html::rawElement( 'th', array(), $nsdesc ) . Html::rawElement( 'th', array(), $valdesc ) ) . "\n";
			foreach ( $wgContLang->getNamespaces() as $ns => $name ) {
				if ( $ns < 0 )
					continue;
				$name = str_replace( '_', ' ', $name );
				if ( '' == $name ) {
					$name = $this->msg( 'blanknamespace' )->parse();
				}
				$text .= Html::openElement( 'tr' ) . Html::rawElement( 'td', array(),
					Html::rawElement( 'label', array( 'for' => "wp{$conf}-ns{$ns}" ), $name ) ) . Html::openElement( 'td' );
				if ( $allowed ) {
					$text .= Html::textarea( "wp{$conf}-ns{$ns}", isset( $default[$ns] ) ? implode( "\n", (array)$default[$ns] ) : '',
						array(
							'id' => "wp{$conf}-ns{$ns}",
							'rows' => 5
						)
					) . Html::element( 'br' ) . "\n";
				} else {
					$text .= "<pre>" . ( isset( $default[$ns] ) ?
						htmlspecialchars( implode( "\n", (array)$default[$ns] ) ) : '' ) . "\n</pre>";
				}
				$text .= Html::closeElement( 'td' ) . Html::closeElement( 'tr' );
			}
			$text .= Html::closeElement( 'table' );
			return $text;
		}
		if ( $type == 'group-bool' || $type == 'group-array' ) {
			$all = array();
			if ( $type == 'group-bool' ) {
				$all = User::getAllRights();
				$iter = $default;
				$allGroups = array_keys( $all );
				$autopromote = array_keys( $this->getSettingValue( 'wgAutopromote' ) );
				$newGroups = array_diff( $autopromote, $allGroups );
				foreach( $newGroups as $newGroup ) {
					$iter[$newGroup] = array();
				}
			} else {
				$all = array_keys( $this->getSettingValue( 'wgGroupPermissions' ) );
				$iter = array();
				foreach ( $all as $group ) {
					$iter[$group] = isset( $default[$group] ) && is_array( $default[$group] ) ?
						$default[$group] : array();
				}
				$all = array_diff( $all, $this->getSettingValue( 'wgImplicitGroups' ) );
			}
			sort( $all );
			$groupdesc = $this->msg( 'configure-desc-group' )->escaped();
			$valdescmsg = $this->msg( "configure-setting-$conf-value" );
			if ( $valdescmsg->exists() ) {
				$valdesc = $valdescmsg->parse();
			} else {
				$valdesc = $this->msg( 'configure-desc-val' )->escaped();
			}

			$classes = "{$type} configure-array-table" . ( $type == 'group-bool' ? ' ajax-group' : '' );
			$text = Html::openElement( 'table', array( 'id' => $conf, 'class' => $classes ) ) ."\n";
			$text .= Html::rawElement( 'tr', array( 'class' => 'configure-maintable-row' ),
				Html::rawElement( 'th', array(), $groupdesc ) . Html::rawElement( 'th', array(), $valdesc ) ) . "\n";
			foreach ( $iter as $group => $levs ) {
				$row = self::buildGroupSettingRow( $conf, $type, $all, $allowed, $group, $levs );
				$groupName = User::getGroupName( $group );

				$text .= Html::rawElement( 'tr', array( 'class' => 'configure-maintable-row', 'id' => 'wp' . $conf . '-' . $group ),
					Html::rawElement( 'td', array( 'class' => 'configure-grouparray-group' ), $groupName ) . "\n" .
					Html::rawElement( 'td', array( 'class' => 'configure-grouparray-value' ), $row ) );
			}
			$text .= Html::closeElement( 'table' );
			return $text;
		}
		if ( $type == 'promotion-conds' ) {

			$groupdesc = $this->msg( 'configure-desc-group' )->escaped();
			$valdescmsg = $this->msg( "configure-setting-$conf-value" );
			if ( $valdescmsg->exists() ) {
				$valdesc = $valdescmsg->parse();
			} else {
				$valdesc = $this->msg( 'configure-desc-val' )->escaped();
			}

			$text = Html::openElement( 'table', array( 'id' => $conf, 'class' => "{$type} configure-array-table ajax-group" ) ) ."\n";
			$text .= Html::rawElement( 'tr', array( 'class' => 'configure-maintable-row' ),
				Html::rawElement( 'th', array(), $groupdesc ) . Html::rawElement( 'th', array(), $valdesc ) ) . "\n";

			foreach ( $default as $group => $groupConds ) {
				$row = self::buildPromotionCondsSettingRow( $conf, $allowed, $group, $groupConds );
				$groupName = User::getGroupName( $group );

				$text .= Html::rawElement( 'tr', array( 'class' => 'configure-maintable-row', 'id' => 'wp' . $conf . '-' . $group ),
					Html::rawElement( 'td', array( 'class' => 'configure-promotion-group' ), $groupName ) . "\n" .
					Html::rawElement( 'td', array( 'class' => 'configure-promotion-value' ), $row ) );
			}

			$text .= Html::closeElement( 'table' );
			return $text;
		}
	}

	/**
	 * Build a row for promotion-conds array type, taken out of buildArrayInput()
	 * to called with ajax
	 * @param $conf String: setting name
	 * @param $allowed Boolean
	 * @param $group String: group name
	 * @param $groupConds Array: existing conditions for $group
	 * @return String: XHTML
	 */
	public static function buildPromotionCondsSettingRow( $conf, $allowed, $group, $groupConds ){
		static $options = array( 'or' => '|', 'and' => '&', 'xor' => '^', 'not' => '!' );
		static $conds = array( APCOND_EDITCOUNT => 'int', APCOND_AGE => 'int', APCOND_EMAILCONFIRMED => 'bool',
			APCOND_INGROUPS => 'array', APCOND_ISIP => 'text', APCOND_IPINRANGE => 'text',
			APCOND_AGE_FROM_EDIT => 'int' );

		$row = Html::openElement( 'div', array( 'class' => 'configure-biglist promotion-conds-element' ) );
		$row .= wfMessage( 'configure-condition-operator' )->escaped() . ' ';
		$encConf = htmlspecialchars( $conf );
		$encGroup = htmlspecialchars( $group );
		$encId = 'wp'.$encConf.'-'.$encGroup;
		$curOpt = is_array( $groupConds ) ? array_shift( $groupConds ) : '&';

		if ( empty($curOpt) )
			$curOpt = '&';

		$extra = $allowed ? array() : array( 'disabled' => 'disabled' );
		foreach ( $options as $desc => $opt ) {
			$opts = array( 'name' => $encId.'-opt' ) + $extra;
			if ( $curOpt == $opt ) {
				$opts['checked'] = 'checked';
			}
			$row .= Html::input( $encId.'-opt-'.$desc, $desc, 'radio', $opts ) .
				'&#160;' . Html::element( 'label', array( 'for' => $encId.'-opt-'.$desc ), wfMessage( 'configure-condition-operator-'.$desc )->text() );
		}
		$row .= Html::element( 'br' ) . "\n";

		if ( !is_array( $groupConds ) )
			$groupConds = array( $groupConds );

		$condsVal = array();
		foreach( $groupConds as $cond ){
			if( !is_array( $cond ) ) {
				$condsVal[$cond] = true;
				continue;
			}
			$name = array_shift( $cond );
			if ( !is_array( $cond ) || count( $cond ) == 0 ) {
				$condsVal[$name] = true;
			} elseif( $conds[$name] != 'array' && count( $cond ) == 1 ) {
				$condsVal[$name] = array_shift( $cond );
			} else {
				$condsVal[$name] = $cond;
			}
		}

		$row .= Html::openElement( 'table', array( 'class' => 'configure-table-promotion' ) );

		$row .= Html::rawElement( 'tr', array(), Html::element( 'th', array(), wfMessage( 'configure-condition-name' )->text() ) .
			Html::element( 'th', array(), wfMessage( 'configure-condition-requirement' )->text() ) )."\n";
		foreach ( $conds as $condName => $condType ) {
			$desc = wfMessage( 'configure-condition-name-' . $condName )->text();
			$row .= Html::openElement( 'tr' ) . Html::rawElement( 'td', array(),
				Html::element( 'label', array( 'for' => "{$encId}-cond-{$condName}" ), $desc ) ) . Html::openElement( 'td' );
			switch( $condType ) {
			case 'bool':
				$opts = array( 'id' => $encId.'-cond-'.$condName ) + $extra;
				if ( isset( $condsVal[$condName] ) && $condsVal[$condName] )
					$opts['checked'] = 'checked';
				$row .= Html::input( $encId.'-cond-'.$condName, '1', 'checkbox', $opts );
			case 'text':
			case 'int':
				$row .= Html::input( $encId.'-cond-'.$condName, isset( $condsVal[$condName] ) ? $condsVal[$condName] : ( $condType == 'int' ? 0 : '' ), 'text',
					array( 'size' => $condType == 'int' ? 20 : 40 ) + $extra ) .
					Html::element( 'br' ) . "\n";
				break;
			case 'array':
				$id = "{$encId}-cond-{$condName}";
				if ( $allowed ) {
					if ( isset( $condsVal[$condName] ) && $condsVal[$condName] )
						$cont = htmlspecialchars( implode( "\n", $condsVal[$condName] ) );
					else
						$cont = '';
					$row .= Html::textarea( $id, $cont, array( 'id' => $id, 'rows' => '4', 'style' => 'width:95%;' ) );
				} else {
					$row .= "<pre>";
					if ( isset( $condsVal[$condName] ) && $condsVal[$condName] )
						$row .= htmlspecialchars( implode( "\n", $condsVal[$condName] ) );
					$row .= "</pre>\n";
				}
			}
			$row .= Html::closeElement( 'td' ) . Html::closeElement( 'tr' );
		}
		$row .= Html::closeElement( 'table' ) . Html::closeElement( 'div' );
		return $row;
	}

	/**
	 * Build a row for group-bool or group-array array type, taken out of
	 * buildArrayInput() to called with ajax
	 * @param $conf String: setting name
	 * @param $type String: array type
	 * @param $all Array: all avialable rights
	 * @param $allowed Boolean
	 * @param $group String: group name
	 * @param $levs Array: rights given to $group
	 * @return String: XHTML
	 */
	public static function buildGroupSettingRow( $conf, $type, $all, $allowed, $group, $levs ){
		$attr = ( !$allowed ) ? array( 'disabled' => 'disabled' ) : array();

		$row = Html::openElement( 'div', array( 'class' => 'configure-biglist '.$type.'-element' ) ) . Html::openElement( 'ul' );
		foreach ( $all as $right ) {
			if ( $type == 'group-bool' )
				$checked = ( isset( $levs[$right] ) && $levs[$right] );
			else
				$checked = in_array( $right, $levs );
			$id = Sanitizer::escapeId( 'wp' . $conf . '-' . $group . '-' . $right );
			if( $type == 'group-bool' )
				$desc = User::getRightDescription( $right ) . " (" .Html::element( 'tt', array( 'class' => 'configure-right-id' ), $right ) . ")";
			else
				$desc = User::getGroupName( $right );
			$checkedArr = $checked ? array( 'checked' => 'checked' ) : array();
			$row .= Html::rawElement( 'li', array(), Html::input( $id, '1', 'checkbox', $attr + array( 'id' => $id ) + $checkedArr ) . '&#160;' . Html::rawElement( 'label', array( 'for' => $id ), $desc ) ) . "\n";
		}
		$row .= Html::closeElement( 'ul' ) . Html::closeElement( 'div' );
		return $row;
	}

	/**
	 * Build a table row for $conf setting with $default as default value
	 *
	 * @param $conf String: name of the setting
	 * @param $params Array: options
	 * @return String xhtml fragment
	 */
	protected function buildTableRow( $conf, $params ) {
		global $wgContLang;

		$rowClasses = array();

		if ( $params['customised'] )
			$rowClasses[] = 'configure-customised';

		$msg = isset( $params['msg'] ) ? $params['msg'] : 'configure-setting-' . $conf;
		$showLink = isset( $params['link'] ) ? $params['link'] : true;

		## First TD
		$rawVal = Html::element( 'tt', null, "\$$conf" );
		if ( $showLink ) {
			$url = 'http://www.mediawiki.org/wiki/Manual:$' . $conf;
			$link = Html::rawElement( 'a', array( 'href' => $url, 'class' => 'configure-doc' ), $rawVal );
		} else {
			$link = $rawVal;
		}

		$msgObj = $this->msg( $msg );
		if ( $msgObj->exists() ) {
			$msgVal = $msgObj->parse() . " ($link)";
		} else {
			$msgVal = $link;
		}

		if ( $params['customised'] ) {
			$msgVal = Html::rawElement( 'p', null, $msgVal ) . $this->msg( 'configure-customised' )->parseAsBlock();
		}

		$attribs = array();
		$attribs['style'] = 'text-align:' . ( $wgContLang->isRtl() ? 'right' : 'left' ) . ';vertical-align:top;';
		$attribs['class'] = 'configure-left-column';
		$td1 = Html::rawElement( 'td', $attribs, $msgVal );

		## Only the class is customised per-cell, so we'll just redefine that.
		$attribs['class'] = 'configure-right-column';

		$td2 = Html::rawElement( 'td', $attribs, $this->buildInput( $conf, $params ) );

		return Html::rawElement( 'tr', array( 'class' => implode( ' ', $rowClasses ) ), $td1 . $td2 ) . "\n";
	}

	/**
	 * Really build the content of the form
	 *
	 * @param $settings array
	 * @param $params array
	 * @return xhtml
	 */
	protected function buildSettings( $settings, $param = array() ) {
		global $wgConf;
		$defaults = $wgConf->getDefaultsForWiki( $this->mWiki );

		$ret = '';
		$perms = array();
		$notEditableSet = $this->getUneditableSettings();
		foreach ( $settings as $title => $groups ) {
			$res = true;
			if ( !isset( $param['restrict'] ) ) {
				$res = true;
			} elseif ( is_array( $param['restrict'] ) ) {
				if ( isset( $param['restrict'][$title] ) )
					$res = $param['restrict'][$title];
				elseif ( isset( $param['restrict']['_default'] ) )
					$res = $param['restrict']['_default'];
				else
					$res = true;
			} else {
				$res = (bool)$param['restrict'];
			}
			foreach ( $groups as $name => $sect ) {
				foreach ( $sect as $setting => $unused ) {
					if ( in_array( $setting, $notEditableSet ) ) {
						unset( $groups[$name][$setting] );
						continue;
					}
					$read = $this->userCanRead( $setting );
					$edit = $this->userCanEdit( $setting );
					if ( $this->mCanEdit ? $edit : $read )
						$res = false;
					$perms[$setting] = array( 'read' => $read, 'edit' => $edit );
				}
				if ( !count( $groups[$name] ) )
					unset( $groups[$name] );
			}

			$thisSection = '';
			if ( !$res ) {
				if ( !isset( $param['showlink'] ) ) {
					$showlink = true;
				} elseif ( is_array( $param['showlink'] ) ) {
					if ( isset( $param['showlink'][$title] ) )
						$showlink = $param['showlink'][$title];
					elseif ( isset( $param['showlink']['_default'] ) )
						$showlink = $param['showlink']['_default'];
					else
						$showlink = true;
				} else {
					$showlink = (bool)$param['showlink'];
				}
				foreach ( $groups as $group => $settings ) {
					$thisGroup = '';
					foreach ( $settings as $setting => $type ) {
						$params = $perms[$setting] + array(
							'type' => $type,
							'value' => $this->getSettingValue( $setting ),
							'link' => $showlink,
						);

						$customised = !array_key_exists( $setting, $defaults );
						$customised = $customised || ( WebConfiguration::filterVar( $defaults[$setting] ) != WebConfiguration::filterVar( $params['value'] ) );

						$params['customised'] = $customised;

						$show = $this->mCanEdit ?
							( isset( $params['edit'] ) ? $params['edit'] : $this->userCanEdit( $setting ) ) :
							( isset( $params['read'] ) ? $params['read'] : $this->userCanRead( $setting ) );

						$show = $show && $this->isSettingAvailable( $setting );
						if ( $show ) {
							$thisGroup .= $this->buildTableRow( $setting, $params );
						} else {
							## Don't even show it.
						}
					}

					if ( $thisGroup ) {
						$thisSection .= $this->buildTableHeading( $group ) . $thisGroup . Html::closeElement( 'table' );
					}
				}

				if ( $thisSection ) {
					$thisSection = Html::rawElement( 'legend', null, $this->msg( "configure-section-$title" )->parse() ) . $thisSection;
					$ret .= Html::rawElement( 'fieldset', null, $thisSection );
				}
			}

		}
		return $ret;
	}
}
