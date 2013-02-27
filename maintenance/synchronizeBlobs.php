<?php
/**
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
 *
 */

// TODO: find a way to create unittests for this?

require_once( dirname( __FILE__ ) . '/Maintenance.php' );
require_once( dirname( __FILE__ ) . '../extensions/wikia/Development/ExternalStoreDBFetchBlobHook.php'); // for BLOB fetcher

class SynchronizeBlobs extends Maintenance {
	var $context = null; // will this be needed?

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Synchronize blobs for latest revisions of pages from SJC to POZ (for devboxes)";
	}

	function latestRevisions() {
		$db = $this->getDB();
		// todo: get rows from join of page, revision, and perhaps text tables
		return array();
	}

	function renderArticle(&$article) {
		$artictle->fetchContent(); // todo: go deeper
	}

	function &loadArticle(&$revision_row) {
		$title = Title::newFromRow($revision_row);
		$article = Article::newFromTitle($title, $this->context);
		return $article;
	}

	public function execute() {
		$db = wfGetDB( DB_SLAVE );
		$this->setDB($db);
		$latest = latestRevisions();
		$total = count($latest);
		$done = 0;
		foreach ($latest as $revision_row) {
			$article = loadArticle($revision_row);
			$this->renderArticle($article);
			$done++;
			// TODO: hopefully, show progress and ETA
		}
	}
}

$maintClass = "SynchronizeBlobs";
require_once( RUN_MAINTENANCE_IF_MAIN );
