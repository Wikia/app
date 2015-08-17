<?php

$dir = dirname(__FILE__);
$wgAutoloadClasses['EditTaggingHooks'] = "$dir/EditTaggingHooks.class.php";

// tagging RTE edits
$wgHooks['ArticleSaveComplete'][] = 'EditTaggingHooks::onArticleSaveComplete';
$wgHooks['FormatSummaryRow'][] = 'EditTaggingHooks::onFormatSummaryRow';
$wgHooks['SpecialTags::UsedTags'][] = 'EditTaggingHooks::onUsedTags';

// tagging API edits
$wgHooks['ApiEditPage::SuccessfulApiEdit'][] = 'EditTaggingHooks::onSuccessfulApiEdit';

// tagging reverts
$wgHooks['ArticleRollbackComplete'][] = 'EditTaggingHooks::onArticleRollbackComplete';
