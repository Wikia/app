<?php

/**
 * Insights - Popular Pages subpage that lists most viewed pages on a Wikia
 *
 * CAUTION
 * BELOW CLASSES HAVE DEPENDENCIES ON CLASSES FROM InsightsV2.setup.php - remember to load them as well
 *
 * This is subset config for Popular Pages Insights subpage
 * @author Kamil Koterba
 */

/**
 * Custom QueryPage sub-classes
 */
$wgAutoloadClasses['PopularPages'] = __DIR__ . '/specials/PopularPages.class.php';

/**
 * Special pages
 */
$wgSpecialPages['PopularPages'] = 'PopularPages';
$wgSpecialPageGroups['PopularPages'] = 'wikia';

/**
 * Models
 */
$wgAutoloadClasses['InsightsPopularPagesModel'] = __DIR__ . '/models/InsightsPopularPagesModel.php';
