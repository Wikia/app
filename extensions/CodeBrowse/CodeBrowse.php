<?php

/**
 * CodeBrowse
 * Requires CodeReview
 * License: GPLv2
 * Author: Bryan Tong Minh
 */

$dir = dirname( __FILE__ );
$wgAutoloadClasses['CodeBrowseView'] = $dir.'/CodeBrowseView.php';
$wgAutoloadClasses['CodeBrowseItemView'] = $dir.'/CodeBrowseItemView.php';
$wgAutoloadClasses['CodeBrowseRepoListView'] = $dir.'/CodeBrowseRepoListView.php';
// Override this from CodeReview
$wgAutoloadClasses['CodeRepoListView'] = $dir.'/CodeBrowseRepoListView.php';
$wgAutoloadClasses['SpecialCodeBrowse'] = $dir.'/SpecialCodeBrowse.php';
$wgSpecialPages['CodeBrowse'] = 'SpecialCodeBrowse';

$wgExtensionMessagesFiles['CodeBrowse'] = $dir . '/CodeBrowse.i18n.php';
