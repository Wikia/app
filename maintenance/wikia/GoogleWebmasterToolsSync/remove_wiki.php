<?php
/**
 * User: artur
 * Date: 17.04.13
 * Time: 19:24
 */

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/remove_wiki.php  --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php -i 652441

$optionsWithArgs = array( 'i' );

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/init.php');

if( !isset($options['i']) ) {
	echo "Specify wikiid (-i)";
}

$wikiRepository = new GWTWikiRepository();

$wikiRepository->deleteAllByWikiId( $options['i'] );
