<?php

require_once( dirname(__FILE__) . '/../Maintenance.php' );

class LyricFindReport extends Maintenance {
	const LF_SERVICE_ID = 21509;
	const LF_CLIENT_NAME = 'WIKIA';
	const EMAIL_FROM = 'moli@wikia-inc.com';
	
	private $table = '`statsdb`.`rollup_lyricwiki_pageviews`';
	private $debug = false;
	private $dir = '';
	private $file = '';
	private $zipfile = '';
	private $filename = '';  
	private $dbr = null;
	private $timeId = null;
	private $month = '';
	private $namespaceId = 0;
	private $condition = array();
	private $time_id = '';
	
	private $allowedNamespaces = [220, 222];
	
	/**
	 * Class constructor
	 *
	 * no params needed
	 * 
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'namespaces', 'Comma separated list of namespace' );
		$this->addOption( 'months', 'Comma separated list of months (YYYY-MM,YYYY-MM' );
		$this->addOption( 'emails', 'Send report to comma separeted list of emails' );
		$this->addOption( 'generate', 'Generate report for one month. This option has to be used with --months option' ); 
		$this->addOption( 'dir', 'Directory path for LyricFind reports');
		$this->addOption( 'debug', 'Enable debug option' );
		$this->mDescription = "Generate monthly PVs report for LyricFind";
	}

	/**
	 * Run maintenance script 
	 *
	 * no params needed
	 * 
	 */
	public function execute() {
		global $wgCityId, $wgWikiaLocalSettingsPath, $wgDWStatsDB;

		/* defaults */
		/*Boolean*/ $genMode = $debug = false;
		/*Array*/ $namespaces = $months = $emails = array();
		
		/* parse options */
		if ( $this->hasOption( 'generate' ) ) {
			$genMode = true;
		} 
		if ( $this->hasOption( 'namespaces' ) ) {
			$namespaces = array_map( 'trim', explode( ',', $this->getOption( 'namespaces' ) ) );
		} 
		if ( $this->hasOption( 'emails' ) ) {
			$emails = array_map( 'trim', explode( ',', $this->getOption( 'emails' ) ) );
		} 
		if ( $this->hasOption( 'months' ) ) {
			$months = array_map( 'trim', explode( ',', $this->getOption( 'months' ) ) );
		}
		if ( $this->hasOption( 'dir' ) ) {
			$this->dir = $this->getOption( 'dir' );
		}
		if ( $this->hasOption( 'debug' ) ) {
			$this->debug = true;
		}
	
		/* check the initial condtions */
		if ( empty( $months ) ) {
			$this->output( "Please give me at least one month \n" );
			exit(1);
		}
		if ( empty( $namespaces ) ) {
			$this->output( "Please give me at least one namespace \n" );
			exit(1);
		}
		if ( empty( $this->dir ) ) {
			$this->output( "Incorect name of directory for LyricFind report \n" );
			exit(1);		
		}
		
		/* iterate by month and generate file report */
		$this->output( sprintf( "Run script for %d months and %d namespaces... \n", count( $months ), count( $namespaces ) ) );
		$tStart = microtime( true );

		foreach ( $months as $this->month ) {
			list ( $_year, $_month ) = explode( "-", $this->month );
			$this->time_id = sprintf( '%s-01', $this->month );
			$csvrow = [];
							
			$this->dbr = wfGetDB(DB_SLAVE, array(), $wgDWStatsDB);
			$this->output( sprintf( "Run script for month: %s ... \n", $this->month ) );
			foreach ( $namespaces as $this->namespaceId ) {
				$this->output( sprintf( "Run script for namespace: %d ... \n", $this->namespaceId ) );

				if ( !in_array( $this->namespaceId, $this->allowedNamespaces ) ) {
					$this->output( "\tThis namespace is not allowed here\n" );
					continue;
				}

				$this->filename = sprintf( '%s_%02d_%04d_DISPLAY%s.csv', self::LF_CLIENT_NAME, $_month, $_year, ( $this->namespaceId == 220 ) ? 'GN' : '' );
				$this->file = sprintf( "%s/%s", $this->dir, $this->filename );
				
				# remove current file if exists 
				if ( file_exists( $this->file ) ) {
					unlink( $this->file );
				}
				
				$this->condition = [
					'period_id'    => DataMartService::PERIOD_ID_MONTHLY,
					'article_id > 0',
					'namespace_id' => $this->namespaceId,
					'time_id'      => sprintf( '%s 00:00:00', $this->time_id )
				];				
				# init variables
				$this->init();

				# get all stats
				$result = $this->dbr->select(
					array( $this->table ),
					array( "article_id, pageviews" ),
					$this->condition,
					__METHOD__
				);

				while ( $row = $this->dbr->fetchObject($result) ) {
					# display progress bar
					$this->progress( 1 );
					
					# check title exists
					$page = Article::newFromID( $row->article_id );
					if ( $this->debug ) {
						$this->output( "Parse article: " . $row->article_id . "\n" );
					}
					
					if ( is_null( $page ) ) {
						$this->output( "\tPage doesn't exist" );
						continue;
					}
					if ( $this->debug ) {
						$this->output( "\tParse page: " . $page->getTitle()->getText() . "\n" );
					}
					
					list( $song, $artist, $amgid, $gn_id ) = $this->extractParams( $page->getContent() );
					
					if ( $song && $artist && $amgid ) {
						$csvrow = [
							self::LF_SERVICE_ID,
							$this->time_id,
							$artist,
							$song,
							$row->pageviews,
							$amgid
						];
						if ( $this->namespaceId == 220 ) {
							array_push( $csvrow, $gn_id );
						}
					}
					
					$this->addToReport( $csvrow );
					unset( $csvrow );
					$csvrow = [];
				}
				$this->dbr->freeResult( $result );
			
				$this->compressReport();
				#$this->putToFTPServer();
				
				if ( !empty( $emails ) ) {
					$this->sendEmail( $emails );
				}
				
				# remove tmp files
				@unlink( $this->file );
				@unlink( $this->zipfile );
				
				$this->output( sprintf( "\nReport for month %s and namespace %d generated\n", $this->month, $this->namespaceId ) );
			}
		}
		$this->output( "Script finished after: " . date( "H:i:s", microtime(true) - $tStart ) . "\n" );
	}
	
