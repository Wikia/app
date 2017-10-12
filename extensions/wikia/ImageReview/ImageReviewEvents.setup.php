<?php
/**
 * Event handling hooks to update ImageReview data when files are uploaded,
 * deleted and restored.
 */

$wgAutoloadClasses['ImageReviewEventsHooks'] = __DIR__ . '/ImageReviewEventsHooks.class.php';

$wgHooks['UploadComplete'][] = 'ImageReviewEventsHooks::onUploadComplete';
$wgHooks['FileRevertComplete'][] = 'ImageReviewEventsHooks::onFileRevertComplete';
$wgHooks['ArticleDeleteComplete'][] = 'ImageReviewEventsHooks::onArticleDeleteComplete';
$wgHooks['ArticleUndelete'][] = 'ImageReviewEventsHooks::onArticleUndelete';
$wgHooks['OldFileDeleteComplete'][] = 'ImageReviewEventsHooks::onOldFileDeleteComplete';
$wgHooks['OldImageRevisionVisibilityChange'][] = 'ImageReviewEventsHooks::onOldImageRevisionVisibilityChange';
$wgHooks['CloseWikiPurgeSharedData'][] = 'ImageReviewEventsHooks::onCloseWikiPurgeSharedData';
$wgHooks['VisualEditorAddMedia'][] = 'ImageReviewEventsHooks::onVisualEditorAddMedia';
