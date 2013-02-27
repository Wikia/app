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

require_once( dirname( __FILE__ ) . '/Maintenance.php' );
require_once( dirname( __FILE__ ) . '../extensions/wikia/Development/ExternalStoreDBFetchBlobHook.php'); // for BLOB fetcher

class SynchronizeBlobs extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Synchronize blobs for latest revisions of pages from SJC to POZ (for devboxes)";
	}

	function latestRevisions() {
		$db = $this->getDB();
		return array();
	}

	function renderArticle(&$article) {

	}

	function loadArticle($article) {

	}

	public function execute() {
		$db = wfGetDB( DB_SLAVE );
		$this->setDB($db);
		$latest = latestRevisions();
		$total = count($latest);
		foreach ($latest as $revision_row) {
			$article = loadArticle($revision_row);
			$this->renderArticle($article);
		}



		// TODO: show progress


	}

}

$maintClass = "SynchronizeBlobs";
require_once( RUN_MAINTENANCE_IF_MAIN );
