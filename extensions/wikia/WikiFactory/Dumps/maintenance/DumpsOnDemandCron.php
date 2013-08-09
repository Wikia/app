<?php
class DumpsOnDemandCron extends Maintenance {
    
    const PIDFILE = '/var/run/MediaWikiDumpsOnDemandCron.pid';
    
    protected $iPid;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function execute() {
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
            return null;
        }
        
        global $IP, $wgWikiaLocalSettingsPath;
        
        $sCommand = sprintf( 'SERVER_ID=177 php %s/extensions/wikia/WikiFactory/Dumps/runBackups.php --conf %s --id=%d --both ');
        
        wfShellExec( $sCommand, $iStatus );

        if ( $iStatus ) {
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
    }
}

$maintClass = 'DumpsOnDemandCron';
include RUN_MAINTENANCE_IF_MAIN;
