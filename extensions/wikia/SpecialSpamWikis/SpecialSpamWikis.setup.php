<?php
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This code is a MediaWiki extension and cannot be executed standalone.\n";
    exit( 1 );
}
/**
 * 
 */
$wgExtensionCredits['other'][] = array(
    'name'        => 'SpecialSpamWikis',
    'description' => '',
    'version'     => '1.0',
    'author'      => array( 'Michał Roszka' )
);
$dir = dirname( __FILE__ );

$app = F::app();

$app->registerClass( 'SpecialSpamWikisController', "{$dir}/SpecialSpamWikisController.class.php" );
$app->registerClass( 'SpecialSpamWikisData', "{$dir}/SpecialSpamWikisData.class.php" );
$app->registerClass( 'SpecialSpamWikisSpecialPageController', "{$dir}/SpecialSpamWikisSpecialPageController.class.php" );

$wgExtensionMessagesFiles['SpecialSpamWikis'] = "{$dir}/SpecialSpamWikis.i18n.php";

$app->registerSpecialPage( 'SpamWikis', 'SpecialSpamWikisSpecialPageController' );

$wgGroupPermissions['*']['specialspamwikis'] = false;
$wgGroupPermissions['util']['specialspamwikis'] = true;
