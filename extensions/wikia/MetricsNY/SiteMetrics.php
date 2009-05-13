<?php
$wgAvailableRights[] = 'metricsview';
$wgGroupPermissions['staff']['metricsview'] = true;
$wgGroupPermissions['sysop']['metricsview'] = true;
$wgGroupPermissions['helper']['metricsview'] = true;

$wgAutoloadClasses['SiteMetrics'] = "$IP/extensions/wikia/MetricsNY/SpecialSiteMetrics.php";
$wgSpecialPages['SiteMetrics'] = array('SiteMetrics','metricsview');

?>
