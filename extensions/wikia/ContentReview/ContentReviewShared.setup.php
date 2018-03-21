<?php

/**
 * Wikia Content Review Shared classes
 */

/**
 * Models
 */
$wgAutoloadClasses['Wikia\ContentReview\Models\ContentReviewBaseModel'] = __DIR__ . '/models/ContentReviewBaseModel.php';
$wgAutoloadClasses['Wikia\ContentReview\Models\CurrentRevisionModel'] = __DIR__ . '/models/CurrentRevisionModel.php';
$wgAutoloadClasses['Wikia\ContentReview\Models\ReviewModel'] = __DIR__ . '/models/ReviewModel.php';

/**
 * Services
 */
$wgAutoloadClasses['Wikia\ContentReview\ContentReviewStatusesService'] = __DIR__ . '/services/ContentReviewStatusesService.class.php';

/**
 * Helpers
 */
$wgAutoloadClasses['Wikia\ContentReview\Helper'] = __DIR__ . '/ContentReviewHelper.php';