	/**
	 * Init progress-bar
	 *
	 * no params needed
	 * 
	 */
	private function init() {
		$this->processed = 0;
		$this->startTime = wfTime();
		
		$this->count = $this->dbr->selectField( 
			$this->table, 
			"count(0)", 
			$this->condition, 
			__METHOD__ 
		);

		$this->ID = getmypid();
	}
		
	/**
	 * Display progress-bar 
	 *
	 * @param Integer|int $inc - increase the current position of the progress bar about $inc
	 * 
	 */
	private function progress( $inc ) {
		$this->processed += $inc;

		$portion = $this->processed / $this->count;

		$now = wfTime();
		$delta = $now - $this->startTime;
		$estimatedTotalTime = $delta / $portion;
		$eta = $this->startTime + $estimatedTotalTime;
		$rate = $this->processed / $delta;

		$this->output( 
			sprintf( "\t%s: %6.2f%% checked; ETA %s [%d/%d] %.2f/sec \n",
				wfTimestamp( TS_DB, intval( $now ) ),
				$portion * 100.0,
				wfTimestamp( TS_DB, intval( $eta ) ),
				$this->processed,
				$this->count,
				$rate 
			) 
		);
		flush();
	}
	
	/**
	 * Send email with report file 
	 *
	 * @param Array|array $emails - list of emails 
	 * 
	 */
	private function sendEmail( $emails ) {
		$magic = MimeMagic::singleton();
		$this->output( sprintf( "Send report to %s ", implode(", ", $emails ) ) );
		foreach ( $emails as $email ) {
			$this->output( "\tSendind to $email" );
			$fromAddress = new MailAddress( self::EMAIL_FROM );
			$toAddress = new MailAddress( $email );
			$body = sprintf( "LyricFind report for month %s. Report in attachment", $this->month );  
			$subject = sprintf( "LyricFind report for month %s", $this->month );
	
			if ( file_exists( $this->zipfile ) ) {
				$mime = $magic->guessMimeType( $this->zipfile );
				if ( $mime !== 'unknown/unknown' ) {
						# Get a space separated list of extensions
						$extList = $magic->getExtensionsForType( $mime );
						$ext_file = strtok( $extList, ' ' );
				} else {
						$mime = 'application/octet-stream';
				}
				$attachements = [ array( 'file' => $this->zipfile, 'mime' => $mime ) ];
			} else {
				$body .= "\nThere is no report for this month";
				$attachements = [];
			}
		
			$result = UserMailer::send( $fromAddress, $toAddress, $subject, $body, $fromAddress, null, 'LFReport', 0, $attachements );
			if ( !$result ) {
				$this->output( "\tCannot send email to $email\n" );
			}
			
			return $result;
		}
	}
	
