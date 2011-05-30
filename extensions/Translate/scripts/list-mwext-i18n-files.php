<?php
/**
 * Script which lists required i18n files for mediawiki extensions.
 * Can be used to crate smaller and faster checkouts.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

// Standard boilerplate to define $IP
if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$dir = dirname( __FILE__ ); $IP = "$dir/../../..";
}
require_once( "$IP/maintenance/Maintenance.php" );

/// Script which lists required i18n files for MediaWiki extensions.
class MWExtFileList extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Script which lists required i18n files for mediawiki extensions';
		$this->addOption( 'path', 'List only files for given group path. Must match the path attribute of groups.', false, 'witharg' );
		$this->addOption( 'target', 'List only files missing from target. Defaults to path.', false, 'witharg' );
	}

	public function execute() {
		$this->files = array();
		$groups = MessageGroups::singleton()->getGroups();
		$target = $this->getOption( 'path' );
		foreach ( $groups as $group ) {
			if ( !$group instanceof ExtensionMessageGroup ) continue;
			if ( $target && $group->getPath() !== $target ) continue;
			$this->addPaths( $group->getMessageFile( 'en' ) );
			$this->addPaths( $group->getAliasFile( 'en' ) );
			$this->addPaths( $group->getMagicFile( 'en' ) );
		}

		$files = array_keys( $this->files );
		$this->output( trim( implode( "\n", $files ) . "\n" ) );
	}

	public function addPaths( $file ) {
		if ( $file === '' ) return;

		$target = $this->getOption( 'target', $this->getOption( 'path' ) );

		$paths = array();
		do {
			if ( file_exists( "$target/$file" ) ) break;
			$paths[] = $file;
			$file = dirname( $file );
		} while ( $file !== '.' && $file !== '' );

		// Directories first
		$paths = array_reverse( $paths );
		foreach ( $paths as $path ) {
			$this->files[$path] = true;
		}
	}
}

$maintClass = 'MWExtFileList';
require_once( DO_MAINTENANCE );
