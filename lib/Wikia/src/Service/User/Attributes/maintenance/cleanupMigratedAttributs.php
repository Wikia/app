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
 */

require_once( __DIR__ . '/../../../../../../../maintenance/Maintenance.php' );

class CleanupMigratedAttributes extends Maintenance {

    private $force;

    public function __construct() {
        parent::__construct();
        $this->addOption( 'force', "Actually remove attributes from sharedDB. Script defaults to dry-run" );
    }

    public function execute() {
        $this->force = $this->hasOption( 'force' );
        $this->printAttrsToBeDeleted();
        $this->deleteAttributes();
        $this->printSuccess();
    }

    private function printAttrsToBeDeleted() {
        global $wgPublicUserAttributes;
        $this->output( "Preparing to delete following attributes wikicities.user_properties:\n\n");
        $this->output( implode( $wgPublicUserAttributes, "\n" ) );
        $this->output( "\n\n" );
        if ( $this->force ) {
            $this->output( "NOT DRY RUN, ATTRIBUTES WILL BE DELETED\n" );
        }
        sleep(5);
    }
    
    private function deleteAttributes() {
        global $wgExternalSharedDB, $wgPublicAttributes;

        if ( !$this->force ) {
            return;
        }

        $db = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
        ( new WikiaSQL() )
            ->DELETE( 'user_properties' )
            ->WHERE( 'up_property' )->IN( $wgPublicAttributes )
            ->run( $db );
    }

    private function printSuccess() {
        $this->output( "Done!\n");
    }
}

$maintClass = CleanupMigratedAttributes::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
