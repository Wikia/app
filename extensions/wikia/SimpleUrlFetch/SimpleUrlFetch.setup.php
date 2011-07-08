<?php
/**
 * SimpleUrlFetch
 * 
 * A very simple curl-based URL fetch service.
 * 
 * @author Michał Roszka <michal@wikia-inc.com>
 */
$wgExtensionCredits['other'][] = array(
    'name'        => 'SimpleUrlFetch',
    'description' => 'A very simple curl-based URL fetch service.',
    'version'     => '1.0',
    'author'      => array( 'Michał Roszka' )
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['SimpleUrlFetch'] = "$dir/SimpleUrlFetch.class.php";
$wgExtensionMessagesFiles['SimpleUrlFetch'] = $dir.'/SimpleUrlFetch.i18n.php';