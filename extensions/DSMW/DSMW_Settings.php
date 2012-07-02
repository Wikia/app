<?php
/**
 * @copyright INRIA-LORIA-ECOO project
 * @author jean-philippe muller
 */

# create namespace
define( "PATCH", 110 );
define( "PUSHFEED", 200 );
define( "PULLFEED", 210 );
define( "CHANGESET", 220 );

define( 'INT_MAX', '1000000000000000000000' ); // 22
define( 'INT_MIN', '0' );

$wgExtraNamespaces[PATCH] = "Patch";
$wgExtraNamespaces[PUSHFEED] = "PushFeed";
$wgExtraNamespaces[PULLFEED] = "PullFeed";
$wgExtraNamespaces[CHANGESET] = "ChangeSet";
# protect namespace
$wgNamespaceProtection[PATCH] = Array( "editpatch" );
$wgNamespacesWithSubpages[PATCH] = true;
$wgGroupPermissions['*']['editpatch'] = false;
$wgGroupPermissions['sysop']['editpatch'] = true;
$wgNamespaceProtection[PUSHFEED] = Array( "editpushfeed" );
$wgNamespacesWithSubpages[PUSHFEED] = true;
$wgGroupPermissions['*']['editpushfeed'] = false;
$wgGroupPermissions['sysop']['editpushfeed'] = true;
$wgNamespaceProtection[PULLFEED] = Array( "editpullfeed" );
$wgNamespacesWithSubpages[PULLFEED] = true;
$wgGroupPermissions['*']['editpullfeed'] = false;
$wgGroupPermissions['sysop']['editpullfeed'] = true;
$wgNamespaceProtection[CHANGESET] = Array( 'editchangeset' );
$wgNamespacesWithSubpages[CHANGESET] = true;
$wgGroupPermissions['*']['editchangeset'] = false;
$wgGroupPermissions['sysop']['editchangeset'] = true;

require_once( dirname( __FILE__ ) . '/specials/ArticleAdminPage.php' );
require_once( dirname( __FILE__ ) . '/specials/DSMWAdmin.php' );
require_once( dirname( __FILE__ ) . '/specials/DSMWGeneralExhibits.php' );

// semantic mediawiki extension
$smwgNamespaceIndex = 120;
