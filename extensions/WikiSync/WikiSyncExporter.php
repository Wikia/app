<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of WikiSync.
 *
 * WikiSync is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * WikiSync is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WikiSync; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * WikiSync allows an AJAX-based synchronization of revisions and files between
 * global wiki site and it's local mirror.
 *
 * To activate this extension :
 * * Create a new directory named WikiSync into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/WikiSync/WikiSync.php";
 *
 * @version 0.3.2
 * @link http://www.mediawiki.org/wiki/Extension:WikiSync
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is a part of MediaWiki extension.\n" );
}

class WikiSyncExporter extends WikiExporter {

	function __construct( &$db ) {
		parent::__construct( $db, WikiExporter::FULL );
	}

	/**
	 * include stylesheets and scripts; set javascript variables
	 * @param $dbres - database results (joined rows from revision, page and text tables)
	 * @return string xml dump of selected revisions
	 */
	function dumpDBresult( $dbres ) {
		// WikiExporter writes to stdout, so catch its
		// output with an ob
		ob_start();
		$this->openStream();
		$wrapper = $this->db->resultObject( $dbres );
		# Output dump results
		$this->outputPageStream( $wrapper );
/*
		if( $this->list_authors ) {
			$this->outputPageStream( $wrapper );
		}
*/
		$this->closeStream();
		$exportxml = ob_get_contents();
		ob_end_clean();
		return $exportxml;
	}

} /* end of WikiSyncExporter class */

class WikiSyncImportReporter extends ImportReporter {
	private $mResultArr = array();

	function reportPage( $title, $origTitle, $revisionCount, $successCount, $pageInfo = '' ) {
		// Add a result entry
		$r = array();
		ApiQueryBase::addTitleInfo($r, $title);
		$r['revisions'] = intval($successCount);
		$this->mResultArr[] = $r;

		# call the parent to do the logging
		# avoid bug in 1.15.4 Special:Import (new file page text without the file uploaded)
		# PHP Fatal error:  Call to a member function insertOn() on a non-object in E:\www\psychologos\includes\specials\SpecialImport.php on line 334
		// do not create informational null revisions
		// because they are placed on top of real user made revisions,
		// making the binary search algorithm used to compare local and remote revs to fail
		// TODO: change the binary search algorithm to two/three level hashes
		if ( WikiSyncSetup::$report_null_revisions && $title->getArticleId() !== 0 ) {
			parent::reportPage( $title, $origTitle, $revisionCount, $successCount, $pageInfo );
		}
	}

	function getData() {
		return $this->mResultArr;
	}

} /* end of WikiSyncImportReporter class */
