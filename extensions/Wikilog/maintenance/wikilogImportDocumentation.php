<?php
/**
 * MediaWiki Wikilog extension
 * Copyright © 2008-2010 Juliano F. Ravasi
 * http://www.mediawiki.org/wiki/Extension:Wikilog
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * @file
 * @ingroup Extensions
 * @author Juliano F. Ravasi < dev juliano info >
 */

# Wikilog and MediaWiki directories. Valid only if extension was installed in
# the recomended directory ($IP/extensions/Wikilog).
$WIKILOGDIR = dirname( dirname( __FILE__ ) );
$MEDIAWIKIDIR = dirname( dirname( $WIKILOGDIR ) );

# Wikilog documentation source file.
$wgWikilogDocumentationXML = "$WIKILOGDIR/documentation/documentation.xml";

# Compatibility with MediaWiki < 1.16.
if ( !file_exists( "$MEDIAWIKIDIR/maintenance/Maintenance.php" ) ) {
	die( "MediaWiki 1.16 or later is required." );
}

# Maintenance scripts base class.
require_once( "$MEDIAWIKIDIR/maintenance/Maintenance.php" );


/**
 * Wikilog documentation importer. Imports the Wikilog extension documentation
 * pages and images into the wiki.
 */
class WikilogImportDocumentation
	extends Maintenance
{

	protected $mFilename;			///< Import filename.
	protected $mFileHandle;			///< Open filename handle.
	protected $mDB;					///< Database link object.
	protected $mSource;				///< Import source object.
	protected $mImporter;			///< WikiImporter object.
	protected $mUser;				///< Importer user ("Wikilog auto").
	protected $mComment;			///< Comment ("Imported Wikilog doc...").
	protected $mTimestamp;			///< Timestamp.

	protected $mStatPages, $mStatFiles;	///< Statistics.

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Imports the documentation for the Wikilog extension";
		$this->addOption( 'overwrite', "Overwrite existing files" );
	}

	public function execute() {
		global $wgTitle, $wgWikilogDocumentationXML;
		$wgTitle = Title::newFromText( "Wikilog documentation import script" );

		# Check dependencies.
		$this->checkDependencies();

		# If the wiki is in read-only state, die.
		if ( wfReadOnly() ) {
			$this->error( "Wiki is in read-only mode; you'll need to disable it for import to work.\n", true );
		}

		# Perform import.
		$this->doImport( $wgWikilogDocumentationXML );

		# Update recent changes table.
		$this->updateRecentChanges();
	}

	/**
	 * Check if all dependencies for documentation are met.
	 */
	protected function checkDependencies() {
		$errors = 0;

		# ParserFunctions extension.
		if ( !class_exists( 'ExtParserFunctions' ) ) {
			$this->error( "Error: Wikilog documentation requires the ParserFunctions extension." );
			$this->error( "  * http://www.mediawiki.org/wiki/Extension:ParserFunctions" );
			$errors++;
		}

		if ( $errors ) {
			$this->error( "Some requirements were not met. Exiting.", true );
		}
	}

	/**
	 * Perform the documentation import.
	 * @param $filename Import filename.
	 */
	protected function doImport( $filename ) {
		global $wgUser;

		$this->mFilename = $filename;
		$this->mFileHandle = fopen( $this->mFilename, 'rb' );
		if ( !$this->mFileHandle ) {
			throw new MWException( __CLASS__ . ": Failed to open {$this->mFilename}." );
		}

		$this->mDB = wfGetDB( DB_MASTER );
		$this->mSource = new ImportStreamSource( $this->mFileHandle );
		$this->mImporter = new WikiImporter( $this->mSource );

		$this->mUser = User::newFromName( wfMsgForContent( 'wikilog-auto' ), false );
		$wgUser = $this->mUser;

		$this->mComment = wfMsgForContent( 'wikilog-doc-import-comment' );
		$this->mTimestamp = wfTimestampNow();

		$this->mImporter->setRevisionCallback( array( &$this, 'handleRevision' ) );

		$basefn = wfBasename( $this->mFilename );
		$this->output( "+ Importing {$basefn}...\n" );

		$this->mStatPages = 0;
		$this->mStatFiles = 0;
		$this->mImporter->doImport();

		$this->output( "  + Done. {$this->mStatPages} page(s) and {$this->mStatFiles} file(s) imported.\n" );
		fclose( $this->mFileHandle );
	}

	/**
	 * Perform recent changes update.
	 */
	protected function updateRecentChanges() {
		$this->output("+ Rebuilding recent changes...\n");
		$this->runChild( 'RebuildRecentchanges', 'rebuildrecentchanges.php' );
		$this->output("  + Done.\n");
	}

	/**
	 * Importer revision callback.  Called from WikiImporter.
	 */
	public function handleRevision( $revision ) {
		$title = $revision->getTitle();
		$title_text = $title->getPrefixedText();

		if ( $title->getNamespace() == NS_FILE ) {
			$base = $title->getDBkey();
			$this->output( "  + File: '{$base}'..." );
			$image = wfLocalFile( $title );
			if ( !$image->exists() || $this->getOption( 'overwrite' ) ) {
				$this->output( " uploading..." );
				$filepath = dirname( $this->mFilename ) . '/' . $base;
				$archive = $image->upload( $filepath, $this->mComment,
					$revision->getText(), 0, false, $this->mTimestamp,
					$this->mUser);

				if ( !$archive->isGood() ) {
					$this->output( " failed.\n" );
					return false;
				} else {
					$this->output( " success.\n" );
					$this->mStatFiles++;
					return true;
				}
			} else {
				$this->output( " file exists, skipping.\n" );
				return false;
			}
		} else {
			$this->output( "  + Page: '{$title_text}'...\n" );
			$revision->setUsername( $this->mUser->getName() );
			$revision->setComment( $this->mComment );
			$revision->setTimestamp( $this->mTimestamp );
			$result = $this->mDB->deadlockLoop( array( $revision, 'importOldRevision' ) );

			if ( $result ) { $this->mStatPages++; }
			return $result;
		}
	}

}

$maintClass = "WikilogImportDocumentation";
require_once( DO_MAINTENANCE );
