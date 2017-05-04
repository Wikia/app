<?php

$dir = dirname( __FILE__ );

$wgAutoloadClasses['EpisodesNavController'] =  $dir . '/EpisodesNavController.class.php';
$wgAutoloadClasses['InfoboxEpisodes'] =  $dir . '/InfoboxEpisodes.class.php';
$wgAutoloadClasses['EpisodesNavHooks'] =  $dir . '/EpisodesNav.hooks.php';

$wgHooks['BeforePageDisplay'][] = 'EpisodesNavHooks::onBeforePageDisplay';
