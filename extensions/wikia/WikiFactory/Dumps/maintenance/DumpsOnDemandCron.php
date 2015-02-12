<?php
include __DIR__ . '/../../../../../maintenance/Maintenance.php';

class DumpsOnDemandCron extends Maintenance {
    
    const PIDFILE = '/var/run/MediaWikiDumpsOnDemandCron.pid';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function execute() {

        if ( file_exists( self::PIDFILE ) ) {
                $sPid = file_get_contents( self::PIDFILE );
                // Another process already running.
                if ( file_exists( "/proc/{$sPid}" ) ) {
                        $this->output( "INFO: Another process already running. Terminating.\n" );
                        exit( 0 );
                }
                $this->output( "WARNING: No process in pidfile found running.\n" );
        }

        file_put_contents( self::PIDFILE, getmypid() );

        $this->output( "INFO: Searching for dump requests to process.\n" );

        $oDB = wfGetDB( DB_SLAVE, array(), 'wikicities' );
        $sWikiaId = (string) $oDB->selectField(
                'dumps',
                'dump_wiki_id',
                array( 'dump_completed IS NULL' ),
                __METHOD__,
                array(
                    'ORDER BY' => 'dump_requested ASC',
                    'LIMIT' => 1
                )
        );

        if ( !$sWikiaId ) {
            $this->output( "INFO: No pending dump requests. Terminating.\n" );
            unlink( self::PIDFILE );
            exit( 0 );
        }

        global $IP, $wgWikiaLocalSettingsPath;

        $this->output( "INFO: Creating dumps for Wikia #{$sWikiaId}.\n" );

        $sCommand = sprintf( 'SERVER_ID=177 php %s/extensions/wikia/WikiFactory/Dumps/runBackups.php --conf %s --id=%d --both --tmp --s3', $IP, $wgWikiaLocalSettingsPath, $sWikiaId );

        wfShellExec( $sCommand, $iStatus );

        if ( $iStatus ) {
            $this->output( "ERROR: Failed creating dumps. Terminating.\n" );
            unlink( self::PIDFILE );
            exit( $iStatus );
        }

        $this->output( "INFO: Dumps completed. Updating the status of the request.\n" );

        $oDB = wfGetDB( DB_MASTER, array(), 'wikicities' );

        $oDB->update(
            'dumps',
            array(
                'dump_completed' => wfTimestampNow(),
                'dump_compression' => DumpsOnDemand::DEFAULT_COMPRESSION_FORMAT,
            ),
            array(
                'dump_wiki_id' => $sWikiaId,
                'dump_completed IS NULL'
            ),
            __METHOD__
        );

        DumpsOnDemand::purgeLatestDumpInfo(intval($sWikiaId));

        $this->output( "Done.\n" );
        unlink( self::PIDFILE );
        exit( 0 );
    }
}

$maintClass = 'DumpsOnDemandCron';
include RUN_MAINTENANCE_IF_MAIN;
