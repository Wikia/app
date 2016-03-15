<?php
include __DIR__ . '/../../../../../maintenance/Maintenance.php';

class DumpsOnDemandCron extends Maintenance {

    const PIDFILE = '/var/run/MediaWikiDumpsOnDemandCron.pid';

    public function execute() {

        global $wgExternalSharedDB;

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

        $oDB = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
        $sWikiaId = (string) $oDB->selectField(
                'dumps',
                'dump_wiki_id',
                array( 'dump_completed IS NULL', 'dump_hold' => 'N' ),
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

        $sCommand = sprintf( 'SERVER_ID=%d php %s/extensions/wikia/WikiFactory/Dumps/runBackups.php --conf %s --id=%d --both --tmp --s3 2>&1', Wikia::COMMUNITY_WIKI_ID, $IP, $wgWikiaLocalSettingsPath, $sWikiaId );
		$sOutput = wfShellExec( $sCommand, $iStatus );

        $oDB = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		$logger = Wikia\Logger\WikiaLogger::instance();

        if ( $iStatus > 0 ) {
			$logger->error( __METHOD__ . ' - failed creating dumps', [
				'exception' => new Exception( $sCommand, $iStatus ),
				'output' => $sOutput,
			] );

            $this->output( "ERROR: Failed creating dumps. Terminating.\n" );
            $oDB->update(
                'dumps',
                array(
                    'dump_compression' => DumpsOnDemand::DEFAULT_COMPRESSION_FORMAT,
                    'dump_hold' => 'Y',
                    'dump_errors' => wfTimestampNow()
                ),
                array(
                    'dump_wiki_id' => $sWikiaId,
                    'dump_completed IS NULL',
                    'dump_hold' => 'N'
                ),
                __METHOD__
            );
            unlink( self::PIDFILE );
            exit( $iStatus );
        }

        $this->output( "INFO: Dumps completed. Updating the status of the request.\n" );

        $oDB->update(
            'dumps',
            array(
                'dump_completed' => wfTimestampNow(),
                'dump_compression' => DumpsOnDemand::DEFAULT_COMPRESSION_FORMAT,
            ),
            array(
                'dump_wiki_id' => $sWikiaId,
                'dump_completed IS NULL',
                'dump_hold' => 'N'
            ),
            __METHOD__
        );

        DumpsOnDemand::purgeLatestDumpInfo( intval( $sWikiaId ) );

        $this->output( "Done.\n" );
        unlink( self::PIDFILE );
        exit( 0 );
    }
}

$maintClass = DumpsOnDemandCron::class;
include RUN_MAINTENANCE_IF_MAIN;
