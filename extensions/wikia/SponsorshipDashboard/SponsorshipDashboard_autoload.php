<?php

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['SponsorshipDashboardService'] = $dir . 'SponsorshipDashboardService.class.php';

// report class
$wgAutoloadClasses['SponsorshipDashboardReport'] = $dir . 'SDReport.class.php';

// report sources
$wgAutoloadClasses['SponsorshipDashboardSourceMobile'] = $dir . 'sources/SDSourceMobile.class.php';
$wgAutoloadClasses['SponsorshipDashboardSource'] = $dir . 'sources/SDSource.class.php';
$wgAutoloadClasses['SponsorshipDashboardSourceDatabase'] = $dir . 'sources/SDSourceDatabase.class.php';

// date provider classes
$wgAutoloadClasses['SponsorshipDashboardDateProvider'] = $dir . 'SDDateProvider.class.php';
$wgAutoloadClasses['SponsorshipDashboardDateProviderDay'] = $dir . 'SDDateProvider.class.php';
$wgAutoloadClasses['SponsorshipDashboardDateProviderMonth'] = $dir . 'SDDateProvider.class.php';
$wgAutoloadClasses['SponsorshipDashboardDateProviderYear'] = $dir . 'SDDateProvider.class.php';

// output formater classes
$wgAutoloadClasses['SponsorshipDashboardOutputFormatter'] = $dir . 'output/SDOutputFormatter.class.php';
$wgAutoloadClasses['SponsorshipDashboardOutputChart'] = $dir . 'output/SDOutputChart.class.php';
$wgAutoloadClasses['SponsorshipDashboardOutputTable'] = $dir . 'output/SDOutputTable.class.php';
$wgAutoloadClasses['SponsorshipDashboardOutputCSV'] = $dir . 'output/SDOutputCSV.class.php';

// Ajax
$wgAutoloadClasses[ 'SponsorshipDashboardAjax' ] = $dir . 'SponsorshipDashboardAjax.class.php';

$wgAutoloadClasses['gapi'] = $IP . '/lib/vendor/gapi/gapi.class.php';