<?php
/**
 * Event handling hooks to update ImageReview data when files are uploaded,
 * deleted and restored.
 */

$wgAutoloadClasses['ImageReviewEventsHooks'] = __DIR__ . '/ImageReviewEventsHooks.class.php';

$wgHooks['FileUpload'][] = 'ImageReviewEventsHooks::onFileUpload';
$wgHooks['UploadComplete'][] = 'ImageReviewEventsHooks::onUploadComplete';
$wgHooks['FileRevertComplete'][] = 'ImageReviewEventsHooks::onFileRevertComplete';
$wgHooks['ArticleDeleteComplete'][] = 'ImageReviewEventsHooks::onArticleDeleteComplete';
$wgHooks['ArticleUndelete'][] = 'ImageReviewEventsHooks::onArticleUndelete';
$wgHooks['OldFileDeleteComplete'][] = 'ImageReviewEventsHooks::onOldFileDeleteComplete';
$wgHooks['OldImageRevisionVisibilityChange'][] = 'ImageReviewEventsHooks::onOldImageRevisionVisibilityChange';
$wgHooks['CloseWikiPurgeSharedData'][] = 'ImageReviewEventsHooks::onCloseWikiPurgeSharedData';

// SUS-2988 | bind to custom hooks and add these uploads to image review queue
// TODO: refactor to use a generic upload handling (SUS-3045)
$wgHooks['AchievementsImageUpload'][] = 'ImageReviewEventsHooks::addTitleToTheQueue';
$wgHooks['ThemeDesignerSaveImage'][] = 'ImageReviewEventsHooks::addTitleToTheQueue';
$wgHooks['VisualEditorAddMedia'][] = 'ImageReviewEventsHooks::addTitleToTheQueue';
$wgHooks['WikiaMiniUploadInsertImage'][] = 'ImageReviewEventsHooks::addTitleToTheQueue';
$wgHooks['WikiaPhotoGalleryUpload'][] = 'ImageReviewEventsHooks::addTitleToTheQueue';

// Image Review information on file pages
$wgHooks['ImagePageAfterImageLinks'][] = 'ImageReviewEventsHooks::onImagePageAfterImageLinks';
