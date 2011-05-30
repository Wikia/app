<?php
/**
 * Class for Toolserver Intuition for Translatewiki.net
 *
 * @file
 * @author Niklas Laxström
 * @author Krinkle
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @copyright Copyright © 2011, Krinkle
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Support for tools using Toolserver Intuition at the Toolserver.
 */
class PremadeToolserverTextdomains extends PremadeMediawikiExtensionGroups {
	protected $useConfigure = false;
	protected $groups;
	protected $idPrefix = 'tsint-';
	protected $namespaces = array( NS_TOOLSERVER, NS_TOOLSERVER_TALK );

	public function __construct() {
		global $wgTranslateGroupRoot;

		parent::__construct();
		$dir = dirname( __FILE__ );
		$this->definitionFile = $dir . '/toolserver-textdomains.txt';
		$this->path = "$wgTranslateGroupRoot/toolserver/language/messages/";
	}

	protected function processGroups( $groups ) {
		$configureData = $this->loadConfigureExtensionData();
		$fixedGroups = array();
		foreach ( $groups as $g ) {
			if ( !is_array( $g ) ) {
				$g = array( $g );
			}

			$name = $g['name'];
			$sanitizedName = preg_replace( '/\s+/', '', strtolower( $name ) );

			if ( isset( $g['id'] ) ) {
				$id = $g['id'];
			} else {
				$id = $this->idPrefix . $sanitizedName;
			}

			if ( isset( $g['file'] ) ) {
				$file = $g['file'];
			} else {
				// Toolserver Intuition text-domains are case-insensitive and internally
				// converts to lowercase names starting with a capital letter.
				// eg. "MyTool" -> "Mytool.i18n.php"
				// No subdirectories!
				$file = ucfirst( $sanitizedName ) . '.i18n.php';
			}

			if ( isset( $g['descmsg'] ) ) {
				$descmsg = $g['descmsg'];
			} else {
				$descmsg = "$id-desc";
			}

			if ( isset( $g['url'] ) ) {
				$url = $g['url'];
			} else {
				$url = false;
			}

			$newgroup = array(
				'name' => 'Toolserver - ' . $name,
				'file' => $file,
				'descmsg' => $descmsg,
				'url' => $url,
			);

			// Prefix is required, if not customized use the sanitized name
			if ( !isset( $g['prefix'] ) ) {
				$g['prefix'] = "$sanitizedName-";
			}

			// All messages are prefixed with their groupname
			$g['mangle'] = array( '*' );

			// Prevent E_NOTICE undefined index.
			// PremadeMediawikiExtensionGroups::factory should probably check this better instead
			if ( !isset( $g['ignored'] ) )  $g['ignored'] = array();
			if ( !isset( $g['optional'] ) )  $g['optional'] = array();

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
}
