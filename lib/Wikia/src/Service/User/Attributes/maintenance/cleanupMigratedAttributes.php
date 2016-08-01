<?php
/**
 * Remove migrated attribute values from sharedDB. These are user attributes which have been migrated
 * to the user attribute service. Any time we migrate additional attributes (eg, those found in 
 * $wgPrivateUserAttributes), we can run this script again to clean up those attributes from the
 * user_properties table in wikicities.
 *
 * Assumptions: The global variable $wgPublicUserAttributes is an array containing the names of
 * all fully migrated attributes. Do NOT add any attributes to that array unless you have fully
 * migrated all of its values from wikicities.user_properties to the attribute service.
 *
 * Script defaults to run as a dry run, ie, attributes are not actually deleted. To actually run
 * the deletion, pass "false" for the dryRun parameter. Eg:
 *
 * php cleanupMigratedAttributes.php --dryRun=false
 */

require_once( __DIR__ . '/../../../../../../../maintenance/Maintenance.php' );

class CleanupMigratedAttributes extends Maintenance {

    CONST BATCH_SIZE = 1000;

    private $dryRun;

    public function __construct() {
        parent::__construct();
        $this->addOption( 'dryRun', "Whether to actually remove attributes from sharedDB. Script defaults to dryRun = true (attributes not actually removed)" );
    }

    public function execute() {
        $this->dryRun = $this->getOption( 'dryRun' ) != "false";
        $this->printAttrsToBeDeleted();
        $this->deleteAttributes();
        $this->printSuccess();
    }

    private function printAttrsToBeDeleted() {
        global $wgPublicUserAttributes;
        $this->output( "Preparing to delete following attributes from wikicities.user_properties:\n\n");
        $this->output( implode( $wgPublicUserAttributes, "\n" ) );
        $this->output( "\n\n" );
        if ( !$this->dryRun ) {
            $this->output( "NOT DRY RUN, ATTRIBUTES WILL BE DELETED\n" );
        }
        $this->output( "Deletion will begin in 5 seconds...\n" );
        sleep( 5 );
    }
    
    private function deleteAttributes() {
        global $wgExternalSharedDB, $wgPublicUserAttributes;

        $db = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
        foreach ( $wgPublicUserAttributes as $attribute ) {
            $this->deleteAttribute( $attribute, $db );
        }
    }

    private function deleteAttribute( $attributeName, DatabaseMysqli $db ) {
        $this->output( "Deleting $attributeName\n" );

        if ( $this->dryRun ) {
            return;
        }

        $rowsRemaining = true;
        while ( $rowsRemaining ) {
            ( new WikiaSQL() )
                ->DELETE( 'user_properties' )
                ->WHERE( 'up_property' )->EQUAL_TO( $attributeName )
                ->ORDER_BY( 'up_user' )->DESC()
                ->LIMIT( self::BATCH_SIZE )
                ->run( $db );

            $rowsRemaining = $db->affectedRows() > 0;

            sleep( 2 );
        }
    }

    private function printSuccess() {
        $this->output( "Done!\n" );
    }
}

$maintClass = CleanupMigratedAttributes::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
