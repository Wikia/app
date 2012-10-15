<?php

/**
 * This class is for the actual spidering and will be calling wget
 */
$path = getenv('MW_INSTALL_PATH');
if (strval($path) === '') {
	$path = realpath( dirname(__FILE__) . '/../..' );
}

require_once "$path/maintenance/Maintenance.php";

class ArchiveLinksSpider extends Maintenance {

	/**
	 * @var DatabaseBase
	 */
	private $db_master, $db_slave;
	private $db_result;
	private $jobs;
	private $downloaded_files;

	/**
	 * Primary function called from Maintenance.php to run the actual spider.
	 * Queries the queue and then downloads and stores each link for which archival
	 * has been requested
	 *
	 * @global $wgArchiveLinksConfig array
	 * @global $wgLoadBalancer object
	 * @global $path string Install path of mediawiki
	 * @return bool
	 */
	public function execute( ) {
		global $wgArchiveLinksConfig;

		$this->db_master = $this->getDB(DB_MASTER);
		$this->db_slave = $this->getDB(DB_SLAVE);
		$this->db_result = array();

		if ( $wgArchiveLinksConfig['run_spider_in_loop'] ) {
			/* while ( TRUE ) {
			  if ( ( $url = $this->check_queue() ) !== false ) {

			  }
			  sleep(1);
			  } */
			die( 'Sorry, at the current time running the spider as a daemon isn\'t supported.' );
		} else {
			//for right now we will pipe everything through the replication_check_queue function just for testing purposes
			/*if ( $wgLoadBalancer->getServerCount() > 1 ) {
				if ( ( $url = $this->replication_check_queue() ) !== false ) {

				}
			  } else {
				if ( ( $url = $this->check_queue() ) !== false ) {

				}
			}*/

			if ( ( $url = $this->check_queue() ) !== false ) {
				if ( isset( $wgArchiveLinksConfig['download_lib'] ) ) {
					switch( $wgArchiveLinksConfig['download_lib'] ) {
						case 'curl':
							die( 'At the current time support for libcurl is not available.' );
						case 'wget':
						default:
							$this->call_wget( $url );
					}
				} else {
					$this->call_wget( $url );
				}
			}
		}
		return null;
	}

	/**
	 * This function goes and checks to make sure the configuration values are valid
	 * Then calls wget, finds the result and updates the appropiate database tables to
	 * record it.
	 *
	 * @global $wgArchiveLinksConfig array
	 * @global $path string
	 * @param $url string the URL that is to be archvied
	 */
	private function call_wget( $url ) {
		global $wgArchiveLinksConfig, $path;

		//Check Configuration
		if ( isset( $wgArchiveLinksConfig['file_types'] ) ) {
			if ( is_array( $wgArchiveLinksConfig['file_types']) ){
				$accept_file_types = '-A ' . implode( ',', $wgArchiveLinksConfig['file_types'] );
			} else {
				$accept_file_types = '-A ' . $wgArchiveLinksConfig['file_types'];
			}
		} else {
			//we should set a default, for now we will disable this for testing purposes, but this should be closed sometime later...
			$accept_file_types = '';
		}
		//At the current time we are only adding support for the local filestore, but swift support is something that will be added later
		//Add shutup operator for PHP notice, it's okay if this is not set as it's an optional config value
		switch( @$wgArchiveLinksConfig['filestore'] ) {
			case 'local':
			default:
				if ( isset( $wgArchiveLinksConfig['subfolder_name'] ) ) {
					$dir = $path . $wgArchiveLinksConfig['subfolder_name'];
				} elseif ( isset( $wgArchiveLinksConfig['content_path'] ) ) {
					$dir =  realpath( $wgArchiveLinksConfig['content_path'] );
					if ( !$dir ) {
						$this->error ( 'The path you have set for $wgArchiveLinksConfig[\'content_path\'] does not exist. ' .
							'This makes the spider a very sad panda. Please either create it or use a different setting.');
					}
				} else {
					$dir = $path . '/archived_content/';
				}
				$dir = $dir . sha1( time() . ' - ' . $url );
				mkdir( $dir, 0644, TRUE );
				$log_dir = $dir . '/log.txt';
				$log_dir_esc = escapeshellarg($log_dir);
				$dir = escapeshellarg( $dir );
				$sanitized_url = escapeshellarg( $url );
		}

		if ( ! isset( $wgArchiveLinksConfig['wget_quota'] ) ) {
			//We'll set the default max quota for any specific web page for 8 mb, which is kind of a lot but should allow for large images
			$wgArchiveLinksConfig['wget_quota'] = '8m';
		}

		if ( !isset( $wgArchiveLinksConfig['retry_times'] ) ) {
			//by default wget is set to retry something 20 times which is probably *way* too high for our purposes
			//this has the potential to really slow it down as --waitretry is set to 10 seconds by default, meaning that it would take
			//serveral minutes to go through all the retries which has the potential to stall the spider unnecessarily
			$wgArchiveLinksConfig['retry_times'] = '3';
		}


		//Do stuff with wget
		if ( isset( $wgArchiveLinksConfig['wget_path'] ) && file_exists( $wgArchiveLinksConfig['wget_path'] ) ) {
			die ( 'Support is not yet added for wget in a different directory' );
		} elseif ( file_exists( "$path/wget.exe" ) ) {
			wfShellExec( "cd $path" );
			//echo "\n\nwget.exe -nv -p -H -E -k -t {$wgArchiveLinksConfig['retry_times']} -Q{$wgArchiveLinksConfig['retry_times']} -o $log_dir -P $dir $accept_file_types $sanitized_url\n\n";
			wfShellExec( "wget.exe -nv -p -H -E -k -t {$wgArchiveLinksConfig['retry_times']} -Q {$wgArchiveLinksConfig['wget_quota']} -o $log_dir_esc -P $dir $accept_file_types $sanitized_url" );
			$this->parse_wget_log( $log_dir, $url );
			/*foreach( $this->downloaded_files as $file ) {
				if ( $file['status'] === 'success' ) {

				} elseif ( $file['status'] === 'failure' ) {
					echo 'bar';
				}
			}*/
			$this->db_master->insert( $this->downloaded_files[0]['url'] ); // FIXME: Missing parameters
		} else {
			//this is primarily designed with windows in mind and no built in wget, so yeah, *nix support should be added, in other words note to self...
			$this->error( 'wget must be installed in order for the spider to function in wget mode' );
		}
	}

