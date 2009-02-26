<?php
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named WikiFactory.\n";
    exit( 1 ) ;
}

if ( !function_exists( 'extAddSpecialPage' ) ) {
    require_once ( "$IP/extensions/ExtensionFunctions.php" );
}

$wgHooks['wgQueryPages'][] = 'wfSetupGraceExpired';
$wgExtensionFunctions[] = 'wfSetupGraceExpired';

$wgExtensionMessagesFiles["Graceexpired"] = dirname(__FILE__) . '/SpecialGraceExpired.i18n.php';

extAddSpecialPage( dirname(__FILE__) . '/SpecialGraceExpired_body.php', 'Graceexpired', 'GraceExpiredSpecialPage' );

function wfSetupGraceExpired( $queryPages = array() ) {
    $queryPages[] = array( 'GraceExpiredPage', 'Graceexpired');
    return true;
}


if (!function_exists('wfGetGraceExpiredPages')) {
    function wfGetGraceExpiredPages($article_id) {
        $class = new GraceExpiredSpecialPage();
        $class->execute($article_id, 1, 0, false);
        $data = $class->getResult();
        
        return $data;
    }
}
