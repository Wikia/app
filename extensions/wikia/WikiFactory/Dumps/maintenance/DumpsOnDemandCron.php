<?php
include __DIR__ . '/../../../../../maintenance/Maintenance.php';

class DumpsOnDemandCron extends Maintenance {

	use Wikia\Logger\Loggable;

    public function execute() {

        global $wgExternalSharedDB;

        $this->info( "Searching for dump requests to process." );

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
            $this->info( "No pending dump requests. Terminating." );
            exit( 0 );
        }

        global $IP, $wgWikiaLocalSettingsPath, $wgMaxShellTime, $wgMaxShellFileSize;

	    /**
	     * This prevents runBackups.php from timing out due to default values of $wgMaxShellTime used by wfShellExec()
	     *
	     * @see SUS-1395
	     */
	    $wgMaxShellTime     = 0;
	    $wgMaxShellFileSize	= 0;

	    $this->info( "Creating dumps for Wikia #{$sWikiaId}." );

        $sCommand = sprintf( 'SERVER_ID=%d php %s/extensions/wikia/WikiFactory/Dumps/runBackups.php --conf %s --id=%d --both --tmp --s3 2>&1', Wikia::COMMUNITY_WIKI_ID, $IP, $wgWikiaLocalSettingsPath, $sWikiaId );
		$this->info( "Running {$sCommand}" );

		$sOutput = wfShellExec( $sCommand, $iStatus );
		$this->info( "Command finished with exit code #{$iStatus}\n{$sOutput}\n" );

        $oDB = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

        if ( $iStatus > 0 ) {
			$this->error( __METHOD__ . ' - failed creating dumps', [
				'exception' => new Exception( $sCommand, $iStatus ),
				'output' => $sOutput,
			] );

            $this->error( "Failed creating dumps. Terminating." );
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
            exit( $iStatus );
        }

        $this->info( "Dumps completed. Updating the status of the request." );

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

        $this->info( "Done." );
        exit( 0 );
    }
}

$maintClass = DumpsOnDemandCron::class;
include RUN_MAINTENANCE_IF_MAIN;