	/**
	 * This function checks the archive queue without any attempt to work around replag.
	 * Only one URL is taken at a time.
	 *
	 * @return mixed The URL to archive on success, False on failure
	 */
	private function check_queue( ) {
		//need to fix this to use arrays instead of what I'm doing now
		$this->db_result['job-fetch'] = $this->db_slave->select( 'el_archive_queue', '*',
				array( 'delay_time' => ' >=' . time(), 'in_progress' => '0'),
				__METHOD__,
				array( 'ORDER BY' =>  'queue_id ASC', 'LIMIT' => '1' ));

		if ( $this->db_result['job-fetch']->numRows() > 0 ) {
			$row = $this->db_result['job-fetch']->fetchRow();

			//$this->delete_dups( $row['url'] );

			return $row['url'];
		} else {
			//there are no jobs to do right now
			return false;
		}
	}

	/**
	 * This function checks a local file for a local block of jobs that is to be done
	 * if there is none that exists it gets a block, creates one, and waits for the
	 * data to propagate to avoid any replag problems. All urls are not returned directly
	 * but are put into $this->jobs.
	 *
	 * @return bool
	 */
	private function replication_check_queue( ) {
		global $path, $wgArchiveLinksConfig;
		if ( file_exists( "$path/extensions/ArchiveLinks/spider-temp.txt" ) ) {
			$file = file_get_contents( "$path/extensions/ArchiveLinks/spider-temp.txt" );
			$file = unserialize( $file );
		} else {
			//we don't have any temp file, lets get a block of jobs to do and make one
			$this->db_result['job-fetch'] = $this->db_slave->select( 'el_archive_queue', '*',
					array(
						'delay_time <= "' . time() . '"',
						'in_progress' => '0')
					, __METHOD__,
					array(
						'LIMIT' => '15',
						'ORDER BY' => 'queue_id ASC'
					));
			//echo $this->db_result['job-fetch'];

			$this->jobs = array();

			$wait_time = wfGetLB()->safeGetLag( $this->db_slave ) * 3;
			$pid = (string) microtime() . ' - ' .  getmypid();
			$time = time();

			//echo $pid;

			$this->jobs['pid'] = $pid;
			$this->jobs['execute_time'] = $wait_time + $time;

			if ($this->db_result['job-fetch']->numRows() > 0) {
				//$row = $this->db_result['job-fetch']->fetchRow();
				while ( $row = $this->db_result['job-fetch']->fetchRow() ) {
					//var_export($row);

					if ( $row['insertion_time'] >= $row['insertion_time'] + $wait_time ) {
						if ( $row['in_progress'] === '0') {
							$retval = $this->reserve_job( $row );
						} else {
							//in_progress is not equal to 0, this means that the job was reserved some time before
							//it could have been by a previous instance of this spider (assuming not running in a loop)
							//or a different spider entirely, since we don't have have a temp file to go on we have to assume
							//it was a different spider (it could have been deleted by a user), we will only ignore the in_progress
							//lock if it has been a long time (2 hours by default) since the job was initally reserved
							$reserve_time = explode( ' ', $row['in_progress'] );
							$reserve_time = $reserve_time[2];

							isset( $wgArchiveLinksConfig['in_progress_ignore_delay'] ) ? $ignore_in_prog_time = $wgArchiveLinksConfig['in_progress_ignore_delay'] :
								$ignore_in_prog_time = 7200;

							if ( $time - $reserve_time - $wait_time > $ignore_in_prog_time ) {
								$retval = $this->reserve_job( $row );
							}
						}

					} else {
						//let's wait for everything to replicate, add to temp file and check back later
						$this->jobs[] = $row;
					}
				}
			}

			//var_dump( $this->jobs );

			$this->jobs = serialize( $this->jobs );
			//file_put_contents( "$path/extensions/ArchiveLinks/spider-temp.txt", $this->jobs );
		}

		if ( $retval !== true ) {
			$retval = false;
		}
		return $retval;
	}


