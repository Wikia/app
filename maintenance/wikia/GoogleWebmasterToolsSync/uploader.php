<?php
global $IP;
require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/setup.php');
echo "Not implemented !\n";
die();
$service = new WebmasterToolsUtil();

var_dump($service->getInfo( 'caillou' ));
//var_dump($service->getInfo( 'visualkei' ));
//var_dump($service->verify( 'visualkei', null, true ));
//var_dump($service->add( 5915, new UserCredentials('wikiawebtools001', 'Ugah6zeiCh')));
//var_dump($service->verify( 5915, new UserCredentials('wikiawebtools001', 'Ugah6zeiCh')));
//var_dump ();
//var_dump($service->getInfo( 3490 ));
//var_dump($service->getInfo( 1346 ));


//UserMailer::send(
//	new MailAddress( 'adamr@wikia-inc.com' ),
//	new MailAddress( 'testadam@wikia-inc.com' ),
//	'alert test',
//	'testing mail alert sending'
//);

global $wgExternalSharedDB;
$app = F::app();

$db = $app->wf->getDB( DB_MASTER, array(), $wgExternalSharedDB);

//get last upload date, so we can check for wikis added after that date
$row = $db->selectRow(
	'webmaster_sitemaps',
	array( 'MAX(upload_date)' ),
	array(),
	'WebmasterSitemapsUploader'
);
//if lastUpload not set, check only today added wikis
$lastUpload = ( !empty( $row ) ) ? reset( $row ) : date( 'Y-m-d', time() );

//get all wikis that need a sitemap
//get data from analytics module
//$id = 3000;
//save it to db
//$db->insert(
//	array( 'webmaster_sitemaps' ),
//	array( 'wiki_id' => $id ),
//	'WebmasterSitemapsUploader'
//);

//select wikis to update
//TODO: get date from command line?
//TODO: get certain wiki from command line?

//get date from command line
if ( isset( $argv[ 2 ] ) ) {
	$time = strtotime( $argv[ 2 ] );
	$formatedDate = date('Ymd', $time);
}
$where = array(
	'ws.wiki_id = cl.city_id'
);
$where[] = isset( $formatedDate ) ? "upload_date IS NULL OR date_format( upload_date, '%Y%m%d' ) <= date'{$formatedDate}'" :
	"upload_date IS NULL";

$result = $db->select(
	array( 'ws' => 'webmaster_sitemaps', 'cl' => 'city_list' ),
	array( 'wiki_id', 'city_url' ),
	$where,
	'WebmasterSitemapsUploader'
);

while( $row = $result->fetchRow() ) {
	//connect to google and try to upload sitemap
	print_r( $row );

	//if success
//	$db->update(
//		array( 'webmaster_sitemaps' ),
//		array( 'user_id' => $userId, 'upload_date' => 'NOW()' ),
//		array( "wiki_id = {$id}"),
//		'WebmasterSitemapsUploader'
//	);
}

