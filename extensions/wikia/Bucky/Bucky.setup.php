<?php
/**
 * Real User Monitoring
 *
 * @author wladek
 */

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['Bucky'] =  $dir . 'Bucky.class.php';

$wgHooks['WikiaSkinTopScripts'][] = 'Bucky::onWikiaSkinTopScripts';