	/**
	 * This function checks for duplicates in the queue table, if it finds one it keeps the oldest and deletes
	 * everything else.
	 *
	 * @param $url
	 */
	private function delete_dups( $url ) {
		//Since we querried the slave to check for dups when we insterted instead of the master let's check
		//that the job isn't in the queue twice, we don't want to archive it twice
		$this->db_result['dup-check'] = $this->db_slave->select('el_archive_queue', '*', array( 'url' => $url ), __METHOD__,
				array( 'ORDER BY' => 'queue_id ASC' ) );

		if ( $this->db_result['dup-check']->numRows() > 1 ) {
			//keep only the first job and remove all duplicates
			$this->db_result['dup-check']->fetchRow();
			while ( $del_row = $this->db_result['dup-check']->fetchRow() ) {
				echo 'you have a dup ';
				var_dump( $del_row );
				//this is commented for testing purposes, so I don't have to keep readding the duplicate to my test db
				//in other words this has a giant "remove before flight" ribbon hanging from it...
				//$this->db_master->delete( 'el_archive_queue', '`el_archive_queue`.`queue_id` = ' . $del_row['queue_id'] );
			}
		}
	}


	/**
	 * This function sets in_progess in the queue table to 1 so other instances of the spider know that
	 * the job is in the process of being archived.
	 *
	 * @param $row array The row of the database result from the database object.
	 * @return bool
	 */
	private function reserve_job( $row ) {
		// this function was pulled out of replication_check_queue, need to fix the vars in here
		$this->jobs['execute_urls'][] = $row['url'];
		$this->db_master->update( 'el_archive_queue', array( $row['in_progress'] => "\"{$this->jobs['pid']}\"" ), array( 'queue_id' => $row['queue_id'] ),
				__METHOD__ ) or die( 'can\'t reserve job' );
		$this->delete_dups( $row['url'] );
		return true;
	}

	/**
	 * Uses regular expressions to parse the log file of wget in non-verbose mode
	 * This is then returned to call_wget and updated in the db
	 *
	 * @param $log_path string Path to the wget log file
	 * @param $url string URL of the page that was archived
	 * @return array
	 */
	private function parse_wget_log( $log_path, $url ) {
		$fp = fopen( $log_path, 'r' ) or die( 'can\'t find wget log file to parse' );

		$this->downloaded_files = array ( );

		$line_regexes = array (
			'url' => '%^\d{4}-(?:\d{2}(?:-|:| )?){5}URL:(http://.*?) \[.+?\] ->%',
			'finish' => '%^Downloaded: \d+ files, (\d(?:.\d)?+(?:K|M)).*%',
			'sole_url' => '%^(http://.*):%',
			'error' => '%^\d{4}-(?:\d{2}-?){2} (?:\d{2}:?){3} ERROR (\d){3}:(.+)%',
			'quota_exceed' => '%^Download quota of .*? EXCEEDED!%',
			'finish_line' => '%^FINISHED --(\d{4}-(?:\d{2}(?:-|:| )){5})-%',
		);

		while ( $line = fgets( $fp ) ) {
			foreach( $line_regexes as $line_type => $regex ) {
				if ( preg_match( $regex, $line, $matches ) ) {
					switch ( $line_type ) {
						case 'url':
							$this->downloaded_files[] = array (
								'status' => 'success',
								'url' => $matches[1]
								);
							$last_line = 'url';
							break;
						case 'sole_url':
							$this->downloaded_files[] = array (
								'status' => 'failed',
								'url' => $matches[1]
								);
							break;
						case 'error':
							//this is a contination of the previous line, so just add stuff to that
							end( $this->downloaded_files );
							$array_key = key( $this->downloaded_files );
							$this->downloaded_files[$array_key]['error_code'] = $matches[1];
							$this->downloaded_files[$array_key]['error_text'] = $matches[2];
							break;
						case 'finish':
							$finish_time = $matches[1];
							break;
						case 'finish_line':
							//this is kind of useless, it contains the date/time stamp of when the download finished
							break;
						case 'quote_exceed':
							break;
						default:
							//we missed a line type, this is mainly for testing purposes and shouldn't happen when parsing the log
							echo "\n\nUNKNOWN LINE: $line\n\n";
							break;
					}
				}
			}
		}

		return $this->downloaded_files;
	}
}

$maintClass = 'ArchiveLinksSpider';
require_once RUN_MAINTENANCE_IF_MAIN;
