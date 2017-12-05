<?php
/**
 * Event handling hooks to update ImageReview data when files are uploaded,
 * deleted and restored.
 */

$wgAutoloadClasses['ImageReviewEventsHooks'] = __DIR__ . '/ImageReviewEventsHooks.class.php';

// SUS-3045 | Push all uploads to image review queue
$wgHooks['FileUpload'][] = 'ImageReviewEventsHooks::onFileUpload';

$wgHooks['FileRevertComplete'][] = 'ImageReviewEventsHooks::onFileRevertComplete';
$wgHooks['ArticleDeleteComplete'][] = 'ImageReviewEventsHooks::onArticleDeleteComplete';
$wgHooks['ArticleUndelete'][] = 'ImageReviewEventsHooks::onArticleUndelete';
$wgHooks['OldFileDeleteComplete'][] = 'ImageReviewEventsHooks::onOldFileDeleteComplete';
$wgHooks['OldImageRevisionVisibilityChange'][] = 'ImageReviewEventsHooks::onOldImageRevisionVisibilityChange';
$wgHooks['CloseWikiPurgeSharedData'][] = 'ImageReviewEventsHooks::onCloseWikiPurgeSharedData';

// Image Review information on file pages
$wgHooks['ImagePageAfterImageLinks'][] = 'ImageReviewEventsHooks::onImagePageAfterImageLinks';
