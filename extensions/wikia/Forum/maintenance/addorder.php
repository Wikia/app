<?

/**
 * just create order indexes for wiki which already have forums
 *
 * TODO: delete ot after run
 *
 */


require_once( "helper.php" );
ini_set( "include_path", dirname( __FILE__ ) . "/../../../../maintenance/" );
require_once( "commandLine.inc" );


$forum = new Forum();
$forum->createOrders();