	/**
	 * Add row to CSV report
	 *
	 * @param Array|array $row - one line of report, format: SERVICE_ID, YYYY-MM-DD, ARTIST, SONG, PVIEWS, TRACK_ID
	 * 
	 */
	private function addToReport( $row ) {
		wfMkdirParents( $this->dir );
		$fp = fopen( $this->file, 'a+');
		if ( !fputcsv($fp, $row, chr(9), chr(32)) ) {
			$this->output( "\tCannot save records in {$this->file}\n" );
			exit(1);
		}
		fclose($fp);
	}
	
	/**
	 * Pack CSV report to zip file
	 *
	 * no params needed
	 * 
	 */
	private function compressReport() {
		$this->output( "Compress report to zip file \n" );
		$zip = new ZipArchive();
		$this->zipfile = sprintf( "%s.zip", $this->file );
		if ( $zip->open( $this->zipfile,  ZipArchive::CREATE ) === true ) {
			$zip->addFile( $this->file, $this->filename );
			$zip->close();
			$this->output( "\tFile {$this->zipfile} created \n" );
		} else {
			$this->output( "\Cannot create {$this->zipfile} \n" );
		}
	}
	
	/*
	 * Parse LyricFind/Gracenote templates/tags to get song, artist, amgid
	 * 
	 * @param String|string $text - page content 
	 * 
	 */
	private function extractParams( $text ) {
		if ( $this->namespaceId == 222 /*LyricFind*/ ) {
			preg_match_all( '/(song|artist|amgid)\s*=(\d+|\s*[\"\'](.*?)[\"\'])/is', $text, $matches );
			
			$result = [];
			if ( !empty( $matches ) ) {
				$keys = array_flip( $matches[1] );
				$result = [
					$matches[2][$keys['song']],
					$matches[2][$keys['artist']],
					$matches[2][$keys['amgid']],
					0
				];
			}
		} elseif ( $this->namespaceId == 220 /*Gracenote*/ ) {
			preg_match_all( '/(song|artist|gracenoteid)\s*=\s*(\d+|[\"\'](.*?)[\"\']|\s*(.*?))\n/is', $text, $matches );

			$result = [];
			if ( !empty( $matches ) ) {
				$keys = array_flip( $matches[1] );
				
				$amgid = 0;
				if ( !empty( $matches[2][$keys['gracenoteid']] ) ) {
					$amgid = $this->getTrackIdFromGNId( $matches[2][$keys['gracenoteid']] );
				}
				
				$result = [
					$matches[2][$keys['song']],
					$matches[2][$keys['artist']],
					$amgid,
					$matches[2][$keys['gracenoteid']]
				];
			}
		}

		return $result;
	}
	
	/*
	 * Map Gracenote ID => LyricFind Track ID
	 * 
	 * @param String|string $gn_id - Gracenote ID
	 * 
	 */
	private function getTrackIdFromGNId( $gn_id ) {
		global $wgStatsDB;
		
		$dbh = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
		$amgid = $dbh->selectField( '`lyricfind`.`lf_gnlyricid`', "lyric_id", array( 'gn_id' => $gn_id ), __METHOD__ );
		
		return $amgid;
	}

	/*
	 * Upload report file to the FTP server
	 * 
	 * no params needed
	 * 
	 */
	private function putToFTPServer( ) {
		global $wgLyricFindAccount;
		
		$this->output( "Upload report file to the FTP server \n" );

		$this->output( "Connect to {$wgLyricFindAccount['host']} ... " );
		$conn_id = ftp_connect( $wgLyricFindAccount['host'] );
		if ( $conn_id ) {
			$this->output( "connected\n");
			$this->output( "Login to FTP account ... " );
			if ( @ftp_login( $conn_id, $wgLyricFindAccount['username'], $wgLyricFindAccount['password'] ) )  {
				$this->output( "done\n" );
				// upload a file
				$this->output( "Upload file {$this->zipfile} to FTP server ...  ");
				if ( @ftp_put( $conn_id, basename( $this->zipfile ), $this->zipfile, FTP_BINARY ) ) {
					$this->output( "done\n" );
				} else {
					$this->output( "failed\n" );
				}
			} else {
				$this->output( "failed\n" );
			}
			ftp_close($conn_id);
		} else {
			$this->output( "not connected\n");
		}
	}
}

$maintClass = "LyricFindReport";
require_once( DO_MAINTENANCE );
