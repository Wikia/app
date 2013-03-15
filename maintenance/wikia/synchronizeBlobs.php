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

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );
define("MW_CONFIG_FILE", "/usr/wikia/conf/current/wiki.factory/LocalSettings.php"); // lazy but useful

class SynchronizeBlobs extends Maintenance {
	public $wgFetchBlobApiURL = "http://community.wikia.com/api.php";
	public $store = null;
	public $done = 0;
	public $downloaded = 0;
	public $toDownload = 0;
	public $total = 0;
	public $startTime = 0;
	public $lastProgressTime = 0;
	public $clusters = array();
	public $progressPeriod;
	public $pageNamespace;
	public $procCount;
	public $isChild = false;
	public $children;
	public $sockets = array();
	public $channel;
	public $childNumber = 0;
	public $outBuffer = "";

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Synchronize blobs for latest revisions of pages from SJC to POZ (for devboxes). Run on a POZ devbox.";
		$this->addOption("progress", "How many seconds between each progress report (0 to disable). 30 is default", false, true);
		$this->addOption("namespace", "Limit to only pages from a specific namespace id (0 for main)", false, true);
		$this->addOption("procs", "Use n background processes (default - everything in foreground)", false, true);
	}

	public function execute() {
		global $oWiki;
		$isPoznanDevbox = ( F::app()->wg->DevelEnvironment === true && F::app()->wg->WikiaDatacenter == "poz" );
		if (!$isPoznanDevbox) throw new Exception("This should be run within Poznan devel environment");
		$this->progressPeriod = $this->getOption("progress", 30);
		$this->pageNamespace = $this->getOption("namespace", "");
		$this->procCount = $this->getOption("procs", 0);
		if (!is_numeric($this->progressPeriod)) {
			throw new Exception("Invalid 'progress' parameter: $this->progressPeriod");
		}
		if ($this->pageNamespace!=="" && !is_numeric($this->pageNamespace)) {
			throw new Exception("Invalid 'namespace' parameter: $this->pageNamespace");
		}
		if (!is_numeric($this->procCount)) {
			throw new Exception("Invalid 'procs' parameter: $this->procCount");
		}
		$this->output("Getting ids of latest revisions for city_id=$oWiki->mCityID, ".
									"city_dbname=$oWiki->mCityDB, ".
									"namespace=".	(($this->pageNamespace==="") ? "any" : $this->pageNamespace) . "\n");
		$this->fetchLatestRevisions();
		$this->store = new ExternalStoreDB();
		$this->output("Creating list of blobs to download.\n");
		foreach ($this->clusters as $cluster => $ids) {
			$this->filterBlobs($cluster, $ids);
		}
		if ($this->toDownload) {
			$this->startTime = time();
			$this->output("Downloading ".$this->toDownload." out of total of ".$this->total." blobs.\n");
			if ($this->procCount) {
				$this->executeFork();
			} else {
				$this->executeWorker();
			}
			$this->showProgress();
		} else {
			$this->output("Nothing to do, finished\n");
		}
	}
	function executeFork() {
		$this->output("Spawning $this->procCount child processes.\n");
		$this->children = array();
		for($fork = 0; ($fork < $this->procCount); $fork++) {
			$ok = socket_create_pair(AF_UNIX, SOCK_STREAM, 0, $fd);
			if (!$ok) throw new Exception("Could not create UNIX socket");
			$pid=pcntl_fork();
			if ($pid==0) {
				$this->isChild = true;
				foreach ($this->sockets as $old) socket_close($old);
				socket_close($fd[0]);
				break;
			} else {
				if ($pid==-1) throw new Exception("Could not fork");
				socket_close($fd[1]);
				$this->children[] = $pid;
				$this->sockets[] = $fd[0];
			}
		}
		if ($this->isChild) {
			$this->childNumber = $fork;
			$this->channel = $fd[1];
			$this->executeWorker();
			socket_close($this->channel);
		} else {
			$this->executeParent();
		}
	}
	function executeParent() {
		$timeout = $this->progressPeriod ? $this->progressPeriod : null;
		while(true) {
			$this->showProgress();
			$read_fds = $this->sockets;
			$write_fds = array();
			$exc_fds = array();
			socket_select($read_fds, $write_fds, $exc_fds, $timeout);
			foreach ($read_fds as $fd) {
				$buf = socket_read($fd, 255);
				if (is_string($buf) &&  strlen($buf)) {
					$this->addChildProgress($buf);
					if ($this->done==$this->toDownload) break;
				} else {
					$this->output("WARNING: Child finished unexpectedly!\n");
					$key = array_search($fd, $this->sockets);
					unset($this->sockets[$key]);
					$this->sockets = array_values($this->sockets);
					if (count($this->sockets)==0) return;
				}
			}
		}
		foreach ($this->children as $pid) pcntl_waitpid($pid, $status);
	}
	function addChildProgress($buf) {
		$this->done += strlen($buf);
		$this->downloaded += substr_count($buf, "+");
	}
	function executeWorker() {
		foreach ($this->clusters as $cluster => $ids) {
			$this->fetchAndStoreBlobs($cluster, $ids);
		}
	}
	function fetchLatestRevisions() {
		$db = $this->getDB(DB_SLAVE);
		/*$rows = $db->query("SELECT old_id, old_flags, old_text FROM page
											  INNER JOIN revision ON page_id=rev_page AND page_latest=rev_id
												INNER JOIN text ON rev_text_id=old_id" . $where,
											"SynchronizeBlobs::latestRevision");*/
		$rows = $db->select(array("page", "revision", "text"),
												array("old_id", "old_flags", "old_text"),
												($this->pageNamespace==="") ? array() : array("page_namespace" => $this->pageNamespace),
												__METHOD__,
												array(),
												array('revision' => array('INNER JOIN','page_id=rev_page AND page_latest=rev_id'),
															'text' => array('INNER JOIN','rev_text_id=old_id')));
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
		$this->output("down to $count.\n");
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
		if ($this->childNumber==0) $this->output("Staring work on cluster $cluster (".count($ids). " blobs).\n");

		foreach ($ids as $index => $id) {
			if ($this->isChild && ($index % $this->procCount)!=$this->childNumber) continue; // split work deterministically, if a little bit unfairly ;)
			$sent = false;
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
						$dbw->begin();
						$error = false;
						try {
							$insert_ok = $dbw->insert($table,	array( "blob_id" => $id, "blob_text" => $ret ),	__METHOD__);
							if ($insert_ok) {						
								$dbw->commit();
								$this->downloaded++;
								if ($this->isChild) {
									socket_write($this->channel,"+");
								}
								$sent = true;
							} else {
								$error = $dbw->lastError();
							}
						} catch (Exception $e) {
							$error = $e;
						}
						if ($error) {
							print "Warning: Could not save blob $id on cluster $cluster: $error\n";
							$dbw->rollback();							
						}
					}	else {
						$this->output("md5 sum not match, $hash != $response->fetchblob->hash\n");
					}
				}
			}	else {
				$this->output("malformed response from API call\n" );
			}
			$this->done++;
			if ($this->isChild && !$sent) socket_write($this->channel, "-");
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
	public function showProgress() {
		if ($this->isChild || $this->progressPeriod == 0) return;
		if ($this->lastProgressTime) {
			if ($this->lastProgressTime + $this->progressPeriod > time()) return;
			$elapsed = time() - $this->startTime;
			if ($elapsed < 1) $eta = " unknown";
			$speed = (float)($this->done) / (float)($elapsed);
			if ($speed>0) {
				$left = ($this->toDownload - $this->done) / $speed;
				$eta = $this->getNiceDuration($left);
			} else {
				$eta = " unknown";
			}
			$this->output("Processeed ".$this->done." (".($this->downloaded==$this->done?"all":$this->downloaded)
				." successfully) out of ".$this->toDownload. " to download in".
				$this->getNiceDuration(time() - $this->startTime). ", ".
				($this->done < $this->toDownload ? "remaining time:".$eta.
				 " (average speed ".round($speed,2)." / s)" : "finished")."\n");
		}
		$this->lastProgressTime = time();
	}
}


$maintClass = "SynchronizeBlobs";
require_once( RUN_MAINTENANCE_IF_MAIN );
