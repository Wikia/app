<?php
/**
 * Script to bootstrap translatetoolkit translation memory
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

/// Script to bootstrap translatetoolkit translation memory
class TMExport extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Script to export messages for translatetoolkit translation memory';
	}

	public function execute() {
		global $wgContLang;

		$dbw = TranslationMemoryUpdater::getDatabaseHandle();
		if ( $dbw === null ) {
			$this->error( "Database file not configured" );
			$this->exit();
		}
		$dbw->setFlag( DBO_TRX ); // HUGE speed improvement

		$groups = MessageGroups::singleton()->getGroups();
		// TODO: encapsulate list of valid language codes
		$languages = Language::getLanguageNames( false );
		unset( $languages['en'] );

		foreach ( $groups as $id => $group ) {
			if ( $group->isMeta() ) {
				continue;
			}

			$this->output( "Processing: {$group->getLabel()} ", $id );
			$capitalized = MWNamespace::isCapitalized( $group->getNamespace() );
			$ns_text = $wgContLang->getNsText( $group->getNamespace() );

			foreach ( $group->load( 'en' ) as $key => $definition ) {
				// TODO: would be nice to do key normalisation closer to the message groups, to avoid transforming back and forth.
				// But how to preserve the original keys...
				$key = strtr( $key, ' ', '_' );
				$key = $capitalized ? $wgContLang->ucfirst( $key ) : $key;

				$dbr = wfGetDB( DB_SLAVE );
				$tables = array( 'page', 'revision', 'text' );
				// selectFields to stfu Revision class
				$vars = array_merge( Revision::selectTextFields(), array( 'page_title' ), Revision::selectFields() );
				$conds = array(
					'page_latest = rev_id',
					'rev_text_id = old_id',
					'page_namespace' => $group->getNamespace(),
					'page_title ' . $dbr->buildLike( "$key/", $dbr->anyString() )
				);

				$res = $dbr->select( $tables, $vars, $conds, __METHOD__ );
				// Assure that there is at least one translation
				if ( $res->numRows() < 1 ) {
					continue;
				}

				$insert = array(
					'text' => $definition,
					'context' => "$ns_text:$key",
					'length' => strlen( $definition ),
					'lang' => 'en'
				);

				$source_id = $dbw->selectField( '`sources`', 'sid', $insert, __METHOD__ );
				if ( $source_id === false ) {
					$dbw->insert( '`sources`', $insert, __METHOD__ );
					$source_id = $dbw->insertId();
				}

				$this->output( ' ', $id );

				foreach ( $res as $row ) {
					list( , $code ) = TranslateUtils::figureMessage( $row->page_title );
					$revision = new Revision( $row );
					$insert = array(
						'text' => $revision->getText(),
						'lang' => $code,
						'time' => wfTimestamp(),
						'sid' => $source_id );
					// We only do SQlite which doesn't need to know unique indexes
					$dbw->replace( '`targets`', null, $insert, __METHOD__ );
				}
				$this->output( "{$res->numRows()}", $id );

			} // each translation>

			$dbw->commit();
		} // each group>
	}
}

$maintClass = 'TMExport';
require_once( DO_MAINTENANCE );
