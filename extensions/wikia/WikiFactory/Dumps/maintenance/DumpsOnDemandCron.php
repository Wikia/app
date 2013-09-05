<?php
class DumpsOnDemandCron extends Maintenance {
    
    const PIDFILE = '/var/run/MediaWikiDumpsOnDemandCron.pid';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function execute() {

        if ( file_exists( self::PIDFILE ) ) {
            // Another process already running.
            exit( 0 );
        }

        file_put_contents( self::PIDFILE, getmypid() );

        $oDB = wfGetDB( DB_SLAVE, array(), $wgSharedDB );
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
            // No pending requests.
            unlink( self::PIDFILE );
            exit( 0 );
        }
        
        global $IP, $wgWikiaLocalSettingsPath;
        
        $sCommand = sprintf( 'SERVER_ID=177 php %s/extensions/wikia/WikiFactory/Dumps/runBackups.php --conf %s --id=%d --both ', $IP, $wgWikiaLocalSettingsPath, $sWikiaId );
        
        wfShellExec( $sCommand, $iStatus );

        if ( $iStatus ) {
            unlink( self::PIDFILE );
            exit( $iStatus );
        }

        $oDB = wfGetDB( DB_MASTER, array(), $wgSharedDB );

        $oDB->update(
            'dumps',
            array( 'dump_completed' => wfTimestampNow() ),
            array(
                'dump_wiki_id' => $sWikiaId,
                'dump_completed IS NULL'
            ),
            __METHOD__
        );

        unlink( self::PIDFILE );
        exit( 0 );
    }
}

$maintClass = 'DumpsOnDemandCron';
include RUN_MAINTENANCE_IF_MAIN;
