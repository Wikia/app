<?php

/**
 * Insights - Templates without type
 *
 * CAUTION
 * BELOW CLASSES HAVE DEPENDENCIES ON CLASSES FROM Insights.setup.php - remember to load them as well
 *
 * This is subset config for Templates without type Insight subpage
 *
 * @author Kamil Koterba
 */

/**
 * Custom QueryPage sub-classes
 */
$wgAutoloadClasses['TemplatesWithoutTypePage'] = __DIR__ . '/specials/TemplatesWithoutTypePage.class.php';

/**
 * Special pages
 */
$wgSpecialPages['Templateswithouttype'] = 'TemplatesWithoutTypePage';
$wgSpecialPageGroups['Templateswithouttype'] = 'wikia';

/**
 * Models
 */
$wgAutoloadClasses['InsightsTemplatesWithoutTypeModel'] = __DIR__ . '/models/InsightsTemplatesWithoutTypeModel.php';

/**
 * Hooks
 */
$wgHooks['UserTemplateClassification::TemplateClassified'][] = 'InsightsHooks::onTemplateClassified';
