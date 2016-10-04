<?php

$dir = __DIR__ . '/';

// Load Classes
$wgAutoloadClasses['ArchiveWikiForumController'] =  $dir . 'ArchiveWikiForumController.class.php' ;
$wgAutoloadClasses['ArchiveWikiForumHooks'] =  $dir . 'ArchiveWikiForumHooks.class.php' ;

// Register Hooks
$wgHooks['getUserPermissionsErrors'][] = 'ArchiveWikiForumHooks::onGetUserPermissionsErrors';
$wgHooks['PageHeaderIndexAfterActionButtonPrepared'][] = 'ArchiveWikiForumHooks::onPageHeaderIndexAfterActionButtonPrepared';
$wgHooks['ArticleViewHeader'][] = 'ArchiveWikiForumHooks::onArticleViewHeader';
