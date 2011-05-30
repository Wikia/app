<?php
/**
 * Classes for %MediaWiki extension translation.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Class which handles special definition format for %MediaWiki extensions.
 */
class PremadeMediawikiExtensionGroups {
	protected $groups;
	protected $definitionFile = null;
	protected $useConfigure = true;
	protected $idPrefix = 'ext-';
	protected $namespaces = array( NS_MEDIAWIKI, NS_MEDIAWIKI_TALK );

	public function __construct() {
		global $wgTranslateExtensionDirectory;
		$dir = dirname( __FILE__ );
		$this->definitionFile = $dir . '/mediawiki-defines.txt';
		$this->path = $wgTranslateExtensionDirectory;
	}

	/// Initialisation function
	public function init() {
		if ( $this->groups !== null ) return;
		$groups = $this->parseFile();
		$this->groups = $this->processGroups( $groups );
	}

	/// Makes an group id from extension name
	static function foldId( $name ) {
		return preg_replace( '/\s+/', '', strtolower( $name ) );
	}

	/// Registers all extensions
	public function addAll() {
		global $wgTranslateAC, $wgTranslateEC;
		$this->init();

		if ( !count( $this->groups ) ) return;

		foreach ( $this->groups as $id => $g ) {
			$wgTranslateAC[$id] = array( $this, 'factory' );
			$wgTranslateEC[] = $id;
		}
	}

	public function factory( $id ) {
		$info = $this->groups[$id];
		$group = ExtensionMessageGroup::factory( $info['name'], $id );
		$group->setMessageFile( $info['file'] );
		$group->setPath( $this->path );
		$group->namespaces = $this->namespaces;

		if ( isset( $info['prefix'] ) ) {
			$mangler = new StringMatcher( $info['prefix'], $info['mangle'] );
			$group->setMangler( $mangler );
			$info['ignored'] = $mangler->mangle( $info['ignored'] );
			$info['optional'] = $mangler->mangle( $info['optional'] );
		}

		if ( !empty( $info['var'] ) ) $group->setVariableName( $info['var'] );
		if ( !empty( $info['optional'] ) ) $group->setOptional( $info['optional'] );
		if ( !empty( $info['ignored'] ) ) $group->setIgnored( $info['ignored'] );
		if ( isset( $info['desc'] ) ) {
			$group->setDescription( $info['desc'] );
		} else {
			$group->setDescriptionMsg( $info['descmsg'], $info['url'] );
		}

		if ( isset( $info['aliasfile'] ) ) $group->setAliasFile( $info['aliasfile'] );
		if ( isset( $info['magicfile'] ) ) $group->setMagicFile( $info['magicfile'] );

		return $group;
	}

	protected function parseFile() {
		$defines = file_get_contents( $this->definitionFile );
		$linefeed = '(\r\n|\n)';
		$sections = array_map( 'trim', preg_split( "/$linefeed{2,}/", $defines, - 1, PREG_SPLIT_NO_EMPTY ) );
		$groups = array();

		foreach ( $sections as $section ) {
			$lines = array_map( 'trim', preg_split( "/$linefeed/", $section ) );
			$newgroup = array();

			foreach ( $lines as $line ) {
				if ( $line === '' || $line[0] === '#' ) continue;

				if ( strpos( $line, '=' ) === false ) {
					if ( empty( $newgroup['name'] ) ) {
						$newgroup['name'] = $line;
					} else {
						throw new MWException( "Trying to define name twice: " . $line );
					}
				} else {
					list( $key, $value ) = array_map( 'trim', explode( '=', $line, 2 ) );
					switch ( $key ) {
					case 'file':
					case 'var':
					case 'id':
					case 'descmsg':
					case 'desc':
					case 'magicfile':
					case 'aliasfile':
						$newgroup[$key] = $value;
						break;
					case 'optional':
					case 'ignored':
						$values = array_map( 'trim', explode( ',', $value ) );
						if ( !isset( $newgroup[$key] ) ) {
							$newgroup[$key] = array();
						}
						$newgroup[$key] = array_merge( $newgroup[$key], $values );
						break;
					case 'prefix':
						list( $prefix, $messages ) = array_map( 'trim', explode( '|', $value, 2 ) );
						if ( isset( $newgroup['prefix'] ) && $newgroup['prefix'] !== $prefix ) {
							throw new MWException( "Only one prefix supported: {$newgroup['prefix']} !== $prefix" );
						}
						$newgroup['prefix'] = $prefix;

						if ( !isset( $newgroup['mangle'] ) ) $newgroup['mangle'] = array();

						$messages = array_map( 'trim', explode( ',', $messages ) );
						$newgroup['mangle'] = array_merge( $newgroup['mangle'], $messages );
						break;
					default:
						throw new MWException( "Unknown key:" . $key );
					}
				}
			}

			if ( count( $newgroup ) ) {
				if ( empty( $newgroup['name'] ) ) {
					throw new MWException( "Name missing\n" . print_r( $newgroup, true ) );
				}
				$groups[] = $newgroup;
			}
		}

		return $groups;
	}

	protected function processGroups( $groups ) {
		$configureData = $this->loadConfigureExtensionData();
		$fixedGroups = array();
		foreach ( $groups as $g ) {
			if ( !is_array( $g ) ) {
				$g = array( $g );
			}

			$name = $g['name'];

			if ( isset( $g['id'] ) ) {
				$id = $g['id'];
			} else {
				$id = $this->idPrefix . preg_replace( '/\s+/', '', strtolower( $name ) );
			}

			if ( isset( $g['file'] ) ) {
				$file = $g['file'];
			} else {
				$file = preg_replace( '/\s+/', '', "$name/$name.i18n.php" );
			}

			if ( isset( $g['descmsg'] ) ) {
				$descmsg = $g['descmsg'];
			} else {
				$descmsg = str_replace( $this->idPrefix, '', $id ) . '-desc';
			}

			$configureId = self::foldId( $name );
			if ( isset( $configureData[$configureId]['url'] ) ) {
				$url = $configureData[$configureId]['url'];
			} else {
				$url = false;
			}

			$newgroup = array(
				'name' => $name,
				'file' => $file,
				'descmsg' => $descmsg,
				'url' => $url,
			);

			$copyvars = array( 'ignored', 'optional', 'var', 'desc', 'prefix', 'mangle', 'magicfile', 'aliasfile' );
			foreach ( $copyvars as $var ) {
				if ( isset( $g[$var] ) ) {
					$newgroup[$var] = $g[$var];
				}
			}

			$fixedGroups[$id] = $newgroup;
		}
		return $fixedGroups;
	}

	protected function loadConfigureExtensionData() {
		if ( !$this->useConfigure ) {
			return array();
		}

		global $wgAutoloadClasses, $IP, $wgTranslateExtensionDirectory;

		$postfix = 'Configure/load_txt_def/TxtDef.php';
		if ( file_exists( "$IP/extensions/$postfix" ) ) {
			$prefix = "$IP/extensions";
		} elseif ( file_exists( "$wgTranslateExtensionDirectory/$postfix" ) ) {
			$prefix = $wgTranslateExtensionDirectory;
		} else {
			$prefix = false;
		}

		if ( $prefix ) {
			$wgAutoloadClasses['TxtDef'] = "$prefix/$postfix";
			$tmp = TxtDef::loadFromFile( "$prefix/Configure/settings/Settings-ext.txt" );
			return array_combine( array_map( array( __CLASS__, 'foldId' ), array_keys( $tmp ) ), array_values( $tmp ) );
		}

		return array();
	}


}
