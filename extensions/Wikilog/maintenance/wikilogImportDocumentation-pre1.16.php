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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * @addtogroup Extensions
 * @author Juliano F. Ravasi < dev juliano info >
 */
$WIKILOGDIR = dirname( dirname( __FILE__ ) );
$MEDIAWIKIDIR = dirname( dirname( $WIKILOGDIR ) );

$optionsWithArgs = array();
require_once( "$MEDIAWIKIDIR/maintenance/commandLine.inc" );
require_once( "$MEDIAWIKIDIR/maintenance/rebuildrecentchanges.inc" );


/**
 * Wikilog documentation importer. Imports the Wikilog extension documentation
 * pages and images into the wiki.
 */
class WikilogDocImport
{

	protected $mFilename;			///< Import filename.
	protected $mFileHandle;			///< Open filename handle.
	protected $mDB;					///< Database link object.
	protected $mSource;				///< Import source object.
	protected $mImporter;			///< WikiImporter object.
	protected $mUser;				///< Importer user ("Wikilog auto").
	protected $mComment;			///< Comment ("Imported Wikilog doc...").
	protected $mTimestamp;			///< Timestamp.

	protected $mOverwriteFiles = false;	///< Whether files should be overwritten.

	protected $mStatPages, $mStatFiles;	///< Statistics.

	/**
	 * Constructor.
	 * @param $filename Import filename.
	 */
	public function __construct( $filename ) {
		$this->mFilename = $filename;
		$this->mFileHandle = fopen( $this->mFilename, 'rb' );
		if ( !$this->mFileHandle ) {
			throw new MWException( __CLASS__ . ": Failed to open {$this->mFilename}." );
		}

		$this->mDB = wfGetDB( DB_MASTER );
		$this->mSource = new ImportStreamSource( $this->mFileHandle );
		$this->mImporter = new WikiImporter( $this->mSource );

		$this->mUser = User::newFromName( wfMsgForContent( 'wikilog-auto' ), false );
		$this->mComment = wfMsgForContent( 'wikilog-doc-import-comment' );
		$this->mTimestamp = wfTimestampNow();

		$this->mImporter->setRevisionCallback( array( &$this, 'handleRevision' ) );
	}

	/**
	 * Destructor.
	 */
	public function __destruct() {
		fclose( $this->mFileHandle );
	}

	/**
	 * Acessor for the mOverwriteFiles property.
	 */
	public function OverwriteFiles( $x = null ) {
		wfSetVar( $this->mOverwriteFiles, $x );
	}

	/**
	 * Perform the documentation import.
	 */
	public function doImport() {
		global $wgUser;

		$wgUser = $this->mUser;

		$basefn = wfBasename( $this->mFilename );
		echo "+ Importing {$basefn}...\n";

		$this->mStatPages = 0;
		$this->mStatFiles = 0;
		$this->mImporter->doImport();

		echo "  + Done. {$this->mStatPages} page(s) and {$this->mStatFiles} file(s) imported.\n";
	}

	/**
	 * Perform recent changes update.
	 */
	public function updateRecentChanges() {
		echo "+ Rebuilding recent changes...\n";
		rebuildRecentChangesTable();
		echo "  + Done.\n";
	}

	/**
	 * Importer revision callback.
	 */
	public function handleRevision( $revision ) {
		$title = $revision->getTitle();
		$title_text = $title->getPrefixedText();

		if ( $title->getNamespace() == NS_FILE ) {
			$base = $title->getDBkey();
			echo "  + File: '{$base}'...";
			$image = wfLocalFile( $title );
			if ( !$image->exists() || $this->mOverwriteFiles ) {
				echo " uploading...";
				$filepath = dirname( $this->mFilename ) . '/' . $base;
				$archive = $image->upload( $filepath, $this->mComment,
					$revision->getText(), 0, false, $this->mTimeStamp,
					$this->mUser);

				if ( WikiError::isError( $archive ) || !$archive->isGood() ) {
					echo " failed.\n";
					return false;
				} else {
					echo " success.\n";
					$this->mStatFiles++;
					return true;
				}
			} else {
				echo " file exists, skipping.\n";
				return false;
			}
		} else {
			echo "  + Page: '{$title_text}'...\n";
			$revision->setUsername( $this->mUser->getName() );
			$revision->setComment( $this->mComment );
			$revision->setTimestamp( $this->mTimestamp );
			$result = $this->mDB->deadlockLoop( array( $revision, 'importOldRevision' ) );

			if ( $result ) { $this->mStatPages++; }
			return $result;
		}
	}

}


/**
 * Display a help message for the script.
 */
function showHelp() {
	echo <<<EOF
Usage: php wikilogImportDocumentation.php [OPTIONS]
Imports the documentation for the Wikilog extension.

Options:
  --overwrite       Overwrite existing files.
  --help            Displays this message and exit.

EOF;
}


# Generic title.
$wgTitle = Title::newFromText( "Wikilog documentation import script" );
$wgDBuser = $wgDBadminuser;
$wgDBpassword = $wgDBadminpassword;

# --help option: displays help message and exit.
if ( $options['help'] ) {
	showHelp();
	exit();
}

# If the wiki is in read-only state, die.
if( wfReadOnly() ) {
	wfDie( "Wiki is in read-only mode; you'll need to disable it for import to work.\n" );
}

# Load extension messages.
wfLoadExtensionMessages( 'Wikilog' );

# Perform import.
$i = new WikilogDocImport( $wgWikilogDocumentationXML );

if ( isset( $option['overwrite'] ) ) {
	$i->OverwriteFiles( true );
}

$i->doImport();
$i->updateRecentChanges();

exit();
