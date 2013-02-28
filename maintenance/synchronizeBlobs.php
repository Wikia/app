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

class SynchronizeBlobs extends Maintenance {
	var $wgFetchBlobApiURL = "http://community.wikia.com/api.php";
	var $store = null;
	var	$done = 0;
	var	$downloaded = 0;
	var $toDownload = 0;
	var $total = 0;
	var $startTime = 0;
	var $lastProgressTime = 0;
	var $clusters = array();
	var $progressPeriod;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Synchronize blobs for latest revisions of pages from SJC to POZ (for devboxes)";
		$this->addArg("progress", "How many seconds between each progress report (0 to disable). 30 is default", false);
	}

	public function execute() {
		$isPoznanDevbox = ( F::app()->wg->DevelEnvironment === true && F::app()->wg->WikiaDatacenter == "poz" );
		if (!$isPoznanDevbox) throw new Exception("This should be run within Poznan devel environment");
		$this->progressPeriod = $this->getArg(0, 30);
		$this->output("Getting ids of latest revisions.\n");
		$this->fetchLatestRevisions();
		$this->store = new ExternalStoreDB();
		$this->output("Creating list of blobs to download.\n");
		foreach ($this->clusters as $cluster => $ids) $this->filterBlobs($cluster, $ids);
		$this->output("Downloading ".$this->toDownload." out of total of ".$this->total." blobs.\n");
		$this->startTime = time();
		foreach ($this->clusters as $cluster => $ids) $this->fetchAndStoreBlobs($cluster, $ids);
		$this->showProgress();
	}


	function fetchLatestRevisions() {
		$db = $this->getDB(DB_SLAVE);
		$rows = $db->query("SELECT old_id, old_flags, old_text FROM page
											  INNER JOIN revision ON page_id=rev_page AND page_latest=rev_id
												INNER JOIN text ON rev_text_id=old_id",
											"SynchronizeBlobs::latestRevision");
		foreach ($rows as $row) {
			if (strpos($row->old_flags, "external") !== false) { // i know what to do with it
				if (preg_match("/DB:\/\/([^\/]+)\/([0-9]+)/", $row->old_text, $url)) {
					$this->clusters[$url[1]][] = $url[2];
				}
			} else {
				$flags = $row->old_flags;
				$id = $row->old_id;
				$this->output("Unexpected row $id with flags: $flags\n");
			}
		}
		unset($rows);
	}

	function filterBlobs($cluster, &$ids)	{
		$dbw = $this->store->getMaster( $cluster );
		if (!$dbw) throw new Exception("Could not get database for cluster $cluster");
		$table = $this->store->getTable( $dbw );
		sort($ids);
		$count = count($ids);
		$this->output("Filtering $count blobs for cluster $cluster ");
		$this->total += $count;
		$skip = array();
		$batch_size = 64;
		$offset = 0;
		while ($offset < $count) {
			$subset = array_slice($ids, $offset, $batch_size);
			$offset += $batch_size;
			$rows = $dbw->select($table, "blob_id", array("blob_id" => $subset));
			foreach ($rows as $row) $skip[intval($row->blob_id)] = true;
		}
		$needs_work = array();
		foreach ($ids as $id) if (!array_key_exists($id, $skip)) $needs_work[] = $id; // array_diff did not work correctly
		$count = count($needs_work);
		$this->toDownload += $count;
		$this->output("down to $count\n");
		if ($count==0) {
			unset($this->clusters[$cluster]);
		} else {
			$this->clusters[$cluster] = $needs_work;
		}
	}

	function fetchAndStoreBlobs($cluster, &$ids) {
		global $wgTheSchwartzSecretToken;
		$dbw = $this->store->getMaster( $cluster );
		if (!$dbw) throw new Exception("Could not get database for cluster $cluster");
		$table = $this->store->getTable( $dbw );
		$this->output("Downloading ".count($ids). " blobs for cluster $cluster.\n");

		foreach ($ids as $id) {
			$url = sprintf( "%s?action=fetchblob&store=%s&id=%d&token=%s&format=json", $this->wgFetchBlobApiURL,	$cluster,	$id,$wgTheSchwartzSecretToken	);
			$response = json_decode( Http::get( $url, "default", array( 'noProxy' => true ) ) );

			if( isset( $response->fetchblob ) ) {
				$blob = isset( $response->fetchblob->blob ) ? $response->fetchblob->blob : false;
				$hash = isset( $response->fetchblob->hash ) ? $response->fetchblob->hash : null;
				if( $blob ) {
					// pack to binary
					$blob = pack( "H*", $blob );
					$hash = md5( $blob );
					// check md5 sum for binary
					if(  $hash == $response->fetchblob->hash ) {
						$ret = $blob;
						$insert_ok = $dbw->insert($table,	array( "blob_id" => $id, "blob_text" => $ret ),	__METHOD__ );
																			//array('IGNORE'));
						if (!$insert_ok) print $dbw->lastError();
						$dbw->commit();
						$this->downloaded++;
					}	else {
						$this->output("md5 sum not match, $hash != $response->fetchblob->hash\n");
					}
				}
			}	else {
				$this->output("malformed response from API call\n" );
			}
			$this->done++;
			$this->showProgress();
		}
	}

	function getNiceDuration($durationInSeconds) {
		$duration = '';
		$days = floor($durationInSeconds / 86400);
		$durationInSeconds -= $days * 86400;
		$hours = floor($durationInSeconds / 3600);
		$durationInSeconds -= $hours * 3600;
		$minutes = floor($durationInSeconds / 60);
		$seconds = floor($durationInSeconds - $minutes * 60);

		if($days > 0) {
			$duration .= $days . ' day' . ($days>1?"s":"");
		}
		if($hours > 0) {
			$duration .= ' ' . $hours . ' hour' . ($hours>1?"s":"");
		}
		if($minutes > 0) {
			$duration .= ' ' . $minutes . ' minute' . ($minutes>1?"s":"");
		}
		$duration .= ' ' . $seconds . ' second' . ($seconds!=1?"s":"");
		return $duration;
	}

	public function getETA() {
		$elapsed = time() - $this->startTime;
		if ($elapsed < 1) return " unknown";
		$speed = (float)($this->done) / (float)($elapsed);
		$left = ($this->toDownload - $this->done) / $speed;
		return $this->getNiceDuration($left);
	}

	public function showProgress() {
		if ($this->progressPeriod == 0) return;
		if ($this->lastProgressTime) {
			if ($this->lastProgressTime + $this->progressPeriod > time()) return;
			$this->output("Processeed ".$this->done." (".($this->downloaded==$this->done?"all":$this->downloaded)." successfully) out of ".$this->toDownload. " to download in".
										$this->getNiceDuration(time() - $this->startTime). ", ".
										($this->done < $this->toDownload ? "remaining time:".$this->getETA() : "finished")."\n");
		}
		$this->lastProgressTime = time();
	}
}


$maintClass = "SynchronizeBlobs";
require_once( RUN_MAINTENANCE_IF_MAIN );
